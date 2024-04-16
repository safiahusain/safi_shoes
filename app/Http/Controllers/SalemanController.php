<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saleman;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class SalemanController extends Controller
{
    //
     public function fetch_saleman(){

        $data = saleman::all();
        $branches = branch::all();
       
        return view('admin-side.salesman.fetch_saleman',compact('data', 'branches'));
    }
    
    public function store_saleman(Request $request){
       
        $data = new Saleman();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->status = 'Active';
        // $data->name = $request->input('address');
        // $data->name = $request->input('name');

        $data->save();

        if($data){
            return redirect('show-saleman')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }




        public function edit_saleman($id)
        {
        
       
         $data = saleman::find($id);
         return view('admin-side.salesman.edit_saleman',compact('data'));
     }



    public function update_saleman(Request $request, $id){

        $data = saleman::find($id);

        $data->name = $request->input('name');
        $data->phone = $request->input('phone');
        $data->email = $request->input('email');
        $data->status = $request->input('status');

        $data->update();

        if($data){
            return redirect('show-saleman')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
   
   
        public function delete_saleman($id){
    
        $data = saleman::find($id)->delete();
        
        if($data){
            return redirect('show-saleman')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}
