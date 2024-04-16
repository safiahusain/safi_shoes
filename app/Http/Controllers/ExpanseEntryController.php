<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpanseEntry;
use App\Models\Expanse;

class ExpanseEntryController extends Controller
{
    public function fetch_expanse_entry()
{
   $expanse_entry = ExpanseEntry::get();
   $expanse = Expanse::get();

   return view('admin-side.Expanses.fetch_expanse_entry', compact('expanse_entry','expanse'));

}


   public function store_expanse_entry(Request $request)
   {

    $expanse_entry = new ExpanseEntry();

    $expanse_entry->expense_description = $request->expense_description; 
    $expanse_entry->expense_head = $request->expense_head; 
    $expanse_entry->amount = $request->amount; 
    $expanse_entry->date = $request->date; 

    $expanse_entry->save();


    if($expanse_entry)
    {
        return redirect('show-expanse-entry')->with('success',"Record Inserted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Inserted Failed!");
    }

   }



   public function edit_expanse_entry($id)
   {
    $expanse_entry = ExpanseEntry::find($id);
    $expanse = Expanse::get();
    
    return view('admin-side.Expanses.edit_expanse_entry', compact('expanse_entry', 'expanse'));
   }


   public function update_expanse_entry($id, Request $request)
   {

      $expanse_entry = ExpanseEntry::find($id);


      $expanse_entry->expense_description = $request->expense_description; 
      $expanse_entry->expense_head = $request->expense_head; 
      $expanse_entry->amount = $request->amount; 
      $expanse_entry->date = $request->date; 
  
      $expanse_entry->update();
  
  
      if($expanse_entry)
      {
          return redirect('show-expanse-entry')->with('success',"Record Updated Successfully");
      }
      else{
          return redirect()->back()->with('failed',"Record Updated Failed!");
      }

   }


    public function delete_expanse_entry($id)
    {

        $expanse_entry = ExpanseEntry::find($id)->delete();

        if($expanse_entry)
        {
            return redirect('show-expanse-entry')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deleted Failed!");
        }


    }


}
