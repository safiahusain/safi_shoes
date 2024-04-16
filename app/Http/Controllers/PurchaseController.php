<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
// use App\Models\purchaseinvoice;

use App\Models\PurchaseInvoicePartii;
use App\Models\PurchaseInvoiceParti;
use App\Models\Company;
use App\Models\Product;
use App\Models\Size;
use App\Models\AssignStock;
use App\Models\warehouse;
use App\Models\purchaseInvoiceReturnParti;
use App\Models\purchaseInvoiceReturnPartii;
use App\Models\saleInvoiceReturnPartii;
use App\Models\saleInvoicePartii;
use App\Models\CompanyLedgerReport;
use App\Models\ProductReportShopWareHouse;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

//    show purchase invoice details

   public function fetch_purchase_invoice(Request $request)
   {


        $purchaseinvoice = PurchaseInvoiceParti::all();
        $colors = Color::all();
        $company = Company::all();
        $date = date('d-m-y');
        return view('admin-side.purchases.fetch_purchase_invoices', compact('colors', 'company','purchaseinvoice','date'));

   }


   public function invoice()
   {
    return view('admin-side.purchases.fetch_purchase_invoices');
   }



   public function show_invoice_detail()
   {
    $purchaseinvoice = purchaseinvoice::all();
    dd($purchaseinvoice);
    return response()->json([
        "purchaseInvoice" => $purchaseinvoice
    ]);
   }



   public function purchase_invoice_form()
   {

      $company = company::all();
      $products = Product::all();
      $warehouses = warehouse::get();
      $colors     =   Color::all();
        $sizes      =   Size::all();
    return view('admin-side.purchases.purchase-invoice-form', compact('company','warehouses','products','colors','sizes'));
   }



//    purchase invoice store


   public function store_purchase_invoice(Request $request)
   {
        // $latest_id = CompanyLedgerReport::count('balance');
    
        // dd($request->all());

        $product_name               =   $request->product_name;
        $product_id                 =   $request->product_id;
        $warehouse                  =   $request->shop_warehouse;
        $size                       =   $request->size;
        $color                      =   $request->color;
        $price                      =   $request->price;
        $quantity                   =   $request->quantity;
        $total                      =   $request->total;
        $discount                   =   $request->discount_product;
        $discount_value             =   $request->less;
        $net_value_of_every_product =   $request->net;
    
        
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
    
        // for($i=0; $i < count($product_name); $i++)
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
        
        if(count($get_success)  ==   count($product_name))
        {
            $purchaseinvoice = new PurchaseInvoiceParti;
    
            $purchaseinvoice->company_id                    =   $request->company_id;
            $purchaseinvoice->company_name                  =   $request->company_name;
            $purchaseinvoice->old_balance                   =   $request->old_balance;
            $purchaseinvoice->date                          =   $request->date;
            $purchaseinvoice->sub_total                     =   $request->sub_total;
            $purchaseinvoice->discount                      =   $request->total_discount;
            $purchaseinvoice->less                          =   $request->extra_discount;
            $purchaseinvoice->total_value_of_sub_previous   =   $request->total_value_of_sub_previous;
            $purchaseinvoice->net                           =   $request->total_value;
            $purchaseinvoice->total_discount_value          =   $request->total_discount_value;
            $purchaseinvoice->paid_customer_balance         =   $request->paid_customer_balance;
            $purchaseinvoice->net_customer_balance          =   $request->net_customer_balance;
            $purchaseinvoice->sum_of_all_product            =   $request->sum_of_all_product;
    
            $purchaseinvoice->save();
            
            $latest_id = purchaseInvoiceParti::latest()->first('id');
        
            for($i=0; $i < count($product_name); $i++)
            {
                $purchaseinvoice = new PurchaseInvoicePartii;
            
                $purchaseinvoice->product_name              =   $product_name[$i];
                $purchaseinvoice->warehouse                 =   $warehouse[$i];
                $purchaseinvoice->size                      =   $size[$i];
                $purchaseinvoice->color                     =   $color[$i];
                $purchaseinvoice->quantity                  =   $quantity[$i];
                $purchaseinvoice->price                     =   $price[$i];
                $purchaseinvoice->total                     =   $total[$i];
                $purchaseinvoice->discount                  =   $discount[$i];
                $purchaseinvoice->less                      =   $discount_value[$i];
                $purchaseinvoice->net                       =   $net_value_of_every_product[$i];
                $purchaseinvoice->product_id                =   $product_id[$i];
                $purchaseinvoice->company_name              =   $request->company_name;
                $purchaseinvoice->date                      =   $request->date;
                $purchaseinvoice->purchaseInoviceParti_id   =   $latest_id->id;
            
                $purchaseinvoice->save();
            
            
                $purchaseinvoice_quantity       =   purchaseInvoicePartii::where('product_id',$product_id[$i])->sum('quantity');
                $find_product                   =   product::where('id', $product_id[$i])->first();
                $find_product->purchase_price   =   $purchaseinvoice_quantity;
                $find_product->save();
            
                //    add product opening quantity and the purchase invoice product quantity
            
                $find_product                       =   product::where('id', $product_id[$i])->first();
                $find_product->shop_warehouse       =   $warehouse[$i];
                $find_product->purchase_price       =   $purchaseinvoice_quantity;
                $add_open_balance_p_price_s_return  =   $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
                $add_purchase_return_sale_price     =   $find_product->purchase_return + $find_product->sale_price;
                $find_product->balance              =   $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
            
                $find_product->save();
            }
    
            // find the value of opening balance of company
        
            $purchaseinvoice_paid           =   purchaseInvoiceParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
            $purchaseinvoice_paid_return    =   purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
            $purchaseinvoice_sub_total      =   purchaseInvoiceParti::where('company_id',$request->company_id)->sum('sub_total');
        
        
            $company_id = company::find($request->company_id);
        
        
            $company_id->paid                   =   $purchaseinvoice_paid + $purchaseinvoice_paid_return;
            $total                              =   $company_id->paid_payment_voucher + $company_id->paid;
            $company_id->total_paid_balance     =   $total;
            $company_id->purchase_price         =   $purchaseinvoice_sub_total ;
            $total_opening_balance              =   $request->net_customer_balance;
            $total_purchase_price_open_balance  =   $company_id->open_balance + $company_id->purchase_price;
            $total_purchase_return_paid         =   $company_id->purchase_return + $company_id->total_paid_balance;
            $company_id->balance                =   $total_purchase_price_open_balance - $total_purchase_return_paid;
        
            $company_id->update();
        
            // store company all balance details
        
            $company_ledger_report = new CompanyLedgerReport();
        
            $company_ledger_report->company_name        =   $request->company_name;
            $company_ledger_report->date                =   $request->date;
            $company_ledger_report->particular          =   "Parchase Invoice";
            $company_ledger_report->purchase_amount     =   $request->total_value;
            $company_ledger_report->paid_amount         =   $request->paid_customer_balance;
            $company_ledger_report->purchaseinvoice_id  =   $latest_id->id;
            $company_ledger_report->save();
        
            for($i=0; $i < count($product_name); $i++)
            {
                $product_report_shop_warehouse                      =   new ProductReportShopWareHouse;
                $product_report_shop_warehouse->product_name        =   $product_name[$i];
                $product_report_shop_warehouse->shop_godam          =   $warehouse[$i];
                $product_report_shop_warehouse->size                =   $size[$i];
                $product_report_shop_warehouse->color               =   $color[$i];
                $product_report_shop_warehouse->purchase_quantity   =   $quantity[$i];
                $product_report_shop_warehouse->purchase_value      =   $price[$i];
                $product_report_shop_warehouse->company_name        =   $request->company_name;
                $product_report_shop_warehouse->purchase_sale_id    =   $latest_id->id;
            
                $product_report_shop_warehouse->save();
    
           }
        }


        if( $purchaseinvoice){
            return redirect('show-purchase-invoice')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('error',"Record Insertion Failed!");
        }

   }

//  edit  purchase invoice

   public function edit_purchase_invoice($id)
   {
    $purchaseinvoice = purchaseInvoicePartii::where('purchaseInoviceParti_id',$id)->get();

    $purchaseinvoices = purchaseInvoicePartii::find($id);
    $purchaseinvoicei = purchaseInvoiceParti::find($id);
    $company = company::get();
    $warehouses = warehouse::get();
    $products = Product::all();
    $colors     =   Color::all();
    $sizes      =   Size::all();
    return view('admin-side.purchases.edit_purchase_invoice', compact('purchaseinvoice','purchaseinvoices','purchaseinvoicei', 'company','warehouses','products','colors'));
   }


   public function customer_purchase_detail($id)
   {

    $purchaseinvoices = purchaseInvoicePartii::where('purchaseInoviceParti_id',$id)->get();

    $purchaseinvoicei = purchaseInvoiceParti::find($id);
    $company = company::get();
    $warehouses = warehouse::get();

    return view('admin-side.purchases.customer-purchase-detail', compact('purchaseinvoices','purchaseinvoicei', 'company','warehouses'));

   }


   //  update  purchase invoice


   public function update_purchase_invoice(Request $request, $id)
   {
    // $purchaseinvoice_paid->update();

    // $latest_id = purchaseInvoiceParti::latest()->first('id');
    
    $product_name = $request->product_name;
    $product_id = $request->product_id;
    $warehouse = $request->shop_warehouse;
    $size = $request->size;
    $color = $request->color;
    $price = $request->price;
    $quantity = $request->quantity;
    $total = $request->total;
    $discount = $request->discount_product;
    $discount_value = $request->less;
    $net_value_of_every_product = $request->net;
    
    
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

    // for($i=0; $i < count($product_name); $i++)
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
        
    if(count($get_success)  ==   count($product_name))
    {   
        $purchaseinvoice = purchaseInvoiceParti::find($id);
    
        $purchaseinvoice->company_id = $request->company_id;
        $purchaseinvoice->company_name = $request->company_name;
        $purchaseinvoice->old_balance = $request->old_balance;
        $purchaseinvoice->date = $request->date;
        $purchaseinvoice->sub_total = $request->sub_total;
        $purchaseinvoice->discount = $request->total_discount;
        $purchaseinvoice->less = $request->extra_discount;
        $purchaseinvoice->total_value_of_sub_previous = $request->total_value_of_sub_previous;
        $purchaseinvoice->net = $request->total_value;
        $purchaseinvoice->total_discount_value = $request->total_discount_value;
        $purchaseinvoice->paid_customer_balance = $request->paid_customer_balance;
        $purchaseinvoice->net_customer_balance = $request->net_customer_balance;
        $purchaseinvoice->sum_of_all_product = $request->sum_of_all_product;
        $purchaseinvoice->update();

        $purchaseInvoicePartii_id = purchaseInvoicePartii::where('purchaseInoviceParti_id', $id)->first();
        
        $j = $purchaseInvoicePartii_id->id;
        
        for($i=0; $i < count($product_name); $i++)
        {
            $purchaseinvoices = purchaseInvoicePartii::find($j);
            $purchaseinvoices->product_name =  $product_name[$i];
            $purchaseinvoices->warehouse = $warehouse[$i];
            $purchaseinvoices->size = $size[$i];
            $purchaseinvoices->color = $color[$i];
            $purchaseinvoices->quantity = $quantity[$i];
            $purchaseinvoices->price = $price[$i];
            $purchaseinvoices->total = $total[$i];
            $purchaseinvoices->discount = $discount[$i];
            $purchaseinvoices->less = $discount_value[$i];
            $purchaseinvoices->net = $net_value_of_every_product[$i];
            $purchaseinvoices->product_id = $product_id[$i];
        
        
            // $purchaseinvoices->purchaseInoviceParti_id = $latest_id->id;
        
            $purchaseinvoices->update();
        
            $j++;
        
        
        
            $purchaseinvoice_quantity = purchaseInvoicePartii::where('product_id',$product_id[$i])->sum('quantity');
            $find_product = product::where('id', $product_id[$i])->first();
            $find_product->purchase_price = $purchaseinvoice_quantity;
            $find_product->save();
        
            //    add product opening quantity and the purchase invoice product quantity
        
            $find_product = product::where('id', $product_id[$i])->first();
        
            $find_product->purchase_price = $purchaseinvoice_quantity;
        
            $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
        
            $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;
        
            $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
        
            $find_product->save();
        }


        // find the value of opening balance of company
    
        $purchaseinvoice_paid = purchaseInvoiceParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_paid_return = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_sub_total = purchaseInvoiceParti::where('company_id',$request->company_id)->sum('sub_total');
    
        // dd($purchaseinvoice_sub_total);
    
        $company_id = company::find($request->company_id);
    
        $company_id->paid =  $purchaseinvoice_paid + $purchaseinvoice_paid_return;
        $total = $company_id->paid_payment_voucher + $company_id->paid;
        $company_id->total_paid_balance = $total;
    
        $company_id->purchase_price = $purchaseinvoice_sub_total ;
    
        $total_opening_balance =  $request->net_customer_balance;
    
        $total_purchase_price_open_balance = $company_id->open_balance + $company_id->purchase_price;
    
        $total_purchase_return_paid = $company_id->purchase_return + $company_id->total_paid_balance;
    
        $company_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;
    
        $company_id->update();
    
    
        // update customer ledger report using sale invoice
    
        $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id', $id)->first();
    
        $company_ledger_report->paid_amount = $request->paid_customer_balance;
        $company_ledger_report->purchase_amount = $request->sub_total;
    
        $company_ledger_report->update();
    }

    if( $purchaseinvoices || $purchaseinvoice)
    {
        return redirect('show-purchase-invoice')->with('success',"Record Updated Successfully");
    }
    else
    {
        return redirect()->back()->with('error',"Record Updated Failed!");
    }

   }


  public function delete_purchase_invoice(Request $request, $id)
  {
    $purchaseinvoicepartiii = purchaseInvoicePartii::where('purchaseInoviceParti_id', $id)->get();

      foreach($purchaseinvoicepartiii as $data)
     {

        $find_product = product::where('id', $data->product_id)->first();
        $find_product->purchase_price = $find_product->purchase_price - $data->quantity;
        $find_product->save();

        $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;

        $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;

        $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;

        $find_product->save();

     }

    //  the below codes for finding balance of companies

       $purchaseparti_sub_total = purchaseInvoiceParti::where('id', $id)->first();

       $company_id = company::where('id', $purchaseparti_sub_total->company_id)->first();

       $purchase_price =  $company_id->purchase_price - $purchaseparti_sub_total->sub_total;

       $company_id->purchase_price =  $purchase_price ;

      //  code for paid balance

       $company_id->paid = $company_id->paid - $purchaseparti_sub_total->paid_customer_balance;

       $company_id->total_paid_balance = $company_id->paid + $company_id->paid_payment_voucher;

      //  find total balance

       $total_purchase_price_open_balance = $company_id->open_balance + $company_id->purchase_price;

       $total_purchase_return_paid = $company_id->purchase_return + $company_id->total_paid_balance;

       $company_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;

        $company_id->update();

        purchaseInvoiceParti::find($id)->delete();

        $purchaseinvoicepartii = purchaseInvoicePartii::where('purchaseInoviceParti_id', $id);

        $purchaseinvoicepartii->delete();



      // delete company ledger ledger

      $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id', $id);

      $company_ledger_report->delete();

      if($purchaseinvoicepartii)
      {
        return redirect('show-purchase-invoice')->with('success',"Record deleted Successfully");

      }
      else{
        return redirect()->back()->with('failed',"Record deletion Failed!");
    }


  }



   public function fetch_product_using_code($code)
   {

    $products = product::where('item_code', $code)->get();

    return response()->json([ 'products' => $products]);

   }


   public function fetch_product_detail(Request $request)
   {
        $user_id        =   Auth::user()->id;
        $id = $request->query('id');

        $product = product::where('id', $id)->first();
        $sizes      =   Size::where('category_id',$product->category_id)->get();
        $stock      =   $product->stock ? json_decode($product->stock, true) : [];
        $i          =   0;
        $stock_data =   [];
        
        foreach($stock  as $key =>  $value)
        {
            // dd($key,$value,'size'.$i);
            if($key ==  'stock_'.$i)
            {
                $return_stock           =   AssignStock::where([
                                            'user_id'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'target'    =>  'return',
                                            'size'      =>  $stock['size_'.$i],
                                            ])->sum('assign_stock');
                                            
                $sale_stock             =   saleInvoicePartii::where([
                                            'warehouse'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $stock['size_'.$i],
                                            ])->sum('quantity');
                                            
                $return_sale_stock      =   saleInvoiceReturnPartii::where([
                                            'warehouse'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $stock['size_'.$i],
                                            ])->sum('quantity');
                                            
                $purchase_stock         =   PurchaseInvoicePartii::where([
                                            'warehouse'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $stock['size_'.$i],
                                            ])->sum('quantity');
                                            
                $return_purchase_stock  =   purchaseInvoiceReturnPartii::where([
                                            'warehouse'   =>  $user_id,
                                            'product_id'=>  $id,
                                            'size'      =>  $stock['size_'.$i],
                                            ])->sum('quantity');
                
                $stock['stock_'.$i] =   $stock['stock_'.$i]+$return_stock-$sale_stock+$return_sale_stock+$purchase_stock-$return_purchase_stock;
                $stock['stock_'.$i] =   (string)$stock['stock_'.$i];
                $i++;
                
            }
        }
        
        if($request->ajax())
        {
            
            return response()->json([ 'product' => $product,'sizes' => $sizes,'stock'=>json_encode($stock)]);
        }
   }


   public function fetch_purchase_invoice_detail_ajax($id)
   {

    $purchase_detail = purchaseInvoiceParti::where('id', $id)->get();

    $purchaseii_detail = purchaseInvoicePartii::where('purchaseInoviceParti_id', $id)->get();

    return response()->json([ 'purchase_detail' => $purchase_detail, 'purchaseii_detail' => $purchaseii_detail]);

   }


 // get product name and show in list


  public function show_product_name_in_li(Request $request)
  {
    if($request->ajax())
    {
      $product_name = product::where('name', 'LIKE', $request->name.'%')->orWhere('item_code', 'LIKE', $request->name.'%')->get();
       $output = '';

       if(count($product_name)>0)
       {
          $output = '<ul class="list-group" style="display:block; position:absolute; z-indez:1">';
          foreach($product_name as $data)
          {
            $output .='<li class="list-group-item">'.$data->name.'</li>';
          }
          $output .='</ul>';
       }
       else{
        //   $output .='<li class="list-group-item"> No data found </li>';
       }
    }

    return $output;

  }


}
