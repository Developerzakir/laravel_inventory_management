<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::latest()->get();
        return view('admin.supplier.index',compact('supplier'));
    }
  

    public function create()
    { 
        return view('admin.supplier.create');
    }

    public function store(Request $request){
 
        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.supplier')->with($notification);

    }
 

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('admin.supplier.edit',compact('supplier'));
    }
    //End Method 

    public function update(Request $request)
    {
        $supp_id = $request->id;

        Supplier::find($supp_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.supplier')->with($notification);

    }
   

    public function destroy($id)
    {
        Supplier::find($id)->delete();

        $notification = array(
            'message' => 'Supplier Delete Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);

    }
   
   
}
