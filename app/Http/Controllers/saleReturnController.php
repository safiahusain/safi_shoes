<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\warehouse;
use App\Models\Customer;
use App\Models\dufflicateSale;
use App\Models\Product;
use App\Models\saleInvoiceReturnParti;
use App\Models\saleInvoiceReturnPartii;
use App\Models\saleInvoiceParti;
use App\Models\CustomerLedgerReport;
use App\Models\Color;
use App\Models\Size;

class saleReturnController extends Controller
{

   // public function fetch_sale_return_invoice()
   // {

   //    // $customer = customer::all();
   //    $saleinvoice = saleInvoiceReturnParti::all();
   //    return view('admin-side.sales.sale-return-invoice', compact('saleinvoice'));
   // }

   public function show_sale_return_invoice()
   {
      $saleinvoice = saleInvoiceReturnParti::get();
      return view('admin-side.sales.sale-return-invoice', compact('saleinvoice'));

   }


   public function sale_invoice_return_form()
   {
        $customer = customer::all();
        $products = product::all();
        $warehouses = warehouse::get();
        $colors     =   Color::all();
        $sizes      =   Size::all();
      return view('admin-side.sales.sale-return-invoice-form', compact('customer','warehouses','products','colors','sizes'));
   }


   public function customer_sale_return_detail($id)
   {

    $purchaseinvoices = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id',$id)->get();

    $purchaseinvoicei = saleInvoiceReturnParti::find($id);
   //  dd(  $purchaseinvoicei);
    $company = customer::get();
    $warehouses = warehouse::get();

    return view('admin-side.sales.customer-sale-return-detail', compact('purchaseinvoices','purchaseinvoicei', 'company','warehouses'));

   }


   public function store_sale_return_invoice(Request $request)
   {
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
          $saleinvoice = new saleInvoiceReturnParti;
        
          $saleinvoice->customer_id = $request->customer_id;
          $saleinvoice->customer_name = $request->customer_name;
          $saleinvoice->old_balance = $request->old_balance;
          $saleinvoice->date = $request->date;
          $saleinvoice->sub_total = $request->sub_total;
          $saleinvoice->discount = $request->total_discount;
          $saleinvoice->less = $request->extra_discount;
          $saleinvoice->total_value_of_sub_previous = $request->total_value_of_sub_previous;
          $saleinvoice->net = $request->total_value;
          $saleinvoice->total_discount_value = $request->total_discount_value;
          $saleinvoice->paid_customer_balance = $request->paid_customer_balance;
          $saleinvoice->net_customer_balance = $request->net_customer_balance;
          $saleinvoice->sum_of_all_product = $request->sum_of_all_product;

          $saleinvoice->save();
        
            $latest_id = saleInvoiceReturnParti::latest()->first('id');
            
            for($i=0; $i < count($product_name); $i++)
            {
              $saleinvoice = new saleInvoiceReturnPartii;
        
              $saleinvoice->product_name =  $product_name[$i];
              $saleinvoice->warehouse = $warehouse[$i];
              $saleinvoice->size = $size[$i];
              $saleinvoice->color = $color[$i];
              $saleinvoice->quantity = $quantity[$i];
              $saleinvoice->price = $price[$i];
              $saleinvoice->total = $total[$i];
              $saleinvoice->discount = $discount[$i];
              $saleinvoice->less = $discount_value[$i];
              $saleinvoice->net = $net_value_of_every_product[$i];
              $saleinvoice->product_id = $product_id[$i];
                
              $saleinvoice->customer_name = $request->customer_name;
              $saleinvoice->date = $request->date;
        
              $saleinvoice->saleInvoiceReturnParti_id = $latest_id->id;
              
                $saleinvoice->save();


              // find product quantity in sale return  invoice
        
              $purchaseinvoice_quantity = saleInvoiceReturnPartii::where('product_id',$product_id[$i])->sum('quantity');
              $find_product = product::where('id', $product_id[$i])->first();
              $find_product->sale_return = $purchaseinvoice_quantity;
              $find_product->save();
        
              //    add product opening quantity and the purchase invoice product quantity
        
              $find_product = product::where('id', $product_id[$i])->first();
        
              $find_product->sale_return = $purchaseinvoice_quantity;
        
              $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
        
              $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;
        
              $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
        
              $find_product->save();
        
            }
          //   $sub_totals = 0;
    
          // find the value of opening balance of company
    
          $saleinvoice_paid = saleInvoiceParti::where('customer_id',$request->customer_id)->sum('paid_customer_balance');
          $saleinvoice_paid_return = saleInvoiceReturnParti::where('customer_id',$request->customer_id)->sum('paid_customer_balance');
          $saleinvoice_sub_total = saleInvoiceReturnParti::where('customer_id',$request->customer_id)->sum('sub_total');
        


          $customer_id = customer::find($request->customer_id);
    
          $customer_id->paid =  $saleinvoice_paid + $saleinvoice_paid_return;
          $total = $customer_id->paid_cash_voucher + $customer_id->paid;
          $customer_id->total_paid_balance = $total;
    
          $customer_id->sale_return = $saleinvoice_sub_total ;
    
          $total_opening_balance =  $request->net_customer_balance;
    
          $total_purchase_price_open_balance = $customer_id->open_balance + $customer_id->sale_price;
    
          $total_purchase_return_paid = $customer_id->sale_return + $customer_id->total_paid_balance;
    
          $customer_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;
    
          $customer_id->update();
    
    
       // store customer all balance details
    
        $customer_ledger_report = new CustomerLedgerReport();
    
        $customer_ledger_report->customer_name = $request->customer_name;
        $customer_ledger_report->date = $request->date;
        $customer_ledger_report->particular = "Sale Return Invoice";
        $customer_ledger_report->sale_amount = '0';
        $customer_ledger_report->paid_amount = $request->total_value;
        $customer_ledger_report->saleinvoice_id = $latest_id->id;
        $customer_ledger_report->balance = $request->total_value;
    
        $customer_ledger_report->save();
    }
        
      if( $customer_id){
          return redirect('show-sale-return-invoice')->with('success',"Record Inserted Successfully");
      }
      else{
          return redirect()->back()->with('error',"Record Insertion Failed!");
      }

   }


   public function edit_sale_return_invoice( $id)
   {

          $purchaseinvoice = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id',$id)->get();
          $purchaseinvoices = saleInvoiceReturnPartii::find($id);
          $purchaseinvoicei = saleInvoiceReturnParti::find($id);
          $customer = Customer::all();
          $products = product::all();
          $colors     =   Color::all();
        $warehouses = warehouse::get();
        $sizes      =   Size::all();

      return view('admin-side.sales.edit-sale-return-invoice', compact('purchaseinvoice','purchaseinvoices','purchaseinvoicei', 'customer','warehouses','products','colors','sizes'));



   }


   public function update_sale_return_invoice(Request $request,$id)
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
            
          $purchaseinvoice = saleInvoiceReturnParti::find($id);
    
          $purchaseinvoice->customer_id = $request->customer_id;
          $purchaseinvoice->customer_name = $request->customer_name;
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
              
            $purchaseInvoicePartii_id = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id', $id)->first();
            
            $j = $purchaseInvoicePartii_id->id;
            
          for($i=0; $i < count($product_name); $i++)
          {
              $purchaseinvoices = saleInvoiceReturnPartii::find($j);
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
        
              $purchaseinvoices->update();
        
              $j++;
        
        
                // find product quantity in sale return  invoice
        
                $purchaseinvoice_quantity = saleInvoiceReturnPartii::where('product_id',$product_id[$i])->sum('quantity');
                $find_product = product::where('id', $product_id[$i])->first();
                $find_product->sale_return = $purchaseinvoice_quantity;
                $find_product->save();
        
                //    add product opening quantity and the purchase invoice product quantity
        
                $find_product = product::where('id', $product_id[$i])->first();
        
                $find_product->sale_return = $purchaseinvoice_quantity;
        
                $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;
        
                $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;
        
                $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;
        
                $find_product->save();
            }

          // find the value of opening balance of company
    
          $saleinvoice_paid = saleInvoiceParti::where('customer_id',$request->customer_id)->sum('paid_customer_balance');
          $saleinvoice_paid_return = saleInvoiceReturnParti::where('customer_id',$request->customer_id)->sum('paid_customer_balance');
          $saleinvoice_sub_total = saleInvoiceReturnParti::where('customer_id',$request->customer_id)->sum('sub_total');
    
          // dd($saleinvoice_paid);
    
    
          $customer_id = customer::find($request->customer_id);
    
          $customer_id->paid =  $saleinvoice_paid + $saleinvoice_paid_return;
          $total = $customer_id->paid_cash_voucher + $customer_id->paid;
          $customer_id->total_paid_balance = $total;
    
          $customer_id->sale_return = $saleinvoice_sub_total ;
    
          $total_opening_balance =  $request->net_customer_balance;
    
          $total_purchase_price_open_balance = $customer_id->open_balance + $customer_id->sale_price;
    
          $total_purchase_return_paid = $customer_id->sale_return + $customer_id->total_paid_balance;
    
          $customer_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;
    
          $customer_id->update();
    
    
            // update customer ledger report using sale invoice
    
            $customer_ledger_report = CustomerLedgerReport::where('saleinvoice_id', $id)->first();
    
            $customer_ledger_report->paid_amount = $request->sub_total;
    
            $customer_ledger_report->update();
        }

      if( $purchaseinvoices || $purchaseinvoice){
          return redirect('show-sale-return-invoice')->with('success',"Record Updated Successfully");
      }
      else{
          return redirect()->back()->with('error',"Record Updated Failed!");
      }


   }


   public function delete_sale_return_invoice($id)
   {

      // find the product quantity and add to product quantity

      $saleInvoicePartiii = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id', $id)->get();

      foreach($saleInvoicePartiii as $data)
     {

        $find_product = product::where('id', $data->product_id)->first();
        $find_product->sale_return = $find_product->sale_return - $data->quantity;
        $find_product->save();

        $add_open_balance_p_price_s_return = $find_product->opening_balance + $find_product->purchase_price + $find_product->sale_return;

        $add_purchase_return_sale_price = $find_product->purchase_return + $find_product->sale_price;

        $find_product->balance = $add_open_balance_p_price_s_return - $add_purchase_return_sale_price;

        $find_product->save();

     }

      $purchaseparti_sub_total = saleInvoiceReturnParti::where('id', $id)->first();

      $customer_id = customer::where('id', $purchaseparti_sub_total->customer_id)->first();

     $sale_return =  $customer_id->sale_return - $purchaseparti_sub_total->sub_total;

     $customer_id->sale_return =  $sale_return ;

   //   find paid balance

     $customer_id->paid = $customer_id->paid - $purchaseparti_sub_total->paid_customer_balance;

     $customer_id->total_paid_balance = $customer_id->paid + $customer_id->paid_cash_voucher;

     // find all customer balance

       $total_purchase_price_open_balance = $customer_id->open_balance + $customer_id->sale_price;

     $total_purchase_return_paid = $customer_id->sale_return + $customer_id->total_paid_balance;

     $customer_id->balance =   $total_purchase_price_open_balance - $total_purchase_return_paid;

      $customer_id->update();


      saleInvoiceReturnParti::find($id)->delete();

      $purchaseinvoicepartii = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id', $id);

      $purchaseinvoicepartii->delete();


       // delete customer ledger

       $Customer_ledger_report = CustomerLedgerReport::where('saleinvoice_id', $id);

       $Customer_ledger_report->delete();

      if($purchaseinvoicepartii)
      {
        return redirect('show-sale-return-invoice')->with('success',"Record deleted Successfully");

      }
      else{
        return redirect()->back()->with('failed',"Record deletion Failed!");
    }

   }

         public function fetch_customer_data($id)
         {
            $customer = customer::find($id);

            return response()->json([ 'customer' => $customer]);
         }


            public function fetch_product_data($id)
            {

               $product = Product::where('item_code', $id)->get();


               return response()->json([ 'product' => $product]);
            }


            public function fetch_sale_return_invoice_detail_ajax($id)
            {

            $sale_return_detail = saleInvoiceReturnParti::where('id', $id)->get();

            $saleii_return_detail = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id', $id)->get();

            return response()->json([ 'sale_return_detail' => $sale_return_detail, 'saleii_return_detail' => $saleii_return_detail]);

            }



              public function show_product_name_in_li_sale_return(Request $request)
            {
             if($request->ajax())
             $name = $request->name;
             {
               $product_name = product::where('name', 'LIKE', $name.'%')->get();
               // echo $product_name;
                $output = '';

                if(count($product_name)>0)
                {
                   $output = '<ul class="list-group" style="display:block; position:absolute; z-index:1; width: 100%;">';
                   foreach($product_name as $data)
                   {
                     $output .='<li class="list-group-item">'.$data->name.'</li>';
                   }
                   $output .='</ul>';
                }
                else
                {
                   // $output .='<li class="list-group-item"> No data found </li>';
                }
               //  return response()->json(['output'=>$product_name]) ;
                return $output ;

            }

         }

}

