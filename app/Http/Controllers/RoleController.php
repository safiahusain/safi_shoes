<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::all();
        return view('admin-side.roles.index', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
            ]);
            
            $role = new Role;
            
            $role->name = $request->role_name;
            $role->save();
            
             if($role){

                return redirect(route('admin.roles.index'))->with('success',"Role Inserted Successfully");
            }
            else{
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
                    
    }
    
    
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin-side.roles.edit', compact('role', 'permissions'));
    }
    
    
    
    public function update(Request $request, Role $role)
    {
        $role = Role::find($role->id);
        
        $role->name = $request->role_name;
        
        $role->update();
        
        
             if($role){

                return redirect(route('admin.roles.index'))->with('success',"Role Updated Successfully");
            }
            else{
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
    }
    
    
    public function destroy(Role $role)
    {
        $user   =   User::where('role_id',$role->id)->first();
        
        if(!$user)
        {
            Role::find($role->id)->delete();
            
            if($role)
            {
                return redirect(route('admin.roles.index'))->with('success',"Role Deleted Successfully");
            }
            else
            {
                return redirect()->back()->with('error',"Record Insertion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('error',"Role already assign to user So you have no permission to delete this role");
        }
    }
    
    
    
    public function givePermission(Request $request, Role $role)
    {
        
        
        // Check if a user has a permission
        // dd($role);
        if($role->hasPermissionTo($request->permission_name))
        {
            return redirect()->back()->with('error',"Permission Exists");
        }
        
        $role->givePermissionTo($request->permission_name);
        return redirect()->back()->with('success',"Give Permission Successfully");
    }
    
    
    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
            return redirect()->back()->with('message',"Permission delete successfully");
        }
        return redirect()->back()->with('message','Permission not exists');
    }
    
    
    
}
