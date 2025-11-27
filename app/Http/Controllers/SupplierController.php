<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

    ///// Customer Method All 

    public function allCustomer()
    {
        $customer = Customer::latest()->get();
        return view('admin.customer.all_customer',compact('customer'));
    }
    //End Method 

    public function addCustomer(){ 
        return view('admin.customer.add_customer');
    }
    //End Method 

    public function storeCustomer(Request $request)
    {
 
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.customer')->with($notification);
    }
 
    public function editCustomer($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit_customer',compact('customer')); 
    }
        
    public function updateCustomer(Request $request)
    {
        $cust_id = $request->id;

        Customer::find($cust_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
            ); 
        return redirect()->route('all.customer')->with($notification);

    }

    public function deleteCustomer($id)
    {
        Customer::find($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
            ); 
        return redirect()->back()->with($notification);
    }

   
   
}
