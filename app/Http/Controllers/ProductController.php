<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\AssignStock;
use App\Models\purchaseInvoiceReturnPartii;
use App\Models\PurchaseInvoicePartii;
use App\Models\saleInvoiceReturnPartii;
use App\Models\saleInvoicePartii;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function fetch_product()
    {
        $user       =   Auth::user();
        $data       =   product::with('assignStock')->latest()->get();
        $categories =   Category::all();
        // $assign_stock   =   AssignStock::where([
        //                     'created_by'    =>  $user->id,
        //                     'target'        =>  'stock',
        //                     ])->with('product')->get();
                            
        // $return_stock   =   AssignStock::where([
        //                     'user_id'    =>  $user->id,
        //                     'target'     =>  'return',
        //                     ])->with('product')->get();
                            
        $gents = product::where('category_id', '1')->get();
        $ladies = product::where('category_id', '2')->get();
        $kids = product::where('category_id', '3')->get();
        // dd($gents);
        // dd($data);
        $companies = Company::all();
        // dd($companies);
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        $categories = Category::all();
        return view('admin-side.product_details.fetch_product',compact('data','companies','brands','colors','sizes','categories','gents', 'kids', 'ladies','categories'));
    }

    function get_category_sizes(Request $request, $id)
    {
        $sizes = Size::where('category_id',$id)->get();
                            
        if($request->ajax())
        {
            return response()->json([ 'sizes' => $sizes]);
        }
    }

    
    public function store_product(Request $request)
    {
        $product   =   product::where('item_code',$request->item_code)->first();
        
        if(!$product)
        {
                $data = new Product();
                // dd($request->all());
                
                if($request->hasFile('image')){
        
                    // dd(1);
                    $file = $request->file('image');
                    $extenstion = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extenstion;
                    $file->move('public/uploads/products/', $filename);
                    $image =$data->image= $filename;
                    // dd($avatar);
                    $data->image = $image;
                }
        
                $data->name = $request->input('name');
                $data->item_code = $request->input('item_code');
                $data->category_id = $request->input('category_id');
                // $data->color_id = $request->input('color_id');
        
                $data->company_id = $request->input('company_id');
                $data->brand_id = $request->input('brand_id');
                $data->opening_balance = $request->input('opening_balance');
        
                $data->price = $request->input('p_price');
                $data->s_price = $request->input('s_price');
                $data->stock = $request->input('stoke');
                
                // $data->new_stock = $request->input('new_stock');
                // $price = $data->purchase_return = $request->input('purchase_return');
                // $data->sale_price = $request->input('sale_price');
                // $data->sale_return = $request->input('sale_return');
        
        
                // A is equal to = opening balance + purchase price + sale_return price
        
                $A = $request->input('opening_balance') + $request->input('purchase_price') + $request->input('sale_return') ;
                // dd($A);
        
        
                // B is equal to = purchase_return + sale price
        
                 $B = $request->input('purchase_return') + $request->input('sale_price');
                    // dd($B);
        
                    $C = $A - $B;
                    // dd($C);
        
                     $data->opening_balance = $C;
        
                //  gents size
        
            //  $data->size_38 = $request->size_38;
            //  $data->size_39 = $request->size_39;
            //  $data->size_40 = $request->size_40;
            //  $data->size_41 = $request->size_41;
            //  $data->size_42 = $request->size_42;
            //  $data->size_43 = $request->size_43;
            //  $data->size_44 = $request->size_44;
            //  $data->size_45 = $request->size_45;
            //  $data->size_46 = $request->size_46;
        
        
             $data->size_38 = ($request->size_38 == null) ? 0 : $request->size_38;
             $data->stock_38 = ($request->stock_38 == null) ? 0 : $request->stock_38;
        
             $data->size_39 = ($request->size_39 == null) ? 0 : $request->size_39;
             $data->stock_39 = ($request->stock_39 == null) ? 0 : $request->stock_39;
        
             $data->size_40 = ($request->size_40 == null) ? 0 : $request->size_40;
             $data->stock_40 = ($request->stock_40 == null) ? 0 : $request->stock_40;
        
             $data->size_41 = ($request->size_41 == null) ? 0 : $request->size_41;
             $data->stock_41 = ($request->stock_41 == null) ? 0 : $request->stock_41;
        
             $data->size_42 = ($request->size_42 == null) ? 0 : $request->size_42;
             $data->stock_42 = ($request->stock_42 == null) ? 0 : $request->stock_42;
        
             $data->size_43 = ($request->size_43 == null) ? 0 : $request->size_43;
             $data->stock_43 = ($request->stock_43 == null) ? 0 : $request->stock_43;
        
             $data->size_44 = ($request->size_44 == null) ? 0 : $request->size_44;
             $data->stock_44 = ($request->stock_44 == null) ? 0 : $request->stock_44;
        
             $data->size_45 = ($request->size_45 == null) ? 0 : $request->size_45;
             $data->stock_45 = ($request->stock_45 == null) ? 0 : $request->stock_45;
        
             $data->size_46 = ($request->size_46 == null) ? 0 : $request->size_46;
             $data->stock_46 = ($request->stock_46 == null) ? 0 : $request->stock_46;
        
            //  ladies size
        
            $data->l_size_36 = ($request->l_size_36 == null) ? 0 : $request->l_size_36;
             $data->l_stock_36 = ($request->l_stock_36 == null) ? 0 : $request->l_stock_36;
        
             $data->l_size_37 = ($request->l_size_37 == null) ? 0 : $request->l_size_37;
             $data->l_stock_37 = ($request->l_stock_37 == null) ? 0 : $request->l_stock_37;
        
             $data->l_size_38 = ($request->l_size_38 == null) ? 0 : $request->l_size_38;
             $data->l_stock_38 = ($request->l_stock_38 == null) ? 0 : $request->l_stock_38;
        
             $data->l_size_39 = ($request->l_size_39 == null) ? 0 : $request->l_size_39;
             $data->l_stock_39 = ($request->l_stock_39 == null) ? 0 : $request->l_stock_39;
        
             $data->l_size_40 = ($request->l_size_40 == null) ? 0 : $request->l_size_40;
             $data->l_stock_40 = ($request->l_stock_40 == null) ? 0 : $request->l_stock_40;
        
             $data->l_size_41 = ($request->l_size_41 == null) ? 0 : $request->l_size_41;
             $data->l_stock_41 = ($request->l_stock_41 == null) ? 0 : $request->l_stock_41;
        
             $data->l_size_42 = ($request->l_size_42 == null) ? 0 : $request->l_size_42;
             $data->l_stock_42 = ($request->l_stock_42 == null) ? 0 : $request->l_stock_42;
        
            //  kids size
        
             $data->k_size_1 = ($request->k_size_1 == null) ? 0 : $request->k_size_1;
             $data->k_stock_1 = ($request->k_stock_1 == null) ? 0 : $request->k_size_1;
        
             $data->k_size_2 = ($request->k_size_2 == null) ? 0 : $request->k_size_2;
             $data->k_stock_2 = ($request->k_stock_2 == null) ? 0 : $request->k_stock_2;
        
             $data->k_size_3 = ($request->k_size_3 == null) ? 0 : $request->k_size_3;
             $data->k_stock_3 = ($request->k_stock_3 == null) ? 0 : $request->k_stock_3;
        
             $data->k_size_4 = ($request->k_size_4 == null) ? 0 : $request->k_size_4;
             $data->k_stock_4 = ($request->k_stock_4 == null) ? 0 : $request->k_stock_4;
        
             $data->k_size_5 = ($request->k_size_5 == null) ? 0 : $request->k_size_5;
             $data->k_stock_5 = ($request->k_stock_5 == null) ? 0 : $request->k_stock_5;
        
             $data->k_size_6 = ($request->k_size_6 == null) ? 0 : $request->k_size_6;
             $data->k_stock_6 = ($request->k_stock_6 == null) ? 0 : $request->k_stock_6;
        
             $data->k_size_7 = ($request->k_size_7 == null) ? 0 : $request->k_size_7;
             $data->k_stock_7 = ($request->k_stock_7 == null) ? 0 : $request->k_stock_7;
        
        
             $data->k_size_8 = ($request->k_size_8 == null) ? 0 : $request->k_size_8;
             $data->k_stock_8 = ($request->k_stock_8 == null) ? 0 : $request->k_stock_8;
        
             $data->k_size_9 = ($request->k_size_9 == null) ? 0 : $request->k_size_9;
             $data->k_stock_9 = ($request->k_stock_9 == null) ? 0 : $request->k_stock_9;
        
             $data->k_size_10 = ($request->k_size_10 == null) ? 0 : $request->k_size_10;
             $data->k_stock_10 = ($request->k_stock_10 == null) ? 0 : $request->k_stock_10;
        
             $data->k_size_11 = ($request->k_size_11 == null) ? 0 : $request->k_size_11;
             $data->k_stock_11 = ($request->k_stock_11 == null) ? 0 : $request->k_stock_11;
        
             $data->k_size_12 = ($request->k_size_12 == null) ? 0 : $request->k_size_12;
             $data->k_stock_12 = ($request->k_stock_12 == null) ? 0 : $request->k_stock_12;
        
             $data->k_size_13 = ($request->k_size_13 == null) ? 0 : $request->k_size_13;
             $data->k_stock_13 = ($request->k_stock_13 == null) ? 0 : $request->k_stock_13;
        
        
             $data->k_size_17 = ($request->k_size_17 == null) ? 0 : $request->k_size_17;
             $data->k_stock_17 = ($request->k_stock_17 == null) ? 0 : $request->k_stock_17;
        
             $data->k_size_18 = ($request->k_size_18 == null) ? 0 : $request->k_size_18;
             $data->k_stock_18 = ($request->k_stock_18 == null) ? 0 : $request->k_stock_18;
        
             $data->k_size_19 = ($request->k_size_19 == null) ? 0 : $request->k_size_19;
             $data->k_stock_19 = ($request->k_stock_19 == null) ? 0 : $request->k_stock_19;
        
             $data->k_size_20 = ($request->k_size_20 == null) ? 0 : $request->k_size_20;
             $data->k_stock_20 = ($request->k_stock_20 == null) ? 0 : $request->k_stock_20;
        
             $data->k_size_21 = ($request->k_size_21 == null) ? 0 : $request->k_size_21;
             $data->k_stock_21 = ($request->k_stock_21 == null) ? 0 : $request->k_stock_21;
        
        
        
             $data->k_size_22 = ($request->k_size_22 == null) ? 0 : $request->k_size_22;
             $data->k_stock_22 = ($request->k_stock_22 == null) ? 0 : $request->k_stock_22;
        
             $data->k_size_23 = ($request->k_size_23 == null) ? 0 : $request->k_size_23;
             $data->k_stock_23 = ($request->k_stock_23 == null) ? 0 : $request->k_stock_23;
        
             $data->k_size_24 = ($request->k_size_24 == null) ? 0 : $request->k_size_24;
             $data->k_stock_24 = ($request->k_stock_24 == null) ? 0 : $request->k_stock_24;
        
             $data->k_size_25 = ($request->k_size_25 == null) ? 0 : $request->k_size_25;
             $data->k_stock_25 = ($request->k_stock_25 == null) ? 0 : $request->k_stock_25;
        
             $data->k_size_26 = ($request->k_size_26 == null) ? 0 : $request->k_size_26;
             $data->k_stock_26 = ($request->k_stock_26 == null) ? 0 : $request->k_stock_26;
        
             $data->k_size_27 = ($request->k_size_27 == null) ? 0 : $request->k_size_27;
             $data->k_stock_27 = ($request->k_stock_27 == null) ? 0 : $request->k_stock_27;
        
             $data->k_size_28 = ($request->k_size_28 == null) ? 0 : $request->k_size_28;
             $data->k_stock_28 = ($request->k_stock_28 == null) ? 0 : $request->k_stock_28;
        
        
             $data->k_size_29 = ($request->k_size_29 == null) ? 0 : $request->k_size_29;
             $data->k_stock_29 = ($request->k_stock_29 == null) ? 0 : $request->k_stock_29;
        
             $data->k_size_30 = ($request->k_size_30 == null) ? 0 : $request->k_size_30;
             $data->k_stock_30 = ($request->k_stock_30 == null) ? 0 : $request->k_stock_30;
        
             $data->k_size_31 = ($request->k_size_31 == null) ? 0 : $request->k_size_31;
             $data->k_stock_31 = ($request->k_stock_31 == null) ? 0 : $request->k_stock_31;
        
             $data->k_size_32 = ($request->k_size_32 == null) ? 0 : $request->k_size_32;
             $data->k_stock_32 = ($request->k_stock_32 == null) ? 0 : $request->k_stock_32;
        
             $data->k_size_33 = ($request->k_size_33 == null) ? 0 : $request->k_size_33;
             $data->k_stock_33 = ($request->k_stock_33 == null) ? 0 : $request->k_stock_33;
        
             $data->k_size_34 = ($request->k_size_34 == null) ? 0 : $request->k_size_34;
             $data->k_stock_34 = ($request->k_stock_34 == null) ? 0 : $request->k_stock_34;
        
             $data->k_size_35 = ($request->k_size_35 == null) ? 0 : $request->k_size_35;
             $data->k_stock_35 = ($request->k_stock_35 == null) ? 0 : $request->k_stock_35;
        
        }
        else
        {
            return redirect()->back()->with('error',"Product of same barcode already exist");
        }

        $data->save();

        if($data){
            return redirect('show-product')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_product($id)
    {
        $user_id=   Auth::user()->id;
        $data   =   Product::where('id', $id)->first();
        
        $stockData  =   $data->stock ? json_decode($data->stock, true) : [];
        $i          =   0;
        
        foreach($stockData  as  $key    =>  $value)
        {
            if ($key === "size_" . $i) 
            {
                $assign_stock           =   AssignStock::where([
                                            'user_id'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'target'    =>  'return',
                                            'size'      =>  $value,
                                            ])->sum('assign_stock');
                                            
                $sale_stock             =   saleInvoicePartii::where([
                                            'warehouse' =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $value,
                                            ])->sum('quantity');
                                            
                $return_sale_stock      =   saleInvoiceReturnPartii::where([
                                            'warehouse' =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $value,
                                            ])->sum('quantity');
                                            
                $purchase_stock         =   PurchaseInvoicePartii::where([
                                            'warehouse' =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $value,
                                            ])->sum('quantity');
                                            
                $return_purchase_stock  =   purchaseInvoiceReturnPartii::where([
                                            'warehouse' =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $value,
                                            ])->sum('quantity');
                                    
                $stockKey           =   "stock_" . $i;
                $stockData[$stockKey]   +=  $assign_stock-$sale_stock+$return_sale_stock+$purchase_stock-$return_purchase_stock;
                $stockData[$stockKey]   =   max(0, $stockData[$stockKey]);
                $stockData[$stockKey]   =   (string)$stockData[$stockKey];
                $i++;
                                
            }
        }
        
        $stockData  =   json_encode($stockData);
        // dd($stockData); 
        $categories = Category::all();
        return view('admin-side.product_details.edit_product',compact('data','categories','stockData'));
    }

    public function update_product(Request $request, $id)
    {
        $product   =   product::where('item_code',$request->item_code)->where('id','!=',$id)->first();
        
        if(!$product)
        {
          
            // dd(1);
            //  dd($request->all());
             $data = Product::find($id);
             // dd($data);
             if($request->hasFile('image')){
        
                // dd(1);
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->move('public/uploads/products/', $filename);
                $image =$data->image= $filename;
                // dd($avatar);
                $data->image = $image;
            }
        
             else{
                 unset($request->image);
             }
     
     
   
             $data->name = $request->input('name');
             $data->item_code = $request->input('item_code');
             $data->category_id = $request->input('category_id');
            //  $data->color_id = $request->input('color_id');
            //  $data->size_id = $request->input('size_id');
             $data->company_id = $request->input('company_id');
             $data->brand_id = $request->input('brand_id');
             $data->opening_balance = $request->input('opening_balance');
             $data->price = $request->input('p_price');
                $data->s_price = $request->input('s_price');
                $sizes_data    =   Size::where('category_id',$request->category_id)->get();
             
                $stock  =   [];
                if(count($sizes_data) !== 0)
                {
                    for($i = 0; $i < count($sizes_data); $i++)
                    {
                        $size_key   = "size_" . $i;
                        $stock_key  = "stock_" . $i;
                
                        $stock  += [
                            $size_key  => $request->$size_key,
                            $stock_key => $request->$stock_key,
                        ];
                    }
                }
                
                $data->stock = json_encode($stock);
                // if($request->stoke != null)
                // {
                //     $data->stock = $request->input('stoke');
                // }
                // $data->new_stock = $request->input('new_stock');
        
                // dd($data);
            //  $price = $data->purchase_price = $request->input('purchase_price');
            //  $price = $data->purchase_return = $request->input('purchase_return');
            //  $data->sale_price = $request->input('sale_price');
            //  $data->sale_return = $request->input('sale_return');
        
        
             // A is equal to = opening balance + purchase price + sale_return price
        
             $A = $request->input('opening_balance') + $request->input('purchase_price') + $request->input('sale_return') ;
             // dd($A);
        
        
             // B is equal to = purchase_return + sale price
        
              $B = $request->input('purchase_return') + $request->input('sale_price');
                 // dd($B);
        
                 $C = $A - $B;
                 // dd($C);
        
                  $data->opening_balance = $C;
        
            //  gents size
            
            //   dd($request->all());
            //  $data->size_38 = $request->size_38;
             $data->stock_38 = $request->stock_38   ?   $request->stock_38  :   0;
        
            //  $data->size_39 = $request->size_39;
             $data->stock_39 = $request->stock_39   ?   $request->stock_39  :   0;
        
            //  $data->size_40 = $request->size_40;
             $data->stock_40 = $request->stock_40   ?   $request->stock_40  :   0;
        
            //  $data->size_41 = $request->size_41;
             $data->stock_41 = $request->stock_41   ?   $request->stock_41  :   0;
        
            //  $data->size_42 = $request->size_42;
             $data->stock_42 = $request->stock_42   ?   $request->stock_42  :   0;
        
            //  $data->size_43 = $request->size_43;
             $data->stock_43 = $request->stock_43   ?   $request->stock_43  :   0;
        
            //  $data->size_44 = $request->size_44;
             $data->stock_44 = $request->stock_44   ?   $request->stock_44  :   0;
        
            //  $data->size_45 = $request->size_45;
             $data->stock_45 = $request->stock_45   ?   $request->stock_45  :   0;
        
            //  $data->size_46 = $request->size_46;
             $data->stock_46 = $request->stock_46   ?   $request->stock_46  :   0;
        
        
            //  ladies size
        
            //  $data->l_size_36 = $request->l_size_36;
             $data->l_stock_36 = $request->l_stock_36   ?   $request->stock_36  :   0;
        
            //  $data->l_size_37 = $request->l_size_37;
             $data->l_stock_37 = $request->l_stock_37   ?   $request->stock_37  :   0;
        
            //  $data->l_size_38 = $request->l_size_38;
             $data->l_stock_38 = $request->l_stock_38   ?   $request->stock_38  :   0;
        
            //  $data->l_size_39 = $request->l_size_39;
             $data->l_stock_39 = $request->l_stock_39   ?   $request->stock_39  :   0;
        
            //  $data->l_size_40 = $request->l_size_40;
             $data->l_stock_40 = $request->l_stock_40   ?   $request->stock_40  :   0;
        
            //  $data->l_size_41 = $request->l_size_41;
             $data->l_stock_41 = $request->l_stock_41   ?   $request->stock_41  :   0;
        
            //  $data->l_size_42 = $request->l_size_42;
             $data->l_stock_42 = $request->l_stock_42   ?   $request->stock_42  :   0;
        
        
            //  kids size
        
            //  $data->k_size_1 = $request->k_size_1;
            //  $data->k_size_2 = $request->k_size_2;
            //  $data->k_size_3 = $request->k_size_3;
            //  $data->k_size_4 = $request->k_size_4;
            //  $data->k_size_5 = $request->k_size_5;
            //  $data->k_size_6 = $request->k_size_6;
            //  $data->k_size_7 = $request->k_size_7;
        
            //  $data->k_size_8 = $request->k_size_8;
            //  $data->k_size_9 = $request->k_size_9;
            //  $data->k_size_10 = $request->k_size_10;
            //  $data->k_size_11 = $request->k_size_11;
            //  $data->k_size_12 = $request->k_size_12;
            //  $data->k_size_13 = $request->k_size_13;
        
            //  $data->k_size_17 = $request->k_size_17;
            //  $data->k_size_18 = $request->k_size_18;
            //  $data->k_size_19 = $request->k_size_19;
            //  $data->k_size_20 = $request->k_size_20;
            //  $data->k_size_21 = $request->k_size_21;
        
        
            //  $data->k_size_22 = $request->k_size_22;
            //  $data->k_size_23 = $request->k_size_23;
            //  $data->k_size_24 = $request->k_size_24;
            //  $data->k_size_25 = $request->k_size_25;
            //  $data->k_size_26 = $request->k_size_26;
            //  $data->k_size_27 = $request->k_size_27;
            //  $data->k_size_28 = $request->k_size_28;
        
            //  $data->k_size_29 = $request->k_size_29;
            //  $data->k_size_30 = $request->k_size_30;
            //  $data->k_size_31 = $request->k_size_31;
            //  $data->k_size_32 = $request->k_size_32;
            //  $data->k_size_33 = $request->k_size_33;
            //  $data->k_size_34 = $request->k_size_34;
            //  $data->k_size_35 = $request->k_size_35;
            // $data->k_size_1 = $request->k_size_1;
            $data->k_stock_1 = $request->k_stock_1   ?   $request->stock_1  :   0;
        
            // $data->k_size_2 = $request->k_size_2;
            $data->k_stock_2 = $request->k_stock_2   ?   $request->stock_2  :   0;
        
            // $data->k_size_3 = $request->k_size_3;
            $data->k_stock_3 = $request->k_stock_3   ?   $request->stock_3  :   0;
        
            // $data->k_size_4 = $request->k_size_4;
            $data->k_stock_4 = $request->k_stock_4   ?   $request->stock_4  :   0;
        
            // $data->k_size_5 = $request->k_size_5;
            $data->k_stock_5 = $request->k_stock_5   ?   $request->stock_5  :   0;
        
            // $data->k_size_6 = $request->k_size_6;
            $data->k_stock_6 = $request->k_stock_6   ?   $request->stock_6  :   0;
        
            // $data->k_size_7 = $request->k_size_7;
            $data->k_stock_7 = $request->k_stock_7   ?   $request->stock_7  :   0;
        
        
            // $data->k_size_8 = $request->k_size_8;
            $data->k_stock_8 = $request->k_stock_8   ?   $request->stock_8  :   0;
        
            // $data->k_size_9 = $request->k_size_9;
            $data->k_stock_9 = $request->k_stock_9   ?   $request->stock_9  :   0;
        
            // $data->k_size_10 = $request->k_size_10;
            $data->k_stock_10 = $request->k_stock_10   ?   $request->stock_10  :   0;
        
            // $data->k_size_11 = $request->k_size_11;
            $data->k_stock_11 = $request->k_stock_11   ?   $request->stock_11  :   0;
        
            // $data->k_size_12 = $request->k_size_12;
            $data->k_stock_12 = $request->k_stock_12   ?   $request->stock_12  :   0;
        
            // $data->k_size_13 = $request->k_size_13;
            $data->k_stock_13 = $request->k_stock_13   ?   $request->stock_13  :   0;
        
        
            // $data->k_size_17 = $request->k_size_17;
            $data->k_stock_17 = $request->k_stock_17   ?   $request->stock_17  :   0;
        
            // $data->k_size_18 = $request->k_size_18;
            $data->k_stock_18 = $request->k_stock_18   ?   $request->stock_18  :   0;
        
            // $data->k_size_19 = $request->k_size_19;
            $data->k_stock_19 = $request->k_stock_19   ?   $request->stock_19  :   0;
        
            // $data->k_size_20 = $request->k_size_20;
            $data->k_stock_20 = $request->k_stock_20   ?   $request->stock_20  :   0;
        
            // $data->k_size_21 = $request->k_size_21;
            $data->k_stock_21 = $request->k_stock_21   ?   $request->stock_21  :   0;
        
            // $data->k_size_22 = $request->k_size_22;
            $data->k_stock_22 = $request->k_stock_22   ?   $request->stock_22  :   0;
        
            // $data->k_size_23 = $request->k_size_23;
            $data->k_stock_23 = $request->k_stock_23   ?   $request->stock_23  :   0;
        
            // $data->k_size_24 = $request->k_size_24;
            $data->k_stock_24 = $request->k_stock_24   ?   $request->stock_24  :   0;
        
            // $data->k_size_25 = $request->k_size_25;
            $data->k_stock_25 = $request->k_stock_25   ?   $request->stock_25  :   0;
        
            // $data->k_size_26 = $request->k_size_26;
            $data->k_stock_26 = $request->k_stock_26   ?   $request->stock_26  :   0;
        
            // $data->k_size_27 = $request->k_size_27;
            $data->k_stock_27 = $request->k_stock_27   ?   $request->stock_27  :   0;
        
            // $data->k_size_28 = $request->k_size_28;
            $data->k_stock_28 = $request->k_stock_28   ?   $request->stock_28  :   0;
        
        
            // $data->k_size_29 = $request->k_size_29;
            $data->k_stock_29 = $request->k_stock_29   ?   $request->stock_29  :   0;
        
            // $data->k_size_30 = $request->k_size_30;
            $data->k_stock_30 = $request->k_stock_30   ?   $request->stock_30  :   0;
        
            // $data->k_size_31 = $request->k_size_31;
            $data->k_stock_31 = $request->k_stock_31   ?   $request->stock_31  :   0;
        
            // $data->k_size_32 = $request->k_size_32;
            $data->k_stock_32 = $request->k_stock_32   ?   $request->stock_32  :   0;
        
            // $data->k_size_33 = $request->k_size_33;
            $data->k_stock_33 = $request->k_stock_33   ?   $request->stock_33  :   0;
        
            // $data->k_size_34 = $request->k_size_34;
            $data->k_stock_34 = $request->k_stock_34   ?   $request->stock_34  :   0;
        
            // $data->k_size_35 = $request->k_size_35;
            $data->k_stock_35 = $request->k_stock_35   ?   $request->stock_35  :   0;
        
        
             $data->update();
        
             if($data){
                 return redirect('show-product')->with('success',"Record Updated Successfully");
             }
             else{
                 return redirect()->back()->with('failed',"Record not updated Failed!");
                }
        }
        else
        {
            return redirect()->back()->with('failed',"Record alread exist with same barcode!");
        }
 }



    public function destroy_product($id)
    {
         // dd(4);
        $data = Product::find($id);
         
        if($data)
        {
            $assign_stock           =   AssignStock::where('product_id',$id)->first();
            $sale_stock             =   saleInvoicePartii::where('product_id',$id)->first();
            $return_sale_stock      =   saleInvoiceReturnPartii::where('product_id',$id)->first();
            $purchase_stock         =   PurchaseInvoicePartii::where('product_id',$id)->first();
            $return_purchase_stock  =   purchaseInvoiceReturnPartii::where('product_id',$id)->first();
            
            if(!$assign_stock   &&  !$sale_stock &&  !$return_sale_stock  &&  !$purchase_stock &&  !$return_purchase_stock)
            {
                $deleted        =   $data->delete();
                
                if($deleted)
                {
                    return redirect('show-product')->with('success',"Record Deleted Successfully");
                }
                else
                {
                    return redirect()->back()->with('failed',"Record Deletion Failed!");
                }
            }
            else
            {
                return redirect()->back()->with('failed',"You are not allowed to delete this product as it is already used!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record not found!");
        }
    }
    // Products-category functions
    public function fetch_product_category()
    {

        $data = DB::table('categories')
        ->get();
        // dd($data);
        $branches = Branch::all();
        return view('admin-side.product_details.fetch_category',compact('data','branches'));
    }
    public function store_product_category(Request $request)
    {
        $found  =   Category::where([
                    'name'        =>  $request->name,
                    ])->first();
        if(!$found)
        {
            $data = new Category();
            $data->name = $request->input('name');
            $data->date = $request->input('date');
            $data->save();
            if($data)
            {
                return redirect('show-product-category')->with('success',"Record Inserted Successfully");
            }
            else
            {
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Category already exist!");
        }
    }
    public function edit_product_category($id){

        $data = Category::find($id);
        $branches = Branch::all();
        return view('admin-side.product_details.edit_category',compact('data','branches'));
    }

    public function update_product_category(Request $request, $id){
        $data = Category::find($id);
        
        $found  =   Category::where([
                    'name'  =>  $request->name,
                    ])->where('id','!=',$id)->first();
        if(!$found)
        {
            $data->name = $request->input('name');
            // $data->id = $request->input('id');
            // dd($data);
            $data->date = $request->input('date');
            $data->update();
    
            if($data){
                return redirect('show-product-category')->with('success',"Record Inserted Successfully");
            }
            else
            {
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Category with same name already exist!");
        }
    }
    public function destroy_product_category($id){
        
        $product = Product::where('id',$id)->first();
        
        if(!$product)
        {
            $data = Category::find($id)->delete();
    
            if($data)
            {
                return redirect('show-product-category')->with('success',"Record Deleted Successfully");
            }
            else
            {
                return redirect()->back()->with('failed',"Record Deletion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Product of this category already exist So you are not allowed to delete this category");
        }
    }
    // COlor functions
    public function fetch_color(){

        $data = DB::table('colors')
        ->get();
        // dd($data);
        $branches = Branch::all();
        return view('admin-side.product_details.fetch_color',compact('data','branches'));
    }
    public function store_color(Request $request){
        // dd($request->all());

        $data = new Color();
        $data->name = $request->input('name');
        $data->date = $request->input('date');
        $data->save();
        if($data){
            return redirect('show-color')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_color($id){

        $data = Color::find($id);
        $branches = Branch::all();
        return view('admin-side.product_details.edit_color',compact('data','branches'));
    }

    public function update_color(Request $request, $id){

        $data = Color::find($id);
        $data->name = $request->input('name');
        $data->date = $request->input('date');
        $data->update();

        if($data){
            return redirect('show-color')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function destroy_color($id){
        // dd(4);
        $data = Color::find($id)->delete();

        if($data){
            return redirect('show-color')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }

    // Size functions
    public function fetch_size(){

        $data = Size::all();
        // dd($data);
        $branches = Branch::all();
        $categories = Category::all();
        // dd($categories);
        return view('admin-side.product_details.fetch_size',compact('data','branches','categories'));
    }
    public function store_size(Request $request)
    {
        // dd($request->all());
        $found  =   Size::where([
                    'name'        =>  $request->name,
                    'category_id' =>  $request->category_id,
                    ])->first();
        if(!$found)
        {
            $data = new Size();
            $data->name = $request->input('name');
            $data->category_id = $request->input('category_id');
            $data->date = $request->input('date');
            $data->save();
            if($data){
                return redirect('show-size')->with('success',"Record Inserted Successfully");
            }
            else{
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record already exist!");
        }
    }
    public function edit_size($id){

        $data = Size::find($id);
        $categories = Category::all();
        $branches = Branch::all();
        return view('admin-side.product_details.edit_size',compact('data','branches','categories'));
    }

    public function update_size(Request $request, $id)
    {
        $found  =   Size::where([
                    'name'        =>  $request->name,
                    'category_id' =>  $request->category_id,
                    ])->where('id','!=',$id)->first();
        
        if(!$found)
        {
            $data = Size::find($id);
            $data->name = $request->input('name');
            $data->category_id = $request->input('category_id');
            $data->date = $request->input('date');
            $data->update();
    
            if($data){
                return redirect('show-size')->with('success',"Record Inserted Successfully");
            }
            else{
                return redirect()->back()->with('failed',"Record Insertion Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record already exist!");
        }
    }
    public function destroy_size($id){
        // dd(4);
        $data = Size::find($id)->delete();

        if($data){
            return redirect('show-size')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }




    public function fetch_product_detail($id)
    {
        dd($id);
        $product = Product::where('id', $id)->get();

        return response()->json(['product' => $product]);
    }



}
