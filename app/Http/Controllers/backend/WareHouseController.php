<?php

namespace App\Http\Controllers\backend;

use App\Models\WareHouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WareHouseController extends Controller
{
     public function index()
     {
        $warehouse = WareHouse::latest()->get();
        return view('admin.warehouse.index',compact('warehouse'));
    }

    public function create()
    { 
        return view('admin.warehouse.create');
    }
  

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ware_houses,email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        WareHouse::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

        $notification = array(
            'message' => 'WareHouse Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.warehouse')->with($notification);

    }


    public function edit($id)
    {
        $warehouse = WareHouse::find($id);
        return view('admin.warehouse.edit',compact('warehouse'));
    }
    


     public function update(Request $request)
     {
        $ware_id = $request->id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ware_houses,email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        WareHouse::find($ware_id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

        $notification = array(
            'message' => 'WareHouse Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.warehouse')->with($notification);

    }
   

    public function destroy($id)
    {
        WareHouse::find($id)->delete();

        $notification = array(
            'message' => 'WareHouse Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification); 
    }

    


}
