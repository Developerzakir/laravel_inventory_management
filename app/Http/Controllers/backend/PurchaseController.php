<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product; 
use App\Models\Supplier; 
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Purchase; 
use App\Models\PurchaseItem; 

class PurchaseController extends Controller
{
    public function allPurchase()
    {
        $allData = Purchase::orderBy('id','desc')->get();
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
}
