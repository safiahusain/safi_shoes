<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\warehouse;
use App\Models\User;

class WarehouseController extends Controller
{
    //
    public function create()
    {
        $branches   =   branch::all();
        $data       =   warehouse::all();
        $users      =   User::where('role_id',5)->get();
        return view('admin-side.warehouses.ret-warehouse', compact('branches', 'data', 'users'));
    }

    public function store_warehouse(Request $request)
    {
        $warehouse = new warehouse();

        $warehouse->name  = $request->input('name');
        $warehouse->user_id  = $request->user_id;
        $warehouse->phone  = $request->phone;
        $warehouse->address  = $request->address;
        $warehouse->branch_id  = $request->branch_id;
        $warehouse->date  = $request->date;
        $warehouse->open_balance  = $request->open_balance;

        $warehouse->save();

        return redirect()->back();

    }

    public function edit_warehouse($id)
    {
        $data = warehouse::where('id', $id)->first();
        // $branches = branch::all();
        $users      =   User::where('role_id',5)->get();

        return view('admin-side.warehouses.edit-warehouse', compact('data','users'));
    }

    public function update_warehouse(Request $request, $id)
    {
        $warehouse = warehouse::find($id);

         $warehouse->name  = $request->input('name');
         $warehouse->user_id  = $request->user_id;
         $warehouse->phone  = $request->phone;
         $warehouse->address  = $request->address;
         $warehouse->branch_id  = $request->branch_id;
         $warehouse->date  = $request->date;
         $warehouse->open_balance  = $request->open_balance;

         $warehouse->update();

         return redirect(url('show-warehouse'));

    }


    public function delete_warehouse($id)
    {
        $data = warehouse::find($id)->delete();

        if($data){
            return redirect('show-warehouse')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }

    
    }


}
