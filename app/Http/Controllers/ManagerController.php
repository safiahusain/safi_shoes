<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 class ManagerController extends Controller
{
    public function fetch_manager(){

        // $data = DB::table('managers')
        // ->join('branches', 'branches.id','=','managers.branch_id')
        // ->select('managers.*', 'branches.name as branch_name')
        // ->get();
        $data = manager::all();
        // dd($data);
        $branches = Branch::all();
        return view('admin-side.managers.fetch_manager',compact('data','branches'));
    }
    public function store_manager(Request $request){
        // dd($request->all());
      
        $data = new Manager();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        $data->branch_id = $request->input('branch_id');
        $data->date = $request->input('date');
        $data->open_balance = $request->input('open_balance');
        $data->dues_balance = $request->input('dues_balance');
        $data->save();
        if($data){
            return redirect('show-manager')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }


    public function edit_manager($id){
        
        $data = Manager::find($id);
        $branches = Branch::all();
        return view('admin-side.managers.edit_manager',compact('data','branches'));
    }

    

    public function update_manager(Request $request, $id){

        $data = Manager::find($id);

        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        $data->branch_id = $request->input('branch_id');
        $data->date = $request->input('date');
        $data->open_balance = $request->input('open_balance');
        $data->dues_balance = $request->input('dues_balance');
        $data->update();

        if($data){
            return redirect('show-manager')->with('success',"Record Updated Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }

    public function destroy_manager($id){

        $data = Manager::find($id)->delete();
        
        if($data){
            return redirect('show-manager')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}