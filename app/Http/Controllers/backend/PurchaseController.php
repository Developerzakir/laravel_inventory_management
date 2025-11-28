<?php

namespace App\Http\Controllers\backend;

use App\Models\Product; 
use App\Models\Purchase; 
use App\Models\Supplier; 
use App\Models\WareHouse;
use Illuminate\Http\Request;
use App\Models\PurchaseItem; 
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PurchaseController extends Controller
{
    public function allPurchase()
    {
        $allData = Purchase::with('purchaseItems')->orderBy('id','desc')->get();
        return view('admin.purchase.index',compact('allData')); 
    }

    public function addPurchase()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.purchase.create',compact('suppliers','warehouses'));
    }

     public function purchaseProductSearch(Request $request)
     {
        $query = $request->input('query');
        $warehouse_id = $request->input('warehouse_id');

        $products = Product::where(function($q) use ($query){
            $q->where('name', 'like', "%{$query}%")
            ->orwhere('code', 'like', "%{$query}%");
        })
        ->when($warehouse_id, function ($q) use ($warehouse_id){
            $q->where('warehouse_id',$warehouse_id);
        })
        ->select('id','name','code','price','product_qty')
        ->limit(10)
        ->get();

        return response()->json($products);
    }

    public function storePurchase(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'supplier_id' => 'required',
        ]);

      try {

        DB::beginTransaction();

        $grandTotal = 0;

        $purchase = Purchase::create([
            'date' => $request->date,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'discount' => $request->discount ?? 0,
            'shipping' => $request->shipping ?? 0,
            'status' => $request->status,
            'note' => $request->note,
            'grand_total' => 0, 
        ]);

        /// Store Purchase Items & Update Stock 

        foreach($request->products as $productData){
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $productData['net_unit_cost'] ?? $product->price;

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit cost is missing ofr the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $subtotal, 
                ]);

                 $product->increment('product_qty', $productData['quantity']); 

            }
            $purchase->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);

                DB::commit();

                $notification = array(
                    'message' => 'Purchase Stored Successfully',
                    'alert-type' => 'success'
                ); 
                return redirect()->route('all.purchase')->with($notification);  
        
        } catch (\Throwable $e) {
           DB::rollBack();
           return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editPurchase($id)
    {
        $editData = Purchase::with('purchaseItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.purchase.edit',compact('editData','suppliers','warehouses'));
    }

    public function updatePurchase(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $purchase = Purchase::findOrFail($id);

            $purchase->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
            ]);

            /// Get Old Purchase Items 
            $oldPurchaseItems = PurchaseItem::where('purchase_id', $purchase->id)->get();

            /// Loop for old purchase items and decrement product qty
            foreach ($oldPurchaseItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->decrement('product_qty', $oldItem->quantity);
                    // Decrement old quantity 
                }
            }

            /// Delete old Purchase Items 
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // loop for new products and insert new purchase items

            foreach ($request->products as $product_id => $productData) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'],
                    'stock' => $productData['stock'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'],
                ]);

                /// Update product stock by incremeting new quantity 
                $product = Product::find($product_id);
                if ($product) {
                    $product->increment('product_qty', $productData['quantity']);
                    // Increment new quantity
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Purchase Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.purchase')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   
    public function deletePurchase($id)
    {
        try {
            DB::beginTransaction();

            $purchase = Purchase::findOrFail($id);

            // Stock rollback 
            foreach ($purchase->purchaseItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $item->quantity);
                }
                
            }

            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // main purchase record delete
            $purchase->delete();

            DB::commit();

            return redirect()->route('all.purchase')->with([
                'message' => 'Purchase deleted successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('all.purchase')->with([
                'message' => 'Failed to delete: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
   
    
}
