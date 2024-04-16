<?php

namespace App\Http\Controllers;

use App\Models\Expanditure;
use App\Models\Expanse;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function fetch_stocks(){
        // dd(1);
        $data = Stock::get();

        return view('admin-side.inventory.fetch_stocks', compact('data'));
    }
    public function store_stocks(Request $request)
    {
        // dd(2);
        $request->validate([
            
            'item_name' => 'required|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);
        // dd(1);
        $data = new Stock();
        $data->item_name = $request->input('item_name');
        $data->purchase_price = $request->input('purchase_price');
        $data->sale_price = $request->input('sale_price');
        $data->save();
        if ($data) {
            
            return back()->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }

    public function edit_stocks($id){
        // dd(1);
        $data = Stock::find($id);
        // dd($data);
        return view('admin-side.inventory.edit_stocks', compact('data'));

    }
    public function update_stocks(Request $request, $id){
        // dd(1);
        // dd($request->all());
        $data = Stock::find($id);
        $data->item_name = $request->input('item_name');
        $data->purchase_price = $request->input('purchase_price');
        $data->sale_price = $request->input('sale_price');
        $data->update();
        if ($data) {
            
            return redirect('show-stocks')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
    }
    public function destroy_stocks($id){
      
        $data = Stock::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-stocks')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
        }
    }
    
    //purchases-tables

    public function fetch_purchases(){
        // dd(1);
        $test = DB::table('stocks')->get();
        // dd($test);
        // $data = Purchase::get();
        $data= DB::table('purchases')
                ->join('stocks', 'stocks.id', '=', 'purchases.item_id')
                // ->join('orders', 'users.id', '=', 'orders.user_id')
                ->select('purchases.*', 'stocks.item_name as item_name', 'stocks.purchase_price')
                ->get();
        // dd($data);
        return view('admin-side.inventory.fetch_purchases', compact('data','test'));
    }
    public function store_purchases(Request $request)
    {
        // dd(2);
        // dd($request->all());
        $request->validate([
            
            'item_id' => 'required|max:255',
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        // dd(1);
        $data = new Purchase();
        $data->item_id = $request->input('item_id');
        $price = $data->purchase_price = $request->input('purchase_price');
        $quantity = $data->quantity= $request->input('quantity');
        $total = $price*$quantity;
        // dd($total);
        $data->total = $total;
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-purchases')->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }

    public function edit_purchases($id){
        // dd($id);
        $data = Purchase::find($id);
        $stock = Stock::all();
        // dd($data);
        // dd($stock);
        return view('admin-side.inventory.edit_purchases', compact('data','stock'));
       
    }
    public function update_purchases(Request $request, $id)
    {
        // dd($request->all());
        $data = Purchase::find($id);

        $data->item_id = $request->input('item_id');
        $price = $data->purchase_price = $request->input('purchase_price');
        $quantity = $data->quantity= $request->input('quantity');
        $total = $price*$quantity;
        // dd($total);
        $data->total = $total;
        $data->update();
        // dd($data);
        if ($data) {
            
            return redirect('show-purchases')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
        
    }
    
    public function destroy_purchases($id){
      
        $data = Purchase::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-purchases')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
        }
    }


    // Sales-table 
   

    public function fetch_sales(){
        // dd(1);
        $test = DB::table('stocks')->get();
        // dd($test);
        // $data = Purchase::get();
        $data= DB::table('sales')
                ->join('stocks', 'stocks.id', '=', 'sales.item_id')
                // ->join('orders', 'users.id', '=', 'orders.user_id')
                ->select('sales.*', 'stocks.item_name as item_name', 'stocks.sale_price')
                ->get();
        // dd($data);
        return view('admin-side.inventory.fetch_sales', compact('data','test'));
    }
    public function store_sales(Request $request)
    {
        // dd(2);
        // dd($request->all());
        $request->validate([
            
            'item_id' => 'required|max:255',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        // dd(1);
        $data = new Sale();
        $data->item_id = $request->input('item_id');
        $price = $data->sale_price = $request->input('sale_price');
        $quantity = $data->quantity= $request->input('quantity');
        $total = $price*$quantity;
        // dd($total);
        $data->total = $total;
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-sales')->with('success', 'Success! Record Added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Inserted');
        }
    }

    public function edit_sales($id){
        // dd($id);
        $data = Sale::find($id);
        $test = DB::table('stocks')->get();
        // dd($data);
        return view('admin-side.inventory.edit_sales', compact('data','test'));
       
    }
    public function update_sales(Request $request, $id)
    {
        // dd($request->all());
        $data = Sale::find($id);
        $data->item_id = $request->input('item_id');
        $price = $data->sale_price = $request->input('sale_price');
        $quantity = $data->quantity= $request->input('quantity');
        $total = $price*$quantity;
        // dd($total);
        $data->total = $total;
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-sales')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
        
    }
    
    public function destroy_sales($id){
      
        $data = Sale::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-sales')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
    }

    public function fetch_expanses(){
        // dd(1);
        $data = Expanse::get();

        return view('admin-side.inventory.fetch_expanses', compact('data'));
    }

    public function store_expanses(Request $request)
    {
        // dd(2);
        // dd($request->all());
        $request->validate([
            
            'title' => 'required|max:255',
        ]);
        // dd(1);
        $data = new Expanse();
        $data->title = $request->input('title');
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-expanses')->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }
    public function edit_expanses($id){
        //   dd($id);
          $data = Expanse::find($id);
          $test = DB::table('stocks')->get();
          // dd($data);
          return view('admin-side.inventory.edit_expanses', compact('data','test'));

    }
    public function update_expanses(Request $request, $id){
        // dd(1);
        $data = Expanse::find($id);
        $data->title = $request->input('title');
        $data->update();
        // dd($data);
        if ($data) {
            
            return redirect('show-expanses')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
        
    }

    
    public function destroy_expanses($id){
      
        $data = Expanse::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-expanses')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
    }
    public function fetch_expanditures(){
        // dd(1);
        $test = DB::table('expanses')->get();
        $data = Expanditure::get();

        // return view('admin-side.inventory.fetch_expanditures');
        return view('admin-side.inventory.fetch_expanditures', compact('test','data'));
    }

    public function store_expanditures(Request $request)
    {
        // dd(2);
        // dd($request->all());
        $request->validate([
            
            'title_id' => 'required|max:255',
            'description' => 'required|max:255',
            'amount' => 'required|max:255',
            'date' => 'required|max:255',
        ]);
        // dd(1);
        $data = new Expanditure();
        $data->title_id = $request->input('title_id');
        $data->description = $request->input('description');
        $data->amount = $request->input('amount');
        $data->date = $request->input('date');
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-expanditures')->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }

    public function edit_expanditures($id){
        // dd('edit');
         // dd($id);
         $data = Expanditure::find($id);
         $test = Expanse::all();
         // dd($data);
         // dd($test);
         return view('admin-side.inventory.edit_expanditures', compact('data','test'));

        
    }

    public function update_expanditures(Request $request,$id){
        // dd('update');
        $data = Expanditure::find($id);
        $data->title_id = $request->input('title_id');
        $data->description = $request->input('description');
        $data->amount = $request->input('amount');
        $data->date = $request->input('date');
        $data->update();
        // dd($data);
        if ($data) {
            
            return redirect('show-expanditures')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
        
    }
    public function destroy_expanditures($id){
        // dd('delete');
        $data = Expanditure::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-expanditures')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }

    }
    //  onchange
    public function getStates(Request $request)
    {
        $states = \DB::table('stocks')
            ->where('stocks.id', $request->country_id)
            ->get();
        
        if (count($states) > 0) {
            return response()->json($states);
        }
    }

    //getSales
    public function getSales(Request $request)
    {
        $states = \DB::table('stocks')
            ->where('stocks.id', $request->country_id)
            ->get();
        
        if (count($states) > 0) {
            return response()->json($states);
        }
    }

    








}
