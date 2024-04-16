<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use App\Models\AssignStock;
use App\Models\SaleInvoice;
use App\Models\SalesBalance;
use App\Models\Customer;
use App\Models\Company;
use App\Helpers\Helper;
use App\Models\warehouse;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SaleInvoiceController extends Controller
{
    public function index(Request $request,$param)
    {
        $user_id    =   Auth::user()->id;
        
        if($param  ==  'invoice')
        {
            $data       =   SalesBalance::where([
                            'user_id'   =>  $user_id,
                            'target'    =>  'sales',
                            ])->get();
        }
        else
        {
            $data       =   SalesBalance::where([
                            'user_id'   =>  $user_id,
                            'target'    =>  'return',
                            ])->get();
        }
        
        return view('admin-side.sale_invoice.index', compact('data','param'));
    }

    public function create($param)
    {
        $user_id    =   Auth::user()->id;
        $brances    =   AssignStock::where([
                            'user_id' =>  $user_id,
                            'target'    =>  'stock',
                        ])->get();
        $products   =   [];
        $sizes      =   [];
        $stocks     =   [];
        $prices     =   [];
        $i          =   0;
        $j          =   0;
        $k          =   0;
        $l          =   0;
        
        foreach ($brances as $key => $value) 
        {
            $productPrice = $value->product->s_price;
            $productId   = $value->product->id;
            
            if (!in_array($productId, $prices)) 
            {
                $prices["proid_$i"]    =   $productId;
                $prices["price_$i"]    =   $productPrice;
                $l++;
            }
        }
        
        foreach ($brances as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
            $itemCode    = $value->product->item_code;
        
            if (!in_array($productId, $products))  
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $products["code_$i"]    =   $itemCode;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($brances as $value) 
        {
            $productId  =   $value->product_id;
            $size       =   $value->size;
        
            if (!isset($groupedSizes[$productId])) 
            {
                $groupedSizes[$productId] = [];
            }
        
            if (!in_array($size, $groupedSizes[$productId])) 
            {
                $groupedSizes[$productId][] = $size;
            }
        }
        
        $result =   [];
        $j      =   0;
        
        foreach ($groupedSizes as $productId => $sizes) 
        {
            foreach ($sizes as $size) 
            {
                $result["proid_$j"] =   (string)$productId;
                $result["size_$j"]  =   $size;
                $j++;
            }
        }
        
        $groupedStocks = [];

        foreach ($brances as $value) 
        {
            $productId      =   $value->product_id;
            $productSize    =   $value->size;
            $productStock   =   $value->assign_stock;
        
            $index = array_search($productId, array_column($groupedStocks, 'proid'));
        
            if ($index !== false) 
            {
                $sizeIndex  =   array_search($productSize, array_column($groupedStocks[$index]['sizes'], 'size'));
        
                if ($sizeIndex !== false) 
                {
                    $groupedStocks[$index]['sizes'][$sizeIndex]['stock']    +=  $productStock;
                    $groupedStocks[$index]['sizes'][$sizeIndex]['stock']    =   (string)$groupedStocks[$index]['sizes'][$sizeIndex]['stock'];
                } 
                else 
                {
                    $groupedStocks[$index]['sizes'][] = [
                        'size'  =>  $productSize,
                        'stock' =>  $productStock
                    ];
                }
            } 
            else 
            {
                $groupedStocks[] = [
                    'proid' =>  $productId,
                    'sizes' =>  [
                        [
                            'size'  =>  $productSize,
                            'stock' =>  $productStock
                        ]
                    ]
                ];
            }
        }
        
        foreach($groupedStocks as $g_key =>  $g_value)
        {
            foreach($g_value    as  $product_key    =>  $product_value)
            {
                if($product_key  ==  'sizes')
                {
                    foreach($product_value    as  $stock_key    =>  $stock_value)
                    {
                        
                        $return_stock           =   AssignStock::where([
                                                    'created_by'=>  $user_id,
                                                    'product_id'=>  $g_value['proid'],
                                                    'target'    =>  'return',
                                                    'size'      =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                                    
                        $assign_stock           =   AssignStock::where([
                                                    'created_by'=>  $user_id,
                                                    'product_id'=>  $g_value['proid'],
                                                    'target'    =>  'stock',
                                                    'size'      =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                                    
                        $return_branch_stock           =    AssignStock::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'return',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                                            
                        $assign_sale_invoice           =    SaleInvoice::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'sales',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                                            
                        $return_sale_invoice           =    SaleInvoice::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'return',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                            
                        $Stocks_data[] = [
                                                'proid' =>  $g_value['proid'],
                                                'sizes' =>  [ 
                                                    [
                                                        'size'  =>  $stock_value['size'],
                                                        'stock' =>  $stock_value['stock']-$return_stock-$assign_stock+$return_branch_stock-$assign_sale_invoice+$return_sale_invoice,
                                                    ]
                                                ]
                                            ];
                    }
                }
            }
        }
        
        $Stocks_data=   $Stocks_data    ?   $Stocks_data    :   [];
        $data       =   SaleInvoice::all();
        $colors     =   Color::all();
        $users      =   User::where('role_id',2)->get();
        return view('admin-side.sale_invoice.create', compact('data','param','products','colors','Stocks_data','result','users','prices'));
    }

    public function store(Request $request,$param)
    {
        $user_id        =   Auth::user()->id;
        $sale_id        =   Helper::createUId('SL');
        $user_id        =   $request->user_id;
        $product_id     =   $request->product_id;
        $color          =   $request->color;
        $size           =   $request->size_id;
        $stock          =   $request->stock;
        $price          =   $request->price;
        $quantity       =   $request->quantity;
        $total          =   $request->total;
        $discount       =   $request->discount_product;
        $discount_value =   $request->less;
        $net_balance    =   $request->net;
        $balance_detail =   [
                'current_invoice'   =>  $request->sum_of_all_product,
                'total_value'       =>  $request->total_value,
                'total_discount'    =>  $request->total_discount,
                'total_disc_value'  =>  $request->total_discount_value,
                'extra_descount'    =>  $request->extra_discount,
                'sub_total'         =>  $request->sub_total,
                'net_balance'       =>  $request->net_customer_balance,
            ];
        
        $get_success    =   [];
        $validated_array=   [];
        
        for($i=0; $i < count($product_id); $i++)
        {
            if(in_array($product_id[$i],$validated_array))
            {
                if(in_array($size[$i],$validated_array))
                {
                    return redirect()->back()->with('error',"The same product and size of different invoices are not allowed");
                }
                else
                {
                    $validated_array+=[
                        'product_id_'.$i    =>  $product_id[$i],
                        'size_'.$i          =>  $size[$i],
                    ];
                    if($quantity[$i]<= $request->stock[$i])
                    {
                        $get_success[] = 1;
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Quantity must be less than Stock");
                    }
                }
            }
            else
            {
                $validated_array+=[
                    'product_id_'.$i    =>  $product_id[$i],
                    'size_'.$i          =>  $size[$i],
                ];
                if($quantity[$i]<= $request->stock[$i])
                {
                    $get_success[] = 1;
                }
                else
                {
                    return redirect()->back()->with('error',"Quantity must be less than Stock");
                }
            }
        }
        
        if(count($get_success)  ==   count($product_id))
        {
            $created    =   SalesBalance::create([
                'user_id'           =>  $user_id[0],
                'sale_id'           =>  $sale_id,
                'current_invoice'   =>  $request->sum_of_all_product,
                'total_value'       =>  $request->total_value,
                'total_discount'    =>  $request->total_discount,
                'total_disc_value'  =>  $request->total_discount_value,
                'extra_descount'    =>  $request->extra_discount,
                'sub_total'         =>  $request->sub_total,
                'net_balance'       =>  $request->net_customer_balance,
                'target'            =>  $param  ==  'invoice'  ?   'sales'  :   'return',
            ]);
            
            for($i=0; $i < count($product_id); $i++)
            {
                $sale_invoice = new SaleInvoice;
    
                $sale_invoice->sale_id          =   $sale_id;
                $sale_invoice->user_id          =   $user_id[$i];
                $sale_invoice->product_id       =   $product_id[$i];
                $sale_invoice->color_id         =   $color[$i];
                $sale_invoice->assign_stock     =   $quantity[$i];
                $sale_invoice->size             =   $size[$i];
                $sale_invoice->price            =   $price[$i];
                $sale_invoice->total_price      =   $total[$i];
                $sale_invoice->discount         =   $discount[$i];
                $sale_invoice->discount_price   =   $discount_value[$i];
                $sale_invoice->net_balance      =   $net_balance[$i];
                $sale_invoice->target           =   $param  ==  'invoice'  ?   'sales'  :   'return';
                $sale_invoice->balance_detail   =   json_encode($balance_detail);
                
                $sale_invoice->save();
            }
            
        }
        else
        {
            return redirect()->back()->with('error',"Something went wrong while creating sale!");
        }
        
        if( $created)
        {
             return redirect('show/sale/'.$param)->with('success',"Stock Assign Successfully");
        }
        else
        {
            return redirect()->back()->with('error',"Stock Assign Failed!");
        }
    }

    public function edit($param, $id)
    {
        $user_id        =   Auth::user()->id;
        $data           =   SalesBalance::where([
                            'id'        =>  $id,
                            'user_id'   =>  $user_id,
                            'target'    =>  $param  ==  'invoice'  ?   'sales'  :   'return',
                            ])->first();
        $sales_balances =   SaleInvoice::where([
                            'sale_id'   =>  $data->sale_id,
                            'user_id'   =>  $user_id,
                            'target'    =>  $param  ==  'invoice'  ?   'sales'  :   'return',
                            ])->get();
        $brances        =   AssignStock::where([
                            'user_id' =>  $user_id,
                            'target'    =>  'stock',
                            ])->get();
                            
        $products   =   [];
        $sizes      =   [];
        $stocks     =   [];
        $prices     =   [];
        $i          =   0;
        $j          =   0;
        $k          =   0;
        $l          =   0;
        
        foreach ($brances as $key => $value) 
        {
            $productPrice = $value->product->s_price;
            $productId   = $value->product->id;
            
            if (!in_array($productId, $prices)) 
            {
                $prices["proid_$i"] =   $productId;
                $prices["price_$i"] =   $productPrice;
                $l++;
            }
        }
        
        foreach ($brances as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
            $itemCode    = $value->product->item_code;
        
            if (!in_array($productId, $products)) 
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $products["code_$i"]    =   $itemCode;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($brances as $value) 
        {
            $productId  =   $value->product_id;
            $size       =   $value->size;
        
            if (!isset($groupedSizes[$productId])) 
            {
                $groupedSizes[$productId] = [];
            }
        
            if (!in_array($size, $groupedSizes[$productId])) 
            {
                $groupedSizes[$productId][] = $size;
            }
        }
        
        $result =   [];
        $j      =   0;
        
        foreach ($groupedSizes as $productId => $sizes) 
        {
            foreach ($sizes as $size) 
            {
                $result["proid_$j"]     =   (string)$productId;
                $result["size_$j"]      =   $size;
                $j++;
            }
        }
        
        $groupedStocks  =   [];
        
        foreach ($brances as $value) 
        {
            $productId      =   $value->product_id;
            $productSize    =   $value->size;
            $productStock   =   $value->assign_stock;
        
            $index = array_search($productId, array_column($groupedStocks, 'proid'));
        
            if ($index !== false) 
            {
                $sizeIndex  =   array_search($productSize, array_column($groupedStocks[$index]['sizes'], 'size'));
        
                if ($sizeIndex !== false) 
                {
                    $groupedStocks[$index]['sizes'][$sizeIndex]['stock']    +=  $productStock;
                    $groupedStocks[$index]['sizes'][$sizeIndex]['stock']    =   (string)$groupedStocks[$index]['sizes'][$sizeIndex]['stock'];
                } 
                else 
                {
                    $groupedStocks[$index]['sizes'][] = [
                        'size'  =>  $productSize,
                        'stock' =>  $productStock
                    ];
                }
            } 
            else 
            {
                $groupedStocks[] = [
                    'proid' => $productId,
                    'sizes' => [
                        [
                            'size'  =>  $productSize,
                            'stock' =>  $productStock
                        ]
                    ]
                ];
            }
        }
        
        foreach($groupedStocks as $g_key =>  $g_value)
        {
            foreach($g_value    as  $product_key    =>  $product_value)
            {
                if($product_key  ==  'sizes')
                {
                    foreach($product_value    as  $stock_key    =>  $stock_value)
                    {
                        
                        $return_stock           =   AssignStock::where([
                                                    'created_by'=>  $user_id,
                                                    'product_id'=>  $g_value['proid'],
                                                    'target'    =>  'return',
                                                    'size'      =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                                    
                        $assign_stock           =   AssignStock::where([
                                                    'created_by'=>  $user_id,
                                                    'product_id'=>  $g_value['proid'],
                                                    'target'    =>  'stock',
                                                    'size'      =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                                    
                        $return_branch_stock           =    AssignStock::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'return',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                                                                                
                        $assign_sale_invoice           =    SaleInvoice::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'sales',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                                            
                        $return_sale_invoice           =    SaleInvoice::where([
                                                            'user_id'   =>  $user_id,
                                                            'product_id'=>  $g_value['proid'],
                                                            'target'    =>  'return',
                                                            'size'      =>  $stock_value['size'],
                                                            ])->sum('assign_stock');
                                            
                        $Stocks_data[] = [
                                                'proid' =>  $g_value['proid'],
                                                'sizes' =>  [ 
                                                    [
                                                        'size'  =>  $stock_value['size'],
                                                        'stock' =>  $stock_value['stock']-$return_stock-$assign_stock+$return_branch_stock-$assign_sale_invoice+$return_sale_invoice,
                                                    ]
                                                ]
                                            ];
                    }
                }
            }
        }
        
        $Stocks_data=   $Stocks_data    ?   $Stocks_data    :   [];
        
        $colors     =   Color::all();
        return view('admin-side.sale_invoice.edit', compact('brances','data','param','products','colors','Stocks_data','result','prices','sales_balances'));
    }

    public function update(Request $request,$param,$id)
    { 
        $user           =   Auth::user();
        $sales_balances =   SalesBalance::where([
                            'id'        =>  $id,
                            'user_id'   =>  $user->id,
                            'target'    =>  $param  ==  'invoice'  ?   'sales'  :   'return',
                            ])->first();
        
        $sale_id        =   $sales_balances->sale_id;
        
        if($sales_balances)
        {
            $user_id        =   $request->user_id;
            $product_id     =   $request->product_id;
            $color          =   $request->color;
            $size           =   $request->size_id;
            $stock          =   $request->stock;
            $price          =   $request->price;
            $quantity       =   $request->quantity;
            $total          =   $request->total;
            $discount       =   $request->discount_product;
            $discount_value =   $request->less;
            $net_balance    =   $request->net;
            $balance_detail =   [
                    'current_invoice'   =>  $request->sum_of_all_product,
                    'total_value'       =>  $request->total_value,
                    'total_discount'    =>  $request->total_discount,
                    'total_disc_value'  =>  $request->total_discount_value,
                    'extra_descount'    =>  $request->extra_discount,
                    'sub_total'         =>  $request->sub_total,
                    'net_balance'       =>  $request->net_customer_balance,
                ];
            $SalesStock =   SaleInvoice::where([
                            'sale_id'   =>  $sale_id,
                            'user_id'   =>  $user->id,
                            'target'    =>  $param  ==  'invoice'  ?   'sales'  :   'return',
                            ])->get();
                            
           
            $get_success    =   [];
            $validated_array=   [];
            
            for($i=0; $i < count($product_id); $i++)
            {
                if(in_array($product_id[$i],$validated_array))
                {
                    if(in_array($size[$i],$validated_array))
                    {
                        return redirect()->back()->with('error',"The same product and size of different invoices are not allowed");
                    }
                    else
                    {
                        $validated_array+=[
                            'product_id_'.$i    =>  $product_id[$i],
                            'size_'.$i          =>  $size[$i],
                        ];
                        if($quantity[$i]<= $request->stock[$i])
                        {
                            $get_success[] = 1;
                        }
                        else
                        {
                            return redirect()->back()->with('error',"Quantity must be less than Stock");
                        }
                    }
                }
                else
                {
                    $validated_array+=[
                        'product_id_'.$i    =>  $product_id[$i],
                        'size_'.$i          =>  $size[$i],
                    ];
                    if($quantity[$i]<= $request->stock[$i])
                    {
                        $get_success[] = 1;
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Quantity must be less than Stock");
                    }
                }
            }
            // $get_success    =   [];
            
            // for($i=0; $i < count($SalesStock); $i++)
            // {
            //     if($quantity[$i]<= $request->stock[$i])
            //     {
            //         $get_success[] = 1;
            //     }
            //     else
            //     {
            //         return redirect()->back()->with('error',"Quantity must be less than Stock");
            //     }
            // }
            
            if(count($get_success)  ==   count($SalesStock))
            {
                                        
                $updated    =   $sales_balances->update([
                    'user_id'           =>  $user_id[0],
                    'sale_id'           =>  $sale_id,
                    'current_invoice'   =>  $request->total_value,
                    'total_value'       =>  $request->total_value,
                    'total_discount'    =>  $request->total_discount,
                    'total_disc_value'  =>  $request->total_discount_value,
                    'extra_descount'    =>  $request->extra_discount,
                    'sub_total'         =>  $request->sub_total,
                    'net_balance'       =>  $request->net_customer_balance,
                    'target'            =>  $param  ==  'invoice'  ?   'sales'  :   'return',
                ]);
                
                foreach($SalesStock as  $key    =>  $value)
                {
                    $value->sale_id          =   $sale_id;
                    $value->user_id          =   $user_id[$key];
                    $value->product_id       =   $product_id[$key];
                    $value->color_id         =   $color[$key];
                    $value->assign_stock     =   $quantity[$key];
                    $value->size             =   $size[$key];
                    $value->price            =   $price[$key];
                    $value->total_price      =   $total[$key];
                    $value->discount         =   $discount[$key];
                    $value->discount_price   =   $discount_value[$key];
                    $value->net_balance      =   $net_balance[$key];
                    $value->target           =   $param  ==  'invoice'  ?   'sales'  :   'return';
                    $value->balance_detail   =   json_encode($balance_detail);
                    
                    $updated    =   $value->update();
                }
                
                // for($i=0; $i < count($SalesStock); $i++)
                // {
                    
                //     $sale_invoice     =   SaleInvoice::where([
                //                         'sale_id'   =>  $id,
                //                         'user_id'   =>  $user_id,
                //                         ])->first();
        
                //     $sale_invoice->sale_id          =   $sale_id;
                //     $sale_invoice->user_id          =   $user_id[$i];
                //     $sale_invoice->product_id       =   $product_id[$i];
                //     $sale_invoice->color_id         =   $color[$i];
                //     $sale_invoice->assign_stock     =   $quantity[$i];
                //     $sale_invoice->size             =   $size[$i];
                //     $sale_invoice->price            =   $price[$i];
                //     $sale_invoice->total_price      =   $total[$i];
                //     $sale_invoice->discount         =   $discount[$i];
                //     $sale_invoice->discount_price   =   $discount_value[$i];
                //     $sale_invoice->net_balance      =   $net_balance[$i];
                //     $sale_invoice->target           =   $param  ==  'invoice'  ?   'sales'  :   'return';
                //     $sale_invoice->balance_detail   =   json_encode($balance_detail);
                    
                //     $sale_invoice->update();
                // }
                
            }
            else
            {
                return redirect()->back()->with('error',"Something went wrong while creating sale!");
            }
           
            // $updated    =   $SalesStock->update([
            //     'user_id'           =>  $request->user_id,
            //     'product_id'        =>  $request->prev_product_id,
            //     'color_id'          =>  $request->color_id,
            //     'assign_stock'      =>  $request->quantity,
            //     'size'              =>  $request->size_id,
            //     'price'             =>  $request->price,
            //     'total_price'       =>  $request->total_price,
            //     'discount'          =>  $request->discount_product,
            //     'discount_price'    =>  $request->less,
            //     'net_price'         =>  $request->net,
            //     'extra_discount'    =>  $request->extra_discount,
            //     'net_balance'       =>  $request->net_customer_balance,
            //     'target'            =>  $param  ==  'invoice'  ?   'sales'  :   'return',
            //     'sale_id'           =>  $sale_id,
            // ]);
                
            if($updated)
            {
                 return redirect('show/sale/'.$param)->with('success',"Stock Assign Successfully");
            }
            else
            {
                return redirect()->back()->with('error',"Stock Assign Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('error',"Record not found!");
        }
    }

    public function delete($param,$id)
    {
        $user_id        =   Auth::user()->id;
        $sales_stock    =   SaleInvoice::where([
                            'user_id'   =>  $user_id,
                            'id'        =>  $id
                            ])->first();
        
        if($sales_stock)
        {
            $deleted    =   $sales_stock->delete();
            
            if($deleted)
            {
                return redirect('show/sale/'.$param)->with('success',"Record deleted Successfully");
            }
            else
            {
                return redirect()->back()->with('failed',"Something went wrong while deleting record");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record not found!");
        }
    }
    
}
