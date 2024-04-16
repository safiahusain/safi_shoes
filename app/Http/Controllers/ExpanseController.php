<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expanse;
class ExpanseController extends Controller
{
    
    public function fetch_expanse()
    {
        $expanse = Expanse::get();
        return view('admin-side.Expanses.fetch_expanses' , compact('expanse'));
    }



    public function store_expanse(Request $request)
    {
        $expanse = new Expanse();

        $expanse->head_name = $request->head_name;

        $expanse->save();

        if($expanse)
        {
            return redirect('show-expanse')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }



    public function edit_expanse($id)
    {
        $expanse = Expanse::find($id);

        return view('admin-side.Expanses.edit_expanses', compact('expanse'));
    }



    public function update_expanse($id, Request $request)
{

    $expanse = Expanse::find($id);

    $expanse->head_name = $request->head_name;

    $expanse->update();


    if($expanse)
    {
        return redirect('show-expanse')->with('success',"Record Updated Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Updated Failed!");
    }

}


  public function delete_expanse($id)
  {

     $expanse = Expanse::find($id)->delete();

     if($expanse)
     {
         return redirect('show-expanse')->with('success',"Record deleted Successfully");
     }
     else{
         return redirect()->back()->with('failed',"Record deleted Failed!");
     }
  }


}
