<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignStock;
use App\Models\BranchStock;
use App\Models\Customer;
use App\Models\Company;
use App\Models\warehouse;
use App\Helpers\Helper;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AssignStockController extends Controller
{
    public function index(Request $request,$param)
    {
        $user       =   Auth::user();
        
        if($param  ==  'invoice')
        {   
            if($user->role_id    ==  1)
            {
                $data       =   AssignStock::where([
                                'created_by'   =>  $user->id,
                                'target'    =>  'stock',
                                ])->get();
            }
            else
            {
                $data       =   AssignStock::where([
                                'user_id'   =>  $user->id,
                                'target'    =>  'stock',
                                ])->get();
            }
        }
        elseif($param  ==  'return')
        {
            $data       =   AssignStock::where([
                            'created_by'   =>  $user->id,
                            'target'    =>  'return',
                            ])->get();
        }
        else
        {
            $data       =   AssignStock::where([
                            'created_by'=>  $user->id,
                            'target'    =>  'stock',
                            ])->get();
        }
        // dd($data,$param);
        return view('admin-side.assign_stock.index', compact('data','param'));
    }

    public function create(Request $request,$param)
    {   
        $users      =   User::where('role_id',5)->get();
        $products   =   product::all();
        $colors     =   Color::all();
        $sizes      =   Size::all();
        return view('admin-side.assign_stock.create', compact('users','param','products','colors','sizes'));
    }
    
    public function createReturn(Request $request,$param)
    {
        $user_id        =   Auth::user()->id;
        
        $warehouses     =   AssignStock::where([
                            'user_id'   =>  $user_id,
                            'target'    =>  'stock'
                            ])->with('product')->get();
        $products       =   [];
        $sizes          =   [];
        $stocks         =   [];
        $i              =   0;
        $j              =   0;
        $k              =   0;
        
        foreach ($warehouses as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
            $productcode = $value->product->item_code;
        
            if (!in_array($productId, $products)) 
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $products["code_$i"]    =   $productcode;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($warehouses as $value) 
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

        foreach ($warehouses as $value) 
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
                            'stock' =>  $productStock,
                        ]
                    ]
                ];
            }
        }
        
        $product_index   =   0;
        
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
                                            
                        $Stocks_data[] = [
                                                'proid' =>  $g_value['proid'],
                                                'sizes' =>  [ 
                                                    [
                                                        'size'  =>  $stock_value['size'],
                                                        'stock' =>  $stock_value['stock']-$return_stock-$assign_stock+$return_branch_stock,
                                                    ]
                                                ]
                                            ];
                    }
                }
            }
        }
        
        $Stocks_data=   $Stocks_data    ?   $Stocks_data    :   [];
        $data       =   BranchStock::all();
        $colors     =   Color::all();
       
        if($param   ==  'branch')
        {
            $users      =   User::where('role_id',2)->get();
        }
        else
        {
            if(Auth::user()->role_id    ==  2)
            {
                $users      =   User::where('role_id',5)->get();
            }
            else
            {
                $users      =   User::where('role_id',1)->get();
            }
        }
        
        return view('admin-side.assign_stock.return_create', compact('data','param','products','colors','Stocks_data','result','users'));
    }

    public function store(Request $request,$param)
    {
        $stock_id   =  Helper::createUId('ST');
        
        if($param   ==  'invoice')
        {
            $product    =   Product::where('id',$request->product_id)->first();
            
            if($product)
            {
                $stock      =   $product->stock ? json_decode($product->stock, true) : [];
                
                if($stock)
                {
                    $i = 0;
                    
                    foreach ($stock as $key => $value) 
                    {
                        if ($key === "size_" . $i) 
                        {
                            if ($value == $request->size) 
                            {
                                $stockKey           =   "stock_" . $i;
                                $stock[$stockKey]   -=  $request->quantity   ?   $request->quantity   :   0;
                                $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                $stock[$stockKey]   =   (string)$stock[$stockKey];
                                
                                $product_update =   $product->update(['stock' => json_encode($stock)]);
                            }
                            $i++;
                        }
                    }
                }
                else
                {
                    return redirect()->back()->with('error',"Stock not found");
                }
            }
            else
            {
                return redirect()->back()->with('error',"Product not found");
            }
            
            if($product_update)
            {
                   
                $created    =   AssignStock::create([
                    'created_by'    =>  $request->created_by,
                    'product_id'    =>  $request->product_id,
                    'color_id'      =>  $request->color_id,
                    'user_id'       =>  $request->user_id,
                    'size'          =>  $request->size,
                    'assign_stock'  =>  $request->quantity,
                    'target'        =>  'stock',
                    'stock_id'      =>  $stock_id,
                ]);
            }
        }
        else
        {
            $created    =   AssignStock::create([
                    'created_by'    =>  $request->user_id,
                    'product_id'    =>  $request->product_id,
                    'color_id'      =>  $request->color_id,
                    'user_id'       =>  $request->btanch_id,
                    'size'          =>  $request->size_id,
                    'assign_stock'  =>  $request->quantity,
                    'target'        =>  $param   ==  'return'   ?   'return'    :   'stock',
                    'stock_id'      =>  $stock_id,
                ]);
        }
        
        
        if( $created)
        {
             return redirect('show/warehouse/stock/'.$param)->with('success',"Stock Assign Successfully");
        }
        else
        {
            return redirect()->back()->with('error',"Something went wrong while updating product");
        }
    }

    public function edit(Request $request,$param ,$id)
    {
        $user_id    =   Auth::user()->id;
        $data       =   AssignStock::where(['id'=>$id,'created_by'=>$user_id])->first();
        $brances    =   null;
        
        if($data->target   ==  'stock'  &&  $param == 'invoice')
        {
            $target     =   $data->target;
            $products   =   product::all();
            $colors     =   Color::all();
            $users      =   User::where('role_id',5)->get();
            $sizes      =   Size::all();
        }
        else if($data->target   ==  'stock'  &&  $param == 'return')
        {
            $return_sale    =   AssignStock::where([
                                'created_by'=>  $user_id,
                                'stock_id'  =>  $data->stock_id,
                                'target'    =>  'return',
                                ])->first();
            
            if($return_sale)
            {
                $data       =   $return_sale;
                $target     =   'return';
                $products   =   null;
                $colors     =   null;
                $users      =   null;
                $sizes      =   null;
            }
            else
            {
                $colors     =   null;
                $users      =   null;
                $sizes      =   null;
                $target     =   $data->target;
                $product    =   product::where('id',$data->product_id)->first();
                $stock      =   $product->stock ? json_decode($product->stock, true) : [];
                
                if($stock)
                {
                    $i = 0;
                    
                    foreach ($stock as $key => $value) 
                    {
                        if ($key === "size_" . $i) 
                        {
                            if ($value == $data->size) 
                            {
                                $stockKey           =   "stock_" . $i;
                                $products           =   $stock[$stockKey];
                            }
                            $i++;
                        }
                    }
                }
                else
                {
                    return redirect()->back()->with('error',"Stock not found");
                }
            }
        }
        else
        {
            $target     =   $data->target;
            $colors     =   null;
            $users      =   null;
            $sizes      =   null;
            $product    =   product::where('id',$data->product_id)->first();
            $stock      =   $product->stock ? json_decode($product->stock, true) : [];
            
            if($stock)
            {
                $i = 0;
                
                foreach ($stock as $key => $value) 
                {
                    if ($key === "size_" . $i) 
                    {
                        if ($value == $data->size) 
                        {
                            $stockKey           =   "stock_" . $i;
                            $products           =   $stock[$stockKey];
                        }
                        $i++;
                    }
                }
            }
            else
            {
                return redirect()->back()->with('error',"Stock not found");
            }
            $brances    =   AssignStock::where([
                            'created_by'=>  $user_id,
                            'stock_id'  =>  $data->stock_id,
                            'target'    =>  'stock',
                            ])->first();
        }
        
        return view('admin-side.assign_stock.edit', compact('data','brances','param','target','users','products','colors','sizes'));
    }
    
    public function editReturn(Request $request,$param ,$id)
    {
        $user_id    =   Auth::user()->id;
        $data       =   AssignStock::where(['id'=>$id,'created_by'=>$user_id])->first();
        
        $warehouses =   AssignStock::where([
                            'user_id'   =>  $user_id,
                            'target'    =>  'stock'
                            ])->with('product')->get();
        $products   =   [];
        $sizes      =   [];
        $stocks     =   [];
        $i          =   0;
        $j          =   0;
        $k          =   0;
        
        foreach ($warehouses as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
            $productcode = $value->product->item_code;
        
            if (!in_array($productId, $products)) 
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $products["code_$i"]    =   $productcode;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($warehouses as $value) 
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
        
        $groupedStocks = [];

        foreach ($warehouses as $value) 
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
                                            
                        $Stocks_data[] = [
                                                'proid' =>  $g_value['proid'],
                                                'sizes' =>  [ 
                                                    [
                                                        'size'  =>  $stock_value['size'],
                                                        'stock' =>  $stock_value['stock']-$return_stock-$assign_stock+$return_branch_stock,
                                                    ]
                                                ]
                                            ];
                    }
                }
            }
        }
        
        $Stocks_data=   $Stocks_data    ?   $Stocks_data    :   [];
        
        $colors     =   Color::all();
        
        if($param   ==  'branch')
        {
            $users      =   User::where('role_id',2)->get();
        }
        else
        {
            if(Auth::user()->role_id    ==  2)
            {
                $users      =   User::where('role_id',5)->get();
            }
            else
            {
                $users      =   User::where('role_id',1)->get();
            }
        }
        return view('admin-side.assign_stock.return_edit', compact('warehouses','data','param','products','colors','Stocks_data','result','users'));
    }
    public function update(Request $request,$param,$id)
    {
        $user_id    =   Auth::user()->id;
        $data       =   AssignStock::where(['id' => $id,'created_by' => $user_id])->first();
        $stock_id   =   $data->stock_id;
        
        if($param   ==  'invoice')
        {
            if($request->product_id ==  $data->product_id)
            {
                if($request->size == $data->size)
                {
                    $product    =   Product::where('id',$request->product_id)->first();
                    
                    if($product)
                    {
                        $stock  =   $product->stock ? json_decode($product->stock, true) : [];
                        
                        if($stock)
                        {
                            $i = 0;
                            
                            foreach ($stock as $key => $value) 
                            {
                                if ($key === "size_" . $i) 
                                {
                                    if ($value == $request->size) 
                                    {
                                        $stockKey           =   "stock_" . $i;
                                        
                                        if($request->quantity   <   $data->assign_stock)
                                        {
                                            $total_quantity     =   $data->assign_stock -  $request->quantity;
                                            $stock[$stockKey]   +=  $total_quantity;
                                        }
                                        else if($request->quantity   >   $data->assign_stock)
                                        {
                                            $total_quantity     =   $request->quantity - $data->assign_stock;
                                            $stock[$stockKey]   -=  $total_quantity;
                                        }
                                        
                                        $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                        $stock[$stockKey]   =   (string)$stock[$stockKey];
                                        $product_update     =   $product->update(['stock' => json_encode($stock)]);
                                    }
                                    $i++;
                                }
                            }
                        }
                        else
                        {
                            return redirect()->back()->with('error',"Stock not found");
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Product not found");
                    }
                }
                else
                {
                    $product        =   Product::where('id',$request->product_id)->first();
                    
                    if($product)
                    {
                        $stock      =   $product->stock ? json_decode($product->stock, true) : [];
                        
                        if($stock)
                        {
                            $i = 0;
                            
                            foreach ($stock as $key => $value) 
                            {
                                if ($key === "size_" . $i) 
                                {
                                    if ($value == $request->size) 
                                    {
                                        $stockKey           =   "stock_" . $i;
                                        $stock[$stockKey]   -=  $request->quantity;
                                        $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                        $stock[$stockKey]   =   (string)$stock[$stockKey];
                                        $product_update     =   $product->update(['stock' => json_encode($stock)]);
                                    }
                                    
                                    if($value == $data->size)
                                    {
                                        $stockKey           =   "stock_" . $i;
                                        $stock[$stockKey]   +=  $data->assign_stock;
                                        $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                        $stock[$stockKey]   =   (string)$stock[$stockKey];
                                        $product_update     =   $product->update(['stock' => json_encode($stock)]);
                                    }
                                    $i++;
                                }
                            }
                        }
                        else
                        {
                            return redirect()->back()->with('error',"Stock not found");
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Product not found");
                    }
                }
            }
            else
            {
                $pre_product=   Product::where('id',$data->product_id)->first();
                $product    =   Product::where('id',$request->product_id)->first();
                
                if($product)
                {
                    $stock      =   $product->stock ? json_decode($product->stock, true) : [];
                    
                    if($stock)
                    {
                        $pre_stock  =   $pre_product->stock ? json_decode($pre_product->stock, true) : [];
                        $i          =   0;
                        
                        foreach ($stock as $key => $value) 
                        {
                            if ($key === "size_" . $i) 
                            {
                                if ($value == $request->size) 
                                {
                                    $stockKey           =   "stock_" . $i;
                                    $stock[$stockKey]   -=  $request->quantity;
                                    $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                    $stock[$stockKey]   =   (string)$stock[$stockKey];
                                    $updated            =   $product->update(['stock' => json_encode($stock)]);
                                }
                                $i++;
                            }
                        }
                        
                        $j = 0;
                        
                        if($updated)
                        {
                            foreach ($pre_stock as $p_key => $p_value) 
                            {
                                if ($p_key === "size_" . $j) 
                                {
                                    if ($p_value == $data->size) 
                                    {
                                        $stockKey               =   "stock_" . $j;
                                        $pre_stock[$stockKey]   +=  $data->assign_stock;
                                        $pre_stock[$stockKey]   =   max(0, $pre_stock[$stockKey]);
                                        $pre_stock[$stockKey]   =   (string)$pre_stock[$stockKey];
                                        $product_update         =   $pre_product->update(['stock' => json_encode($pre_stock)]);
                                    }
                                    $j++;
                                }
                            }
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Stock not found");
                    }
                }
                else
                {
                    return redirect()->back()->with('error',"Product not found");
                }
            }
        }
        else
        {
            goto update;
        }
        
        if($product_update)
        {
            if($param   ==  'invoice')
            {
                $updated    =   $data->update([
                    'created_by'    =>  $request->created_by,
                    'product_id'    =>  $request->previous_pro_id,
                    'color_id'      =>  $request->color_id,
                    'user_id'       =>  $request->user_id,
                    'size'          =>  $request->size,
                    'assign_stock'  =>  $request->quantity,
                    'target'        =>  'stock',
                    'stock_id'      =>  $stock_id,
                ]);
            }
            else
            {
                update:
                // if($data->target  ==  'return')
                // {
                    $updated    =   $data->update([
                        'created_by'    =>  $request->warehouse_id,
                        'product_id'    =>  $request->product_id,
                        'color_id'      =>  $request->color_id,
                        'user_id'       =>  $request->user_id,
                        'size'          =>  $request->size_id,
                        'assign_stock'  =>  $request->quantity,
                        'target'        =>  $param   ==  'return'   ?   'return'    :   'stock',
                        'stock_id'      =>  $stock_id,
                    ]);
                // }
                // else
                // {
                //     $updated    =   $data->update([
                //         'created_by'    =>  $request->created_by,
                //         'product_id'    =>  $request->previous_pro_id,
                //         'color_id'      =>  $request->color_id,
                //         'user_id'       =>  $request->user_id,
                //         'size'          =>  $request->size,
                //         'assign_stock'  =>  $s_quantity,
                //         'target'        =>  'stock',
                //         'stock_id'      =>  $stock_id,
                //     ]);
                // }
            }
            
            if($updated)
            {
                 return redirect('show/warehouse/stock/'.$param)->with('success',"Stock Assign Successfully");
            }
            else
            {
                return redirect()->back()->with('error',"Stock Assign Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('error',"Something went wrong ");
        }
    }

    public function delete(Request $request,$param,$id)
    {
        $user_id        =   Auth::user()->id;
        $asssign_stock  =   AssignStock::where([
                            'created_by' =>  $user_id,
                            'id'         =>  $id
                            ])->first();
        
        if($asssign_stock)
        {
            if($param   ==  'invoice')
            {
            
                $product    =   $asssign_stock->product;
                
                if($product)
                {
                    $assign_stock   =   BranchStock::where([
                                        'product_id'    =>  $product->id,
                                        'user_id'    =>  $user_id
                                        ])->first();
                    if(!$assign_stock)
                    {
                        $stock  =   $product->stock ? json_decode($product->stock, true) : [];
                        
                        if($stock)
                        {
                            $i  =   0;
                            foreach ($stock as $key => $value) 
                            {
                                if ($key === "size_" . $i) 
                                {
                                    if ($value == $asssign_stock->size) 
                                    {
                                        $stockKey           =   "stock_" . $i;
                                        $stock[$stockKey]   +=  $asssign_stock->assign_stock;
                                        $stock[$stockKey]   =   max(0, $stock[$stockKey]);
                                        $stock[$stockKey]   =   (string)$stock[$stockKey];
                                        $updated            =   $product->update(['stock' => json_encode($stock)]);
                                    }
                                    $i++;
                                }
                            }
                        }
                        else
                        {
                            return redirect()->back()->with('failed',"Stock not found!");
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('failed',"You arenot allowed to delete this invoice");
                    }
                }
                else
                {
                    return redirect()->back()->with('failed',"Product not found!");
                }
                        
                // if($param   ==  'invoice')
                // {
                //     $return_stock   =   AssignStock::where([
                //                         'created_by'=>  $user_id,
                //                         'stock_id'  =>  $asssign_stock->stock_id,
                //                         'target'    =>  'return',
                //                         ])->first();
                                   
                //     if($return_stock == null)
                //     {
                //     }
                //     else
                //     {
                //         return redirect()->back()->with('error',"You are not allowed to delete this sale as it hase return invoice");
                //     }
                // }
                // else
                // {
                    
                //     $stock_invoice  =   AssignStock::where([
                //                         'user_id'   =>  $request->user_id,
                //                         'stock_id'  =>  $data->stock_id,
                //                         'target'    =>  'stock',
                //                         ])->first();
                     
                //     $quantity   =   $stock_invoice->assign_stock +   $asssign_stock->assign_stock;
                    
                //     if($request->quantity   <=  $quantity)
                //     {
                //         $updated    =   $return_stock->update([
                //             'user_id'       =>  $request->user_id,
                //             'product_id'    =>  $request->previous_pro_id,
                //             'color_id'      =>  $request->color_id,
                //             'branch_id'     =>  $request->btanch_id,
                //             'assign_stock'  =>  $quantity,
                //             'size'          =>  $request->size,
                //             'target'        =>  'stock',
                //         ]);
                        
                //         if($updated)
                //         {
                //             $product   =   Product::where('id',$request->previous_pro_id)->first();
                        
                //             if($product)
                //             {
                //                 $pre_stock  =   $product->stock ? json_decode($product->stock, true) : [];
                //                 $j          =   0;
                                
                //                 foreach ($pre_stock as $p_key => $p_value) 
                //                 {
                //                     if ($p_key === "size_" . $j) 
                //                     {
                //                         if ($p_value == $data->size) 
                //                         {
                //                             $stockKey               =   "stock_" . $j;
                //                             $pre_stock[$stockKey]   -=  $asssign_stock->assign_stock;
                //                             $pre_stock[$stockKey]   =   max(0, $pre_stock[$stockKey]);
                //                             $pre_stock[$stockKey]   =   (string)$pre_stock[$stockKey];
                //                             $product_update         =   $product->update(['stock' => json_encode($pre_stock)]);
                //                         }
                //                         $j++;
                //                     }
                //                 }
                //             }
                //             else
                //             {
                //                 return redirect()->back()->with('error',"Product not found not found");
                //             }
                //         }
                //     }
                //     else
                //     {
                //         return redirect()->back()->with('error',"Quantity must be less than stock!");
                //     }
                // }
            }  
            else
            {
                goto delete;
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record not found!");
        }
        
        if($updated)
        {
            delete:
            $deleted    =   $asssign_stock->delete();
            
            if($deleted)
            {
                return redirect('show/warehouse/stock/'.$param)->with('success',"Record deleted Successfully");
            }
            else
            {
                return redirect()->back()->with('failed',"Something went wrong while deleting record");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Something went wrong!");
        }
    }
    
    public function stockIndex(Request $request,$param)
    {
        $user    =   Auth::user();
        
        if($param  ==  'invoice')
        {
            if($user->role_id    ==  5)
            {
                $data       =   BranchStock::where([
                                'created_by'   =>  $user->id,
                                'target'    =>  'stock',
                                ])->get();
            }
            else
            {
                $data       =   BranchStock::where([
                                'branch_id'   =>  $user->id,
                                'target'    =>  'stock',
                                ])->get();
            }
        }
        else
        {
            $data       =   BranchStock::where([
                            'created_by'   =>  $user->id,
                            'target'    =>  'return',
                            ])->get();
        }
        
        return view('admin-side.branch_stock.index', compact('data','param'));
    }

    public function createStock(Request $request,$param)
    {
        $user_id    =   Auth::user()->id;
        $warehouses =   AssignStock::where('user_id',$user_id)->get();
        $products   =   [];
        $sizes      =   [];
        $stocks     =   [];
        $i          =   0;
        $j          =   0;
        $k          =   0;
        
        foreach ($warehouses as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
        
            if (!in_array($productId, $products)) 
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($warehouses as $value) 
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

        foreach ($warehouses as $value) 
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

        $data       =   BranchStock::all();
        $colors     =   Color::all();
        $users      =   User::where('role_id',2)->get();
        return view('admin-side.branch_stock.create', compact('data','param','products','colors','groupedStocks','result','users'));
    }
    
    public function createReturnStock(Request $request,$param)
    {
        $user_id    =   Auth::user()->id;
        $warehouses =   BranchStock::where(['created_by'=>$user_id,'target'=>'stock'])->with('product')->get();
        $products   =   [];
        $sizes      =   [];
        $stocks     =   [];
        $i          =   0;
        $j          =   0;
        $k          =   0;
        
        foreach ($warehouses as $key => $value) 
        {
            $productName = $value->product->name;
            $productId   = $value->product->id;
        
            if (!in_array($productId, $products)) 
            {
                $products["id_$i"]      =   $productId;
                $products["name_$i"]    =   $productName;
                $i++;
            }
        }
        
        $groupedSizes = [];

        foreach ($warehouses as $value) 
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
        
        $groupedStocks = [];

        foreach ($warehouses as $value) 
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
        
        $product_index   =   0;
        
        foreach($groupedStocks as $g_key =>  $g_value)
        {
            foreach($g_value    as  $product_key    =>  $product_value)
            {
                if($product_key  ==  'sizes')
                {
                    foreach($product_value    as  $stock_key    =>  $stock_value)
                    {
                        
                        $return_stock           =   BranchStock::where([
                                                    'created_by'=>$user_id,
                                                    'product_id'=>$g_value['proid'],
                                                    'target'=>'return',
                                                    'size'  =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                            
                        $return_branch_stock   =   BranchStock::where([
                                                    'created_by'=>$user_id,
                                                    'product_id'=>$g_value['proid'],
                                                    'target'=>'return',
                                                    'size'  =>  $stock_value['size'],
                                                    ])->sum('assign_stock');
                                            
                        $Stocks_data[] = [
                                                'proid' =>  $g_value['proid'],
                                                'sizes' =>  [ 
                                                    [
                                                        'size'  =>  $stock_value['size'],
                                                        'stock' =>  $stock_value['stock']-$return_stock,
                                                    ]
                                                ]
                                            ];
                    }
                }
            }
        }
        
        $data       =   BranchStock::all();
        $colors     =   Color::all();
        $users      =   User::where('role_id',1)->get();
        // dd($products);
        return view('admin-side.assign_stock.return_create', compact('data','param','products','colors','Stocks_data','result','users'));
    }

    public function storeStock(Request $request,$param)
    {
        $stock_data =   AssignStock::where([
            'user_id'   => $request->user_id,
            'product_id'=> $request->product_id,
            'size'      => $request->size_id,
            ])->get();
            
        $quantity  =   $request->quantity;
        
        foreach($stock_data as $key => $value)
        {
            if($value->assign_stock != 0    &&  $quantity !=  0)
            {
                if($quantity >= $value->assign_stock)
                {
                    $quantity  =   $quantity - $value->assign_stock;
                    $update    =    $value->update(['assign_stock' => 0]);
                }
                else
                {
                    $quantity  =    $value->assign_stock - $quantity;
                    $update    =    $value->update(['assign_stock' => $quantity]);
                    $quantity  =    0;
                }
            }
        }
        
        if($update)
        {
            $stock_id   =  Helper::createUId('ST');
            $created    =   BranchStock::create([
                'created_by'    =>  $request->user_id,
                'product_id'    =>  $request->product_id,
                'color_id'      =>  $request->color_id,
                'branch_id'     =>  $request->btanch_id,
                'assign_stock'  =>  $request->quantity,
                'size'          =>  $request->size_id,
                'target'        =>  'stock',
                'stock_id'      =>  $stock_id,
            ]);
            
            if( $created)
            {
                 return redirect('show/branch/stock/'.$param)->with('success',"Stock Assign Successfully");
            }
            else
            {
                return redirect()->back()->with('error',"Stock Assign Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('error',"Something went wrong ");
        }
    }

    public function editStock($param, $id)
    {
        $user_id    =   Auth::user()->id;
        $data       =   BranchStock::where(['id'=>$id,'created_by'=>$user_id])->first();
        
        if($data->target   ==  'stock'  &&  $param == 'invoice')
        {
            $target     =   $data->target;
            $warehouses =   AssignStock::where('user_id',$user_id)->get();
            $products   =   [];
            $sizes      =   [];
            $stocks     =   [];
            $i          =   0;
            $j          =   0;
            $k          =   0;
            
            foreach ($warehouses as $key => $value) 
            {
                $productName = $value->product->name;
                $productId   = $value->product->id;
            
                if (!in_array($productId, $products)) 
                {
                    $products["id_$i"]      =   $productId;
                    $products["name_$i"]    =   $productName;
                    $i++;
                }
            }
            
            $groupedSizes = [];
    
            foreach ($warehouses as $value) 
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
            
            $groupedStocks = [];
    
            foreach ($warehouses as $value) 
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
        }
        else if($data->target   ==  'stock'  &&  $param == 'return')
        {
            $return_stock    =   BranchStock::where([
                                'created_by'   =>  $user_id,
                                'stock_id'  =>  $data->stock_id,
                                'target'    =>  'return',
                                ])->first();
            
            if($return_stock)
            {
                $data           =   $return_stock;
                $target         =   'return';
                $products       =   null;
                $groupedStocks  =   null;
                $result         =   null;
                $prices         =   null;
                $warehouses     =   AssignStock::where([
                                    'user_id'       =>  $user_id,
                                    'product_id'    =>  $data->product_id,
                                    'size'          =>  $data->size,
                                    ])->get();
                                    
                foreach($warehouses as  $key    =>  $value)
                {
                    $result     +=  $value->assign_stock;
                }
            }
            else
            {
                $target         =   $data->target;
                $products       =   null;
                $groupedStocks  =   null;
                $result         =   null;
                $prices         =   null;
                $result         =   0;
                
                $warehouses     =   AssignStock::where([
                                    'user_id'       =>  $user_id,
                                    'product_id'    =>  $data->product_id,
                                    'size'          =>  $data->size,
                                    ])->get();
                                    
                foreach($warehouses as  $key    =>  $value)
                {
                    $result     +=  $value->assign_stock;
                }
            }
        }
        else
        {
            $target         =   $data->target;
            $products       =   null;
            $groupedStocks  =   null;
            $result         =   null;
            $prices         =   null;
            $result         =   0;
            
            $warehouses     =   AssignStock::where([
                                'user_id'       =>  $user_id,
                                'product_id'    =>  $data->product_id,
                                'size'          =>  $data->size,
                                ])->get();
                                
            foreach($warehouses as  $key    =>  $value)
            {
                $result     +=  $value->assign_stock;
            }
        }
        
        $colors     =   Color::all();
        $users      =   User::where('role_id',2)->get();
        return view('admin-side.branch_stock.edit', compact('warehouses','target','data','param','products','colors','groupedStocks','result','users'));
    }

    public function updateStock(Request $request,$param,$id)
    {
        $user_id        =   Auth::user()->id;
        $BranchStock    =   BranchStock::where(['id' => $id,'created_by' => $user_id])->first();
        $stock_id       =   $BranchStock->stock_id;
        
        if($param   ==  'invoice')
        {
            $return_stock   =   BranchStock::where([
                                'id'        =>  $id,
                                'created_by'   =>  $request->user_id,
                                'stock_id'  =>  $BranchStock->stock_id,
                                'target'    =>  'return',
                                ])->first();
                                
            if(!$return_stock)
            {
                $stock_data     =   AssignStock::where([
                                    'user_id'   => $request->user_id,
                                    'product_id'=> $request->product_id,
                                    'size'      => $request->size_id,
                                    ])->get();
                
                if($request->prev_product_id  == $request->product_id)
                {
                    if($request->prev_size_id  == $request->size_id)
                    {
                        if($request->prev_quantity  <   $request->quantity)
                        {
                            $quantity  =   $request->quantity - $request->prev_quantity;
            
                            foreach($stock_data as $key => $value)
                            {
                                if($value->assign_stock != 0    &&  $quantity !=  0)
                                {
                                    if($quantity >= $value->assign_stock)
                                    {
                                        $quantity  =    $quantity - $value->assign_stock;
                                        $update    =    $value->update(['assign_stock' => 0]);
                                    }
                                    else
                                    {
                                        $quantity  =    $value->assign_stock - $quantity;
                                        $update    =    $value->update(['assign_stock' => $quantity]);
                                        $quantity  =    0;
                                    }
                                }
                            }
                        }
                        else if($request->prev_quantity  >   $request->quantity)
                        {
                            $quantity  =  $request->prev_quantity - $request->quantity;
                            $status    =  true;
                            
                            foreach($stock_data as $key => $value)
                            {
                                if($status == true)
                                {
                                    $quantity  =   $quantity + $value->assign_stock;
                                    $update    =   $value->update(['assign_stock' => $quantity]);
                                    $status    =   false;
                                }
                            }
                        }
                        else
                        {
                            goto update;
                        }
                    }
                    else
                    {
                         $pre_stock_data =  AssignStock::where([
                                                'user_id'   => $request->user_id,
                                                'product_id'=> $request->product_id,
                                                'size'      => $request->prev_size_id,
                                            ])->get();
                                            
                        $prev_quantity  =   $request->prev_quantity;
                        $status         =   true;
                        
                        foreach($pre_stock_data as $p_key => $p_value)
                        {
                            if($status == true)
                            {
                                $prev_quantity  =   $prev_quantity + $p_value->assign_stock;
                                $update         =   $p_value->update(['assign_stock' => $prev_quantity]);
                                $status         =   false;
                            }
                        }
                            
                        $quantity  =   $request->quantity;
                        
                        foreach($stock_data as $key => $value)
                        {
                            if($value->assign_stock != 0    &&  $quantity !=  0)
                            {
                                if($quantity >= $value->assign_stock)
                                {
                                    $quantity  =   $quantity - $value->assign_stock;
                                    $update    =    $value->update(['assign_stock' => 0]);
                                }
                                else
                                {
                                    $quantity  =    $value->assign_stock - $quantity;
                                    $update    =    $value->update(['assign_stock' => $quantity]);
                                    $quantity  =    0;
                                }
                            }
                        }
                    }
                }
                else
                {
                    $pre_stock_data =  AssignStock::where([
                                                'user_id'   => $request->user_id,
                                                'product_id'=> $request->prev_product_id,
                                                'size'      => $request->prev_size_id,
                                            ])->get();
                                            
                    $prev_quantity  =   $request->prev_quantity;
                    $status         =   true;
                    
                    foreach($pre_stock_data as $p_key => $p_value)
                    {
                        if($status == true)
                        {
                            $prev_quantity  =   $prev_quantity + $p_value->assign_stock;
                            $update         =   $p_value->update(['assign_stock' => $prev_quantity]);
                            $status         =   false;
                        }
                    }
                        
                    $quantity  =   $request->quantity;
                    
                    foreach($stock_data as $key => $value)
                    {
                        if($value->assign_stock != 0    &&  $quantity !=  0)
                        {
                            if($quantity >= $value->assign_stock)
                            {
                                $quantity  =   $quantity - $value->assign_stock;
                                $update    =    $value->update(['assign_stock' => 0]);
                            }
                            else
                            {
                                $quantity  =    $value->assign_stock - $quantity;
                                $update    =    $value->update(['assign_stock' => $quantity]);
                                $quantity  =    0;
                            }
                        }
                    }
                }
            }
            else
            {
                return redirect()->back()->with('error',"You are not allowed to edit this sale as it has return invoice");
            }
        }
        else
        {
            $return_stock    =   BranchStock::where([
                                'created_by'   =>  $user_id,
                                'stock_id'  =>  $BranchStock->stock_id,
                                'target'    =>  'return',
                                ])->first();
                                
            dd($return_stock);
            if(isset($return_stock)  &&  $return_stock    != null)
            {
                $stock_invoice    =   AssignStock::where([
                                    'user_id'       =>  $request->user_id,
                                    'product_id'    =>  $BranchStock->product_id,
                                    'size'          =>  $request->size_id,
                                    ])->get();
                dd($request->all());
                $quantity  =   $request->quantity - $request->stock;
                
                foreach($stock_invoice  as  $key    =>  $value)
                {
                    if($request->quantity  <   $value->assign_stock)
                    {
                        $quantity  =    $value->assign_stock - $request->quantity;
                        $update    =    $value->update(['assign_stock' => $quantity]);
                    }
                    else
                    {
                        $quantity  =    $value->assign_stock - $request->quantity;
                        $update    =    $value->update(['assign_stock' => 0]);
                    }
                    
                }
                    
                $updated    =   $return_stock->update([
                    'user_id'       =>  $request->user_id,
                    'product_id'    =>  $request->prev_product_id,
                    'color_id'      =>  $request->color_id,
                    'branch_id'     =>  $request->btanch_id,
                    'assign_stock'  =>  $request->quantity,
                    'size'          =>  $request->size_id,
                    'stock_id'      =>  $stock_id,
                ]);
            }
            else
            {
                $created    =   BranchStock::create([
                    'created_by'    =>  $request->user_id,
                    'product_id'    =>  $request->prev_product_id,
                    'color_id'      =>  $request->color_id,
                    'branch_id'     =>  $request->btanch_id,
                    'assign_stock'  =>  $request->quantity,
                    'size'          =>  $request->size_id,
                    'target'        =>  'return',
                    'stock_id'      =>  $stock_id,
                ]);
                
                if($created)
                {
                    $warehouse_stock   =   AssignStock::where([
                                            'user_id'   =>  $user_id,
                                            'product_id'=>  $request->prev_product_id,
                                            'size'      =>  $request->size_id,
                                            ])->get();
                    
                    $quantity  =   $request->quantity;
        
                    foreach($warehouse_stock as $key => $value)
                    {
                        if($value->assign_stock != 0    &&  $quantity !=  0)
                        {
                            if($quantity >= $value->assign_stock)
                            {
                                $quantity  =   $quantity - $value->assign_stock;
                                $update    =    $value->update(['assign_stock' => 0]);
                            }
                            else
                            {
                                $quantity  =    $value->assign_stock - $quantity;
                                $update    =    $value->update(['assign_stock' => $quantity]);
                                $quantity  =    0;
                            }
                        }
                    }
                }
            }
        }
        
        if($update)
        {
            if($param   ==  'invoice')
            {
                update:
                $updated    =   $BranchStock->update([
                    'created_by'    =>  $request->user_id,
                    'product_id'    =>  $request->product_id,
                    'color_id'      =>  $request->color_id,
                    'branch_id'     =>  $request->btanch_id,
                    'assign_stock'  =>  $request->quantity,
                    'size'          =>  $request->size_id,
                ]);
            }
            else
            {
                if($BranchStock->target  ==  'return')
                {
                    $product   =   Product::where('id',$BranchStock->product_id)->first();
                    
                    if($product)
                    {
                        $pre_stock  =   $product->stock ? json_decode($product->stock, true) : [];
                        $j          =   0;
                        
                        foreach ($pre_stock as $p_key => $p_value) 
                        {
                            if ($p_key === "size_" . $j) 
                            {
                                if ($p_value == $BranchStock->size) 
                                {
                                    $stockKey               =   "stock_" . $j;
                                    $pre_stock[$stockKey]   +=  $request->quantity;
                                    
                                    $pre_stock[$stockKey]   =   max(0, $pre_stock[$stockKey]);
                                    $pre_stock[$stockKey]   =   (string)$pre_stock[$stockKey];
                                    $updated                =   $product->update(['stock' => json_encode($pre_stock)]);
                                }
                                $j++;
                            }
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Product not found not found");
                    }
                }
                else
                {
                    $product   =   Product::where('id',$BranchStock->product_id)->first();
                    
                    if($product)
                    {
                        $pre_stock  =   $product->stock ? json_decode($product->stock, true) : [];
                        $j          =   0;
                        
                        foreach ($pre_stock as $p_key => $p_value) 
                        {
                            if ($p_key === "size_" . $j) 
                            {
                                if ($p_value == $BranchStock->size) 
                                {
                                    $stockKey               =   "stock_" . $j;
                                    $pre_stock[$stockKey]   +=  $request->quantity;
                                    
                                    $pre_stock[$stockKey]   =   max(0, $pre_stock[$stockKey]);
                                    $pre_stock[$stockKey]   =   (string)$pre_stock[$stockKey];
                                    $updated                =   $product->update(['stock' => json_encode($pre_stock)]);
                                }
                                $j++;
                            }
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error',"Product not found not found");
                    }
                }
            }
            
            if($updated)
            {
                 return redirect('show/branch/stock/'.$param)->with('success',"Stock Assign Successfully");
            }
            else
            {
                return redirect()->back()->with('error',"Stock Assign Failed!");
            }
        }
        else
        {
            return redirect()->back()->with('error',"Something went wrong ");
        }
    }

    public function deleteStock($id)
    {
        $branch_stock  = BranchStock::find($id);
        
        if($branch_stock)
        {
            $warehouse    =   AssignStock::where([
                'user_id'   => $branch_stock->user_id,
                'product_id'=> $branch_stock->product_id,
                'size'      => $branch_stock->size,
                ])->get();
            
            if(count($warehouse))
            {
                $prev_quantity  =   $branch_stock->assign_stock;
                $status         =   true;
                
                foreach($warehouse as $p_key => $p_value)
                {
                    if($status == true)
                    {
                        $prev_quantity  =   $prev_quantity + $p_value->assign_stock;
                        $update         =   $p_value->update(['assign_stock' => $prev_quantity]);
                        $status         =   false;
                    }
                }
                
                if($update)
                {
                    $deleted    =   $branch_stock->delete();
                    
                    if($deleted)
                    {
                        return redirect('show-branch-stock')->with('success',"Record deleted Successfully");
                    }
                    else
                    {
                        return redirect()->back()->with('failed',"Something went wrong while deleting record");
                    }
                }
                else
                {
                    return redirect()->back()->with('failed',"Something went wrong!");
                }
            }
            else
            {
                return redirect()->back()->with('failed',"Ware House not found!");
            }
        }
        else
        {
            return redirect()->back()->with('failed',"Record not found!");
        }
    }
}
