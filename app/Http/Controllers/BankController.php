<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankHead;
use App\Models\BankEntry;

class BankController extends Controller
{
    public function fetch_bank_head()
    {
        $bank_head = BankHead::get();
        return view('admin-side.banks.fetch_bank_head', compact('bank_head'));
    }
    
    
    public function store_bank_head(Request $request)
    {
        
        $bank_head = new BankHead();
        
        $bank_head->bank_name = $request->bank_name;
        $bank_head->ac_number = $request->ac_number;
        $bank_head->address = $request->address;
        
        $bank_head->save();
        
        
         if( $bank_head){
        return redirect('show-bank-head')->with('success',"Record Inserted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Insertion Failed!");
    }
        
        
    }
    
    
    
    public function edit_bank_head($id)
    {
        $bank_head = BankHead::find($id);
        
        return view('admin-side.banks.edit_bank_head', compact('bank_head'));
        
    }
    
    
    public function update_bank_head($id, Request $request)
    {
        $bank_head = BankHead::find($id);
        
          $bank_head->bank_name = $request->bank_name;
        $bank_head->ac_number = $request->ac_number;
        $bank_head->address = $request->address;
        
        $bank_head->update();
        
        
         if( $bank_head){
        return redirect('show-bank-head')->with('success',"Record Updated Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Updated Failed!");
    }
    }
    
    
    public function delete_bank_head($id)
    {
        $bank_head = BankHead::find($id)->delete();
        
         if( $bank_head){
        return redirect('show-bank-head')->with('success',"Record Deleted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Deleted Failed!");
    }
    }
    
    
    
    
    //   bank entries contoller 
    
    
    public function fetch_bank_entry()
    {
        $bank_entry = BankEntry::get();
        $bank_head = BankHead::get();
        return view('admin-side.banks.fetch_bank_entry', compact('bank_entry', 'bank_head'));
    }
    
    
    
     public function store_bank_entry(Request $request)
    {
        
        $bank_entry = new BankEntry();
        
        $bank_entry->bank_name = $request->bank_name;
        $bank_entry->description = $request->description;
        $bank_entry->date = $request->date;
        $bank_entry->amount = $request->amount;
        $bank_entry->check_w_d = $request->check_w_d;
        
        $bank_entry->save();
        
        
         if( $bank_entry){
        return redirect('show-bank-entry')->with('success',"Record Inserted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Insertion Failed!");
    }
        
        
    }
    
    
     
    public function edit_bank_entry($id)
    {
        $bank_head = BankHead::get();
        $bank_entry = BankEntry::find($id);
        
        return view('admin-side.banks.edit_bank_entry', compact('bank_head', 'bank_entry'));
        
    }
    
    
    
     public function update_bank_entry($id, Request $request)
    {
        $bank_entry = BankEntry::find($id);
        
        $bank_entry->bank_name = $request->bank_name;
        $bank_entry->description = $request->description;
        $bank_entry->date = $request->date;
        $bank_entry->amount = $request->amount;
        $bank_entry->check_w_d = $request->check_w_d;
        
        $bank_entry->save();
        
        
         if( $bank_entry){
        return redirect('show-bank-entry')->with('success',"Record Updated Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Updated Failed!");
    }
    
    
    }
    
    
    
    
      public function delete_bank_entry($id)
    {
        $bank_entry = BankEntry::find($id)->delete();
        
         if( $bank_entry){
        return redirect('show-bank-entry')->with('success',"Record Deleted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Deleted Failed!");
    }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
