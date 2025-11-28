<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

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
 
    
   
}
