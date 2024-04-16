<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\purchaseinvoice;
use App\Models\Company;
use App\Models\Product;
// use App\Models\dufflicatePurchase;
use App\Models\PurchaseInvoiceParti;
use App\Models\PurchaseInvoicePartii;
use App\Models\purchaseInvoiceReturnParti;
use App\Models\purchaseInvoiceReturnPartii;
use App\Models\warehouse;
use App\Models\CompanyLedgerReport;
use App\Models\ProductReportShopWareHouse;
use App\Models\Size;

class purchaseReturnInvoiceController extends Controller
{


    public function customer_purchase_return_detail($id)
    {

     $purchaseinvoices = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id',$id)->get();

     $purchaseinvoicei = purchaseInvoiceReturnParti::find($id);
     $company = Company::get();
     $warehouses = warehouse::get();

     return view('admin-side.purchases.customer-purchase-return-detail', compact('purchaseinvoices','purchaseinvoicei', 'company','warehouses'));

    }

//    show purchase invoice details

   public function fetch_purchase_return_invoice(Request $request)
   {


        $purchaseinvoice = purchaseInvoiceReturnParti::all();
        $colors = Color::all();
        $company = Company::all();
        $date = date('d-m-y');
        return view('admin-side.purchases.fetch_purchase_return', compact('colors', 'company','purchaseinvoice','date'));

   }


   public function purchase_invoice_return_form()
   {

      $company = Company::all();
      $products = Product::all();
      $warehouses = warehouse::get();
      $colors     =   Color::all();
    $sizes      =   Size::all();
    return view('admin-side.purchases.purchase_invoice_return_form', compact('company','warehouses','products','colors','sizes'));
   }



   public function show_invoice_detail()
   {
    $purchaseinvoice = purchaseReturnInvoice::all();
    dd($purchaseinvoice);
    return response()->json([
        "purchaseInvoice" => $purchaseinvoice
    ]);
   }



//    purchase invoice store


   public function store_purchase_return_invoice(Request $request)
   {
    //   dd($request->all());
    // $purchaseinvoice_sub_total = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('sub_total');

    // dd($purchaseinvoice_sub_total);
    
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
        $purchaseinvoice = new purchaseInvoiceReturnParti;
    
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
        $purchaseinvoice->save();

        $latest_id = purchaseInvoiceReturnParti::latest()->first('id');
        
        for($i=0; $i < count($product_name); $i++)
        {
            $purchaseinvoice = new purchaseInvoiceReturnPartii;
        
            $purchaseinvoice->product_name =  $product_name[$i];
            $purchaseinvoice->warehouse = $warehouse[$i];
            $purchaseinvoice->size = $size[$i];
            $purchaseinvoice->color = $color[$i];
            $purchaseinvoice->quantity = $quantity[$i];
            $purchaseinvoice->price = $price[$i];
            $purchaseinvoice->total = $total[$i];
            $purchaseinvoice->discount = $discount[$i];
            $purchaseinvoice->less = $discount_value[$i];
            $purchaseinvoice->product_id = $product_id[$i];
        
            $purchaseinvoice->net = $net_value_of_every_product[$i];
        
            $purchaseinvoice->purchaseInvoiceReturnParti_id = $latest_id->id;
        
            $purchaseinvoice->company_name = $request->company_name;
            $purchaseinvoice->date = $request->date;
        
            $purchaseinvoice->save();
        
        
            $purchaseinvoice_quantity = purchaseInvoiceReturnPartii::where('product_id',$product_id[$i])->sum('quantity');
            $find_product = product::where('id', $product_id[$i])->first();
            $find_product->purchase_return = $purchaseinvoice_quantity;
            $find_product->save();
        
            //    add product opening quantity and the purchase invoice product quantity
        
            $find_product = Product::where('id', $product_id[$i])->first();
        
            $find_product->purchase_return = $purchaseinvoice_quantity;
        
            $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
        
            $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;
        
            $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
        
            $find_product->save();
        }
        //   $sub_totals = 0;
    
        // find the value of opening balance of company
    
        $purchaseinvoice_paid_return = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_paid = PurchaseInvoiceParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_sub_total = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('sub_total');
    
    
        $company_id = Company::find($request->company_id);
    
        $company_id->paid =  $purchaseinvoice_paid + $purchaseinvoice_paid_return;
        $total = $company_id->paid_payment_voucher + $company_id->paid;
        $company_id->total_paid_balance = $total;
    
        $company_id->purchase_return = $purchaseinvoice_sub_total ;
    
        $total_purchase_price_open_balance = $company_id->open_balance + $company_id->purchase_price;
    
        $total_purchase_return_paid = $company_id->purchase_return + $company_id->total_paid_balance;
    
        $company_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;
    
          $company_id->update();
    
    
        // store company all balance details
    
       $company_ledger_report = new CompanyLedgerReport();
    
       $company_ledger_report->company_name = $request->company_name;
       $company_ledger_report->date = $request->date;
       $company_ledger_report->particular = "Purchase Return Invoice";
       $company_ledger_report->purchase_amount = '0';
       $company_ledger_report->paid_amount = $request->total_value;
       $company_ledger_report->purchaseinvoice_id = $latest_id->id;
       $company_ledger_report->balance = $request->total_value;
    
       $company_ledger_report->save();
        //   product report shop and warehouse wise
    
        for($i=0; $i < count($product_name); $i++)
        {
            $product_report_shop_warehouse = new ProductReportShopWareHouse;
        
            $product_report_shop_warehouse->product_name =  $product_name[$i];
            $product_report_shop_warehouse->shop_godam = $warehouse[$i];
            $product_report_shop_warehouse->size = $size[$i];
            $product_report_shop_warehouse->color = $color[$i];
            $product_report_shop_warehouse->purchase_return_quantity = $quantity[$i];
            $product_report_shop_warehouse->purchase_return_value = $price[$i];
            $product_report_shop_warehouse->company_name = $request->company_name;
            $product_report_shop_warehouse->purchase_sale_id = $latest_id->id;
        
            $product_report_shop_warehouse->save();
       }
    }


    if( $purchaseinvoice)
    {
        return redirect('show-purchase-return-invoice')->with('success',"Record Inserted Successfully");
    }
    else
    {
        return redirect()->back()->with('error',"Record Insertion Failed!");
    }


   }

//  edit  purchase invoice

   public function edit_purchase_return_invoice($id)
   {
    $purchaseinvoice = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id',$id)->get();
    // dd($purchaseinvoice);
    $purchaseinvoices = purchaseInvoiceReturnPartii::find($id);
    $purchaseinvoicei = purchaseInvoiceReturnParti::find($id);
    $company = Company::get();
    $warehouses = warehouse::get();
    $products = Product::all();
    $colors     =   Color::all();
    $sizes      =   Size::all();
    return view('admin-side.purchases.edit_purchase_return', compact('purchaseinvoice','purchaseinvoices','purchaseinvoicei', 'company','warehouses','products','colors','sizes'));
   }






   //  update  purchase invoice


   public function update_purchase_return_invoice(Request $request, $id)
   {
    // $purchaseinvoice_paid->update();

    // $latest_id = purchaseInvoiceReturnParti::latest()->first('id');

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

    $j = $purchaseInvoicePartii_id->id;
    
    
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
        $purchaseinvoice = purchaseInvoiceReturnParti::find($id);
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
    
        $purchaseInvoicePartii_id = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id', $id)->first();
        
        $j = $purchaseInvoicePartii_id->id;
        
        for($i=0; $i < count($product_name); $i++)
        {
            $purchaseinvoices = purchaseInvoiceReturnPartii::find($j);
        
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
        
            // $purchaseinvoices->purchaseInvoiceReturnParti_id = $latest_id->id;
        
            $purchaseinvoices->update();
        
            $j++;
        
            $purchaseinvoice_quantity = purchaseInvoiceReturnPartii::where('product_id',$product_id[$i])->sum('quantity');
            $find_product = Product::where('id', $product_id[$i])->first();
            $find_product->purchase_return = $purchaseinvoice_quantity;
            $find_product->save();
        
            //    add product opening quantity and the purchase invoice product quantity
        
            $find_product = Product::where('id', $product_id[$i])->first();
        
            $find_product->purchase_return = $purchaseinvoice_quantity;
        
            $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
        
            $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;
        
            $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
        
            $find_product->save();
        }


        // find the value of opening balance of company
    
        $purchaseinvoice_paid_return = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_paid = PurchaseInvoiceParti::where('company_id',$request->company_id)->sum('paid_customer_balance');
        $purchaseinvoice_sub_total = purchaseInvoiceReturnParti::where('company_id',$request->company_id)->sum('sub_total');
    
    
        $company_id = Company::find($request->company_id);
    
        $company_id->paid =  $purchaseinvoice_paid + $purchaseinvoice_paid_return;
        $total = $company_id->paid_payment_voucher + $company_id->paid;
        $company_id->total_paid_balance = $total;
    
        $company_id->purchase_return = $purchaseinvoice_sub_total ;
    
        $total_purchase_price_open_balance = $company_id->open_balance + $company_id->purchase_price;
    
        $total_purchase_return_paid = $company_id->purchase_return + $company_id->total_paid_balance;
    
        $company_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;
    
        $company_id->update();
    
    
        // update company ledger report using sale invoice
    
        $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id', $id)->first();
    
        $company_ledger_report->paid_amount = $request->sub_total;
    
        $company_ledger_report->update();
    }

    if( $purchaseinvoices || $purchaseinvoice)
    {
        return redirect('show-purchase-return-invoice')->with('success',"Record Inserted Successfully");
    }
    else
    {
        return redirect()->back()->with('error',"Record Insertion Failed!");
    }

   }


   public function delete_purchase_return_invoice($id)
   {

    $purchaseinvoicepartiii = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id', $id)->get();

    foreach($purchaseinvoicepartiii as $data)
   {

      $find_product = Product::where('id', $data->product_id)->first();

      $find_product->purchase_return = $find_product->purchase_return - $data->quantity;

      $find_product->save();


      $find_product = Product::where('id', $data->product_id)->first();

      $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;

      $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;

      $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;

      $find_product->save();

   }
//    dd($find_product);


    $purchaseparti_sub_total = purchaseInvoiceReturnParti::where('id', $id)->first();
    // dd($purchaseparti_sub_total->company_id);

    $company_id = Company::where('id', $purchaseparti_sub_total->company_id)->first();
    // dd($company_id);

    $purchase_return =  $company_id->purchase_return - $purchaseparti_sub_total->sub_total;

    $company_id->purchase_return =  $purchase_return ;

    $company_id->paid = $company_id->paid - $purchaseparti_sub_total->paid_customer_balance;

    $company_id->total_paid_balance = $company_id->paid + $company_id->paid_payment_voucher;

    // $company_id->purchase_price =  $purchase_price ;


   $total_purchase_price_open_balance = $company_id->open_balance + $company_id->purchase_price;

   $total_purchase_return_paid = $company_id->purchase_return + $company_id->total_paid_balance;

   $company_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;

    $company_id->update();


    purchaseInvoiceReturnParti::find($id)->delete();

       $purchaseinvoicepartii = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id', $id);

       $purchaseinvoicepartii->delete();


       // delete company ledger

       $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id', $id);

       $company_ledger_report->delete();

       if($purchaseinvoicepartii)
       {
         return redirect('show-purchase-return-invoice')->with('success',"Record deleted Successfully");

       }
       else{
         return redirect()->back()->with('failed',"Record deletion Failed!");
     }


   }




   public function fetch_product_using_code($code)
   {

    $products = Product::where('item_code', $code)->get();

    return response()->json([ 'products' => $products]);

   }


   public function fetch_purchase_return_invoice_detail_ajax($id)
   {

    $purchase_return_detail = purchaseInvoiceReturnParti::where('id', $id)->get();

    $purchaseii_return_detail = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id', $id)->get();

    return response()->json([ 'purchase_return_detail' => $purchase_return_detail, 'purchaseii_return_detail' => $purchaseii_return_detail]);

   }



}
