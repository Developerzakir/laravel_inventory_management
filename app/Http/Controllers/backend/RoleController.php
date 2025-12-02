<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.pages.permission.all_permission', compact('permissions'));
    }

    public function create()
    {
        return view('admin.pages.permission.add_permission');
    }


    public function store(Request $request)
    {

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function edit($id)
    {
        $permissions = Permission::find($id);
        return view('admin.pages.permission.edit_permission', compact('permissions'));
    }


    public function update(Request $request)
    {
        $per_id = $request->id;

        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }


    public function destroy($id)
    {
        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    ////// Role methods /////
    public function allRoles()
    {
        $roles = Role::all();
        return view('admin.pages.role.all_role', compact('roles'));
    }
    // End Method 

    public function addRoles()
    {
        return view('admin.pages.role.add_role');
    }
    // End Method 

    public function storeRoles(Request $request)
    {

        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    }

    public function editRoles($id)
    {
        $roles = Role::find($id);
        return view('admin.pages.role.edit_role', compact('roles'));
    }
    // End Method 

    public function updateRoles(Request $request)
    {
        $role_id = $request->id;

        Role::find($role_id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);
    }
    // End Method 

    public function deleteRoles($id)
    {
        Role::find($id)->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
