<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseInvoicePartii;
use App\Models\purchaseInvoiceReturnPartii;
use App\Models\saleInvoicePartii;
use App\Models\saleInvoiceReturnPartii;
use App\Models\CashVoucher;
use App\Models\Customer;
use App\Models\Saleman;
use App\Models\PaymentVoucher;
use App\Models\Company;
use App\Models\Product;
use App\Models\purchaseInvoiceParti;
use App\Models\CompanyLedgerReport;
use App\Models\CustomerLedgerReport;
use App\Models\AgeingReport;
use DateTime;
use Carbon\Carbon;
use App\Models\warehouse;
use App\Models\ProductReportShopWareHouse;


class ReportController extends Controller
{
    

    // show purchase report detail
    
    public function show_purchase_report()
    {

        $purchase_report = PurchaseInvoicePartii::get();

        return view('admin-side.Reports.purchase_report', compact('purchase_report'));
    }

    

    // show purchase return report 

    public function show_purchase_return_report()
    {

        $purchase_return_report = PurchaseInvoiceReturnPartii::get();

        return view('admin-side.Reports.purchase_return_report', compact('purchase_return_report'));

    }

    // show sale report detail


    public function show_sale_report()
    {

        $sale_report = saleInvoicePartii::get();

        return view('admin-side.Reports.sale_report', compact('sale_report'));
    }


    

    // show sale return report 


    public function show_sale_return_report()
    {

        $sale_return_report = saleInvoiceReturnPartii::get();

        return view('admin-side.Reports.sale_return_report', compact('sale_return_report'));

    }


    // reports of cash


    public function show_cash_report(Request $request)
    {
    

    
    if($request->customer_name !="" )
    {
       $cash_voucher = CashVoucher::where('customer_name',$request->customer_name)->get();
       $customer = customer::get();
    }
     else{
        $cash_voucher = CashVoucher::get();
        $customer = customer::get();
     }


        return view('admin-side.Reports.cash_report', compact('cash_voucher', 'customer'));

    }


    // getting customer using saleman in ajax

    public function fetch_customer_name_using_saleman($saleman_name)
    {
        $customer_name = Customer::where('saleman_name', $saleman_name)->get();

        return response()->json(['customer_name'=> $customer_name]);
    }



     // reports of cash


     public function show_payment_report(Request $request)
     {
     
 
     if($request->company_name && $request->customer_name === 'all')
     {
        $payment_voucher = PaymentVoucher::where('company_name',$request->company_name)->get();
         $company = company::get();
 
     }
     elseif($request->customer_name !="" && $request->company_name !="")
     {
        $payment_voucher = PaymentVoucher::where('company_name',$request->company_name)->get();
        $company = company::get();
     }
      else{
         $payment_voucher = PaymentVoucher::get();
         $company = company::get();
      }

      return view('admin-side.Reports.payment_report', compact('payment_voucher', 'company'));

 
    }

      // get customer using ajax with the help of company

            public function fetch_customer_name_using_company($company_name)
            {
                $customer_name = Customer::where('company_name', $company_name)->get();

                return response()->json(['customer_name'=> $customer_name]);
            }


        //  show company balance report    

            public function show_company_balance_report(Request $request)
            {

                $company_name = $request['select_company_name'] ?? "";


                if($company_name)
                {
                   $company_balance = company::where('name','LIKE', "%$company_name%")->get();
                   $company_name = company::get();
                return view('admin-side.Reports.company_balance_report', compact('company_balance', 'company_name'));
                 }
              
                    $company_balance = company::get();
                      $company_name = company::get();
    
                      return view('admin-side.Reports.company_balance_report', compact('company_balance', 'company_name'));

            }


            // show all customer balance 


            public function show_customer_balance_report(Request $request)
            {

                // $customer_name = $request['customer_name'] ?? "";

                // if($request->saleman_name && $request->customer_name == 'all')
                // {
                //     $customer_balance = customer::where('saleman_name', $request->saleman_name)->get();
                //     $saleman_name = saleman::get();
  
                //     return view('admin-side.Reports.customer_balance_report', compact('customer_balance', 'customer'));
 
                // }
                if($request->customer_name !="" )
                {
                    $customer_balance = customer::where('name', $request->customer_name)->get();
                    $customer = customer::get();
                    return view('admin-side.Reports.customer_balance_report', compact('customer_balance', 'customer'));

                }
                else{
                      $customer_balance = customer::get();
                      $customer = customer::get();
    
                      return view('admin-side.Reports.customer_balance_report', compact('customer_balance', 'customer'));

            }
        }



        // show company ledger report 


        public function show_company_ledger_report()
        {

         $company_detail = company::get();
         $company_name = company::get();
         return view('admin-side.Reports.company_ledger_report', compact('company_detail','company_name'));


        }


        // show company ledger report using company name

        public function fetch_company_detail_using_company_name_ajax($company_name)
        {
            $company_details = CompanyLedgerReport::where('company_name', $company_name)->get();
           
            $company_names = company::where('name', $company_name)->first();
            
            return response()->json(['company_details'=> $company_details, 'company_names'=> $company_names]);        
        }



         // show customer ledger report 


         public function show_customer_ledger_report()
         {
 
          $salesman_name = saleman::get();
          $customer_name = customer::get();
          return view('admin-side.Reports.customer_ledger_report', compact('salesman_name','customer_name'));
 
 
         }


          // show customer ledger report using cusstomer name

        public function fetch_customer_detail_using_customer_name_ajax($customer_name)
        {
            $customer_details = CustomerLedgerReport::where('customer_name', $customer_name)->get();
            // $total_customer_balance = CustomerLedgerReport::where('customer_name', $customer_name)->sum('sale_amount');
            // $total_customer_paid_balance = CustomerLedgerReport::where('customer_name', $customer_name)->sum('paid_amount');
            $customer_names = Customer::where('name', $customer_name)->first();
            // $sum_opening_balance_and_all_sale = $total_customer_balance + $customer_names->open_balance;
            // $customer_all_balance = $sum_opening_balance_and_all_sale - $total_customer_paid_balance;
            return response()->json(['customer_details'=> $customer_details, 'customer_names'=> $customer_names]);        
        }


        // show all product quantity reports


        public function product_report()
        {
            $show_product_report = Product::get();

            return view('admin-side.Reports.product_report', compact('show_product_report'));
        }
        
        
        
           // show all product with shop and warehouse reports


        public function product_report_shop_warehouse()
        {
            // $product_report_shop_warehouse = Product::get();
            $warehouse = warehouse::get();

            return view('admin-side.Reports.product_report_shop_warehouse', compact('warehouse'));
        }
        
        
        public function fetch_product_name_and_details($name)
        {
            $product_report_shop_warehouse = ProductReportShopWareHouse::where('shop_godam',$name)->get();
            $product_report_shop_warehouse_one = ProductReportShopWareHouse::where('shop_godam',$name)->first();
            
            return response()->json(['product_report_shop_warehouse'=>$product_report_shop_warehouse, 'product_report_shop_warehouse_one'=>$product_report_shop_warehouse_one]);
        }
        
           // show ageing report 


        public function show_ageing_report()
    {
        $date = carbon::now();
   

        $ageing_report = AgeingReport::get();
        return view("admin-side.Reports.ageing_report", compact('ageing_report','date'));
    }


}
