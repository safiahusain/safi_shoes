<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashVoucher;
use App\Models\Customer;
use App\Models\Saleman;
use App\Models\CustomerLedgerReport;
use App\Models\saleInvoiceParti;
use App\Models\AgeingReport;

class CashVoucherController extends Controller
{
    public function fetch_cash_voucher()
    {

        $cash_voucher = CashVoucher::get();
        $customer = Customer::get();

        return view('admin-side.vouchers.fetch_cash_voucher', compact('cash_voucher', 'customer'));
    }

    // ******** get customer name using ajax**************

    public function fetch_customer_invoice($id)
    {
        $customer_invoice = AgeingReport::where('invoice_number', $id)->first();

        return response()->json(['customer_invoice'=> $customer_invoice]);
    }



//    ************************* get customer detail using ajax*****************

 
       public function fetch_customer_detail_for_cash($name)
       {
           
        $customer_address = Customer::where('name', $name)->first();
        $customer_detail = saleInvoiceParti::where('customer_name', $name)->get();

        return response()->json(['customer_detail'=>$customer_detail, 'customer_address'=> $customer_address]);

       }


//   ****************** store all details about cash vouchers **********************

     
public function store_cash_voucher(Request $request)
{
    $cash_voucher = new CashVoucher();

    $cash_voucher->voice_number = $request->voice_number;
    // $cash_voucher->entry_type = $request->entry_type;
    // $cash_voucher->salesman = $request->salesman_name;
    $cash_voucher->customer_address = $request->customer_address;
    $cash_voucher->customer_name = $request->customer_name;
    $cash_voucher->description = $request->description;
    $cash_voucher->paid_amount = $request->paid_amount;
    $cash_voucher->date = $request->date;

    $cash_voucher->save();

    $customer = customer::where('name', $request->customer_name)->first();
        
    $customer->paid_cash_voucher = $customer->paid_cash_voucher + $request->paid_amount;

    $customer->total_paid_balance = $customer->paid + $customer->paid_cash_voucher;

    $add_sale_open_balance = $customer->open_balance + $customer->sale_price; 

    $add_sale_return_paid_balance = $customer->sale_return + $customer->total_paid_balance;

    $customer->balance = $add_sale_open_balance - $add_sale_return_paid_balance;

     $customer->save();


     // store customer all balance details 

     $latest_id = CashVoucher::latest()->first('id');


     $customer_ledger_report = new CustomerLedgerReport();

     $customer_ledger_report->customer_name = $request->customer_name;
     $customer_ledger_report->date = $request->date;
     $customer_ledger_report->particular = "Cash Voucher";
     $customer_ledger_report->sale_amount = '0';
     $customer_ledger_report->paid_amount = $request->paid_amount;
     $customer_ledger_report->saleinvoice_id = $latest_id->id;

     $customer_ledger_report->save();
     
    //  store and sub cash from sale inovice
    
    $ageing_report = AgeingReport::where('invoice_number', $request->customer_invoice)->first();
    
   if ($ageing_report) {
    $ageing_report->receive_amount = $ageing_report->receive_amount + $request->paid_amount;
} else {
    // Handle the case where $ageing_report is null
}

   if ($ageing_report) {
 
    $ageing_report->remaining = $ageing_report->remaining - $request->paid_amount;
} else {
    // Handle the case where $ageing_report is null
}
    
    if ($ageing_report) {
 
   $ageing_report->save();
} else {
    // Handle the case where $ageing_report is null
} 
   

    if($customer){

        return redirect('show-cash-voucher')->with('success',"Record Inserted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record Insertion Failed!");
    }

}


            public function edit_cash_voucher($id)
            {
                $cash_voucher = CashVoucher::find($id);

                $customer_name_balance = customer::where('name',$cash_voucher->customer_name)->first('balance');
                $customer_name = customer::get();

                $customer = Customer::get();


                return view('admin-side.vouchers.edit_cash_voucher', compact('cash_voucher', 'customer_name', 'customer_name_balance', 'customer'));
            }


     public function update_cash_voucher($id, Request $request)
     {

        $cash_voucher_one = CashVoucher::find($id);

        $cash_voucher = CashVoucher::find($id);

        $cash_voucher->voice_number = $request->voice_number;
        // $cash_voucher->entry_type = $request->entry_type;
        // $cash_voucher->salesman = $request->salesman_name;
        $cash_voucher->customer_address = $request->customer_address;
        $cash_voucher->customer_name = $request->customer_name;
        $cash_voucher->description = $request->description;
        $cash_voucher->paid_amount = $request->paid_amount;
        $cash_voucher->date = $request->date;
    
        $cash_voucher->update();


        $customer = Customer::where('name', $request->customer_name)->first();
        
        $customer->paid_cash_voucher = $customer->paid_cash_voucher - $cash_voucher_one->paid_amount;
        
        $customer->paid_cash_voucher = $customer->paid_cash_voucher + $request->paid_amount;

        $customer->total_paid_balance = $customer->paid + $customer->paid_cash_voucher;

        $add_sale_open_balance = $customer->open_balance + $customer->sale_price; 

        $add_sale_return_paid_balance = $customer->sale_return + $customer->total_paid_balance;

        $customer->balance = $add_sale_open_balance - $add_sale_return_paid_balance;

         $customer->save();


         //  update customer ledger report with the help of payment voucher 

        $customer_ledger_report = CustomerLedgerReport::where('saleinvoice_id',$id)->first();

        $customer_ledger_report->paid_amount = $request->paid_amount;

        $customer_ledger_report->update();
    
        if($customer){
    
            return redirect('show-cash-voucher')->with('success',"Record Updated Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record updated Failed!");
        }

     }


     public function delete_cash_voucher($id)
     {
        $cash_voucher = CashVoucher::find($id);

        $customer = customer::where('name',$cash_voucher->customer_name)->first();

        $customer->paid_cash_voucher = $customer->paid_cash_voucher - $cash_voucher->paid_amount;

        $customer->total_paid_balance = $customer->paid + $customer->paid_cash_voucher;

        $add_sale_open_balance = $customer->open_balance + $customer->sale_price; 

        $add_sale_return_paid_balance = $customer->sale_return + $customer->total_paid_balance;

        $customer->balance = $add_sale_open_balance - $add_sale_return_paid_balance;

         $customer->save();

         $cash_voucher->delete();

        //  delete customer ledger report

        $customer_ledger_report = CustomerLedgerReport::where('saleinvoice_id',$id);
         
        $customer_ledger_report->delete();

        if($cash_voucher){
    
            return redirect('show-cash-voucher')->with('success',"Record deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record deleted Failed!");
        }
         
     }

     

}
