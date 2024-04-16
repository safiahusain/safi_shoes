<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchUser;

class BranchUserController extends Controller
{
    
    public function fetch_branch_user(){

        $data = BranchUser::get();
        return view('admin-side.branch_user.fetch_branch_user',compact('data'));
    }
    public function store_branch_user(Request $request){
        
        
        $data = new BranchUser();
        // dd(1);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone_number');
        $data->address = $request->input('branch_address');
        $data->manager_name = $request->input('manager_name');
        // $data->date = $request->input('date');
        
        $data->save();
        if($data){
            return redirect('show-branch')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    
    
    public function edit_branch_user($id){
        
        $data = BranchUser::find($id);
        return view('admin-side.branch_user.edit_branch_user',compact('data'));
    }
    
    

    public function update_branch_user(Request $request, $id){

       
        $data = BranchUser::find($id);

        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone_number');
        $data->address = $request->input('branch_address');
        $data->manager_name = $request->input('manager_name');
        
        $data->update();

        return redirect('show-branch');

    }
    
    
    public function destroy_branch_user($id){

        $data = BranchUser::find($id)->delete();
        
        if($data){
            
            return redirect('show-branch')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}
