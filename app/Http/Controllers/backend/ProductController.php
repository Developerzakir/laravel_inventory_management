<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
     public function index()
     {
        $category = ProductCategory::latest()->get();
        return view('admin.category.index',compact('category'));
    }

    public function store(Request $request)
    {
        ProductCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
        ]);

        $notification = array(
            'message' => 'ProductCategory Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
    }


    public function edit($id)
    {
        $category = ProductCategory::find($id);
        return response()->json($category);
     }

      public function update(Request $request)
      {
        $cat_id = $request->cat_id;

        ProductCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
        ]);

        $notification = array(
            'message' => 'ProductCategory Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        ProductCategory::find($id)->delete();
        $notification = array(
            'message' => 'ProductCategory Delete Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
    }


     ///// Add Product all Methods /////// 


    public function allProduct()
    {
        $allData = Product::orderBy('id','desc')->get();
        return view('admin.product.index',compact('allData'));
    }
   
    public function addProduct()
    {
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.product.create',compact('categories','brands','suppliers','warehouses')); 
    }

    public function storeProduct(Request $request)
    {

        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
            'stock_alert' => $request->stock_alert,
            'note' => $request->note,
            'product_qty' => $request->product_qty,
            'status' => $request->status,
            'created_at' => now(), 
        ]);

        $product_id = $product->id;

        /// Multiple Image Upload 
        if ($request->hasFile('image')) {
           foreach($request->file('image') as $img) {
           $manager = new ImageManager(new Driver());
           $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
           $imgs = $manager->read($img);
           $imgs->resize(150,150)->save(public_path('upload/productimg/'.$name_gen));
           $save_url = 'upload/productimg/'.$name_gen;

           ProductImage::create([
            'product_id' => $product_id,
            'image' => $save_url
           ]);
           }
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.product')->with($notification);
    }

    public function editProduct($id)
    {
        $editData = Product::find($id);
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $multiimg = ProductImage::where('product_id',$id)->get();
        return view('admin.product.edit',compact(
            'categories',
            'brands',
            'suppliers',
            'warehouses',
            'editData',
            'multiimg'
        )); 
    }

    public function updateProduct(Request $request)
    {
         $pro_id = $request->id;

        $product = Product::findOrFail($pro_id);

        $product->name = $request->name;
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->stock_alert = $request->stock_alert;
        $product->note = $request->note;
        $product->warehouse_id = $request->warehouse_id;
        $product->supplier_id = $request->supplier_id;
        $product->product_qty = $request->product_qty;
        $product->status = $request->status;
        $product->save();

        if ($request->hasFile('image')) {
            foreach($request->file('image') as $img) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $imgs = $manager->read($img);
            $imgs->resize(150,150)->save(public_path('upload/productimg/'.$name_gen)); 

            $product->images()->create([
                'image' => 'upload/productimg/'.$name_gen
            ]); 

            }
         }


        if ($request->has('remove_image')) {
            foreach($request->remove_image as $removeImageId) {
                $img = ProductImage::find($removeImageId);
                if ($img ) {
                    if (file_exists(public_path($img->image))) {
                       unlink(public_path($img->image));
                    }
                    $img->delete();
                }
            }
        }

        $notification = array(
            'message' => 'Product Updaetd Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.product')->with($notification); 
    }


    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        /// Delete associated images
        $images = ProductImage::where('product_id',$id)->get();
        foreach($images as $img){
            $imagePath = public_path($img->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete image from records
        ProductImage::where('product_id',$id)->delete();

        // Delete the product 
        $product->delete();

           $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);

    }
     

   
 
    
   
}
