<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin-side.permissions.index', compact('permissions'));
    }
    
    public function store(Request $request)
    {
        
          $request->validate([
        'name' => 'unique:permissions',
        
    ]);
        
        $permission = new Permission;
        
        $permission->name = $request->permission_name;
        
        $permission->save();
        
        return to_route('admin.permissions.index');
    }
    
    
      public function edit(Permission $permission)
    {
        $permission = Permission::find($permission->id);
        $roles = Role::all();
        return view('admin-side.permissions.edit', compact('permission', 'roles'));
    }
    
    
     public function update(Permission $permission, Request $request)
    {
        
        $permission = Permission::find($permission->id);
        
        $permission->name = $request->permission_name;
        
        $permission->update();
        
        return to_route('admin.permissions.index');
    }
    
    
    public function destroy(Permission $permission)
    {
        Permission::find($permission->id)->delete();
        
        return to_route('admin.permissions.index');
    }
    
    
    public function revokeRole(Permission $permission, Role $role)
    {
        if($permission->hasRole($role)){
            $permission->removeRole($role);
            return redirect()->back()->with('message', 'Role deleted');
        }
        return redirect()->back()->with('message', 'Role not exists');
    }
    
    
    public function giveRole(Permission $permission, Request $request)
    {
        if($permission->hasRole($request->role_name))
        {
            return redirect()->back()->with('message', 'already exists');
        }
        
        $permission->assignRole($request->role_name);
        return redirect()->back()->with('message', 'successfully assign');
    }
    
    
    
    
}
