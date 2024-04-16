<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function fetch_brand(){

        $data = DB::table('brands')
        ->get();
        // dd($data);
        $branches = Branch::all();
        return view('admin-side.branches.brands.fetch_brand',compact('data','branches'));
    }
    public function store_brand(Request $request){
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            ],
             [
            'name.required' => 'Brand-Name is required',
        ]);
       
        $data = new Brand();
        $data->name = $request->input('name');
        $data->save();
        if($data){
            return redirect('show-brand')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_brand($id){
        
        $data = Brand::find($id);
        $branches = Branch::all();
        return view('admin-side.branches.brands.edit_brand',compact('data','branches'));
    }

    public function update_brand(Request $request, $id){

        $data = Brand::find($id);
        $data->name = $request->input('name');
        $data->update();

        if($data){
            return redirect('show-brand')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function destroy_brand($id){
        // dd(4);
        $data = Brand::find($id)->delete();
        
        if($data){
            return redirect('show-brand')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}
