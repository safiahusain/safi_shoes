<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Color;
use App\Models\Company;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function fetch_stock(){

        // $data = DB::table('stocks')
        // ->join('companies','companies.id','=','stocks.company_id')
        // ->join('brands','brands.id','=','stocks.brand_id')
        // ->join('categories','categories.id','=','stocks.category_id')
        // ->join('colors','colors.id','=','stocks.color_id')
        // ->join('sizes','sizes.id','=','stocks.size_id')
        // ->select('stocks.*', 'companies.name as company', 'brands.name as brand','categories.name as category', 'colors.name as color', 'sizes.name as size',
        // )
        // ->get();

        $data = stock::all();
        // dd($datas);
        $companies = Company::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        $categories = Category::all();
        return view('admin-side.stocks.fetch_stock',compact('data','companies','brands','colors','sizes','categories'));
    }
    public function store_stock(Request $request){
        // dd($request->asll());
       
        $data = new Stock();
        $data->name = $request->input('name');
        $data->item_code = $request->input('item_code');
        $data->category_id = $request->input('category_id');
        $data->color_id = $request->input('color_id');
        // $data->size_id = $request->input('size_id');
        $data->company_id = $request->input('company_id');
        $data->brand_id = $request->input('brand_id');
        $data->date = $request->input('date');
        $data->image = $request->input('image');

        $price = $data->purchase_price = $request->input('purchase_price');
        $data->sale_price = $request->input('sale_price');
        $quantity = $data->quantity = $request->input('quantity');
        $total_cost= $price*$quantity;
        // dd($total);
        $data->total_cost = $total_cost;
        $data->save();
        if($data){
            return redirect('show-stock')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_stock($id){
        
        $data = Stock::find($id);
        // $companies = Company::all();
        // $brands = Brand::all();
        // $colors = Color::all();
        // $sizes = Size::all();
        // $categories = Category::all();
        return view('admin-side.stocks.edit_stock',compact('data'));
    }

    public function update_stock(Request $request, $id){

        // dd($request->all());
        $data = Stock::find($id);
        // dd($data);
        $data->name = $request->input('name');
        $data->item_code = $request->input('item_code');
        $data->category_id = $request->input('category_id');
        $data->color_id = $request->input('color_id');
        // $data->size_id = $request->input('size_id');
        $data->company_id = $request->input('company_id');
        $data->brand_id = $request->input('brand_id');
        $data->date = $request->input('date');
        $data->image = $request->input('image');

        $price = $data->purchase_price = $request->input('purchase_price');
        $data->sale_price = $request->input('sale_price');
        $quantity = $data->quantity = $request->input('quantity');
        $total_cost= $price*$quantity;
        // dd($total);
        $data->total_cost = $total_cost;
        $data->update();

        if($data){
            return redirect('show-stock')->with('success',"Record Updated Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record not updated Failed!");
        }
    }
    
    public function destroy_stock($id){
        // dd(4);
        $data = Stock::find($id)->delete();
        
        if($data){
            return redirect('show-stock')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }
}
