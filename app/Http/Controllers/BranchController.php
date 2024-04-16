<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class BranchController extends Controller
{
    public function fetch_branch(){

        $data = User::get();
        $roles = Role::get();
        // dd($roles);
        return view('admin-side.branches.fetch_branch',compact('data', 'roles'));
    }
    public function store_branch(Request $request){
        
        // dd($request->all());

        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
      
       
        $data = new user();
        // dd(1);
        $data->name = $request->input('name');
        $data->role = $request->input('role');
        $data->email = $request->input('email');
        $data->phone_number = $request->input('phone_number');
        $data->branch_address = $request->input('branch_address');
        $data->manager_name = $request->input('manager_name');
        // $data->date = $request->input('date');
        $data->password = Hash::make($request->password);

        $data->assignRole($request->role);
        $data->save();
        // dd(2);
        if($data){
            return redirect('show-branch')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_branch($id){
        
        $data = User::find($id);
         $roles = Role::get();
        return view('admin-side.branches.edit_branch',compact('data','roles'));
    }

    public function update_branch(Request $request, $id){

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        
        // dd($request->all());
        $data = User::find($id);

        $data->name = $request->input('name');
        $data->role = $request->input('role');
        $data->email = $request->input('email');
        $data->phone_number = $request->input('phone_number');
        $data->branch_address = $request->input('branch_address');
        $data->manager_name = $request->input('manager_name');
        


        #Match The Old Password
        if(!Hash::check($request->old_password, Auth::user()->password)){
            $error = "old password is incorrect";
        }
        else{
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
    }
    
        $data->assignRole($request->role);
        $data->update();

        return redirect('show-branch');

        //   return back()->with("status", "Password changed successfully!");
        // if($data){
        //     return redirect('show-branch')->with('success',"Record Updated Successfully");
        // }
        // else{
        //     return redirect()->back()->with('failed',"Record Updation Failed!");
        // }
    }
    public function destroy_branch($id){

        $data = User::find($id)->delete();
        
        if($data){
            return redirect('show-branch')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}
