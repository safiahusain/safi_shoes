<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentVoucher;
use App\Models\Company;
use App\Models\CompanyLedgerReport;

class PaymentVoucherController extends Controller
{
    
    public function fetch_payment_voucher()
    {
        $payment_voucher = PaymentVoucher::get();
        $company_name = Company::get();

        return view('admin-side.vouchers.fetch_payment_voucher', compact('payment_voucher', 'company_name'));
    }


    public function fetch_company_balance($name)
    {
         $company_balance = Company::where('name', $name)->first('balance');

         return response()->json(['company_balance'=> $company_balance]);
    }


    public function store_payment_voucher(Request $request)
    {
        $payment_voucher = new PaymentVoucher();

        $payment_voucher->company_name = $request->company_name;
        $payment_voucher->description = $request->description;
        $payment_voucher->balance = $request->balance;
        $payment_voucher->paid_amount = $request->paid_amount;
        $payment_voucher->date = $request->date;

        $payment_voucher->save();

        $company = Company::where('name', $request->company_name)->first();
        
        $company->paid_payment_voucher = $company->paid_payment_voucher + $request->paid_amount;

        $company->total_paid_balance = $company->paid + $company->paid_payment_voucher;

        $add_purchase_open_balance = $company->open_balance + $company->purchase_price; 

        $add_purchase_return_paid_balance = $company->purchase_return + $company->total_paid_balance;

        $company->balance = $add_purchase_open_balance - $add_purchase_return_paid_balance;

         $company->save();


           // store company all balance details 

            $latest_id = PaymentVoucher::latest()->first('id');


            $company_ledger_report = new CompanyLedgerReport();

            $company_ledger_report->company_name = $request->company_name;
            $company_ledger_report->date = $request->date;
            $company_ledger_report->particular = "Payment Voucher";
            $company_ledger_report->purchase_amount = '0';
            $company_ledger_report->paid_amount = $request->paid_amount;
            $company_ledger_report->purchaseinvoice_id = $latest_id->id;

            $company_ledger_report->save();

         
        if($payment_voucher){
            return redirect('show-payment-voucher')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }

    }


    public function edit_payment_voucher($id)
    {
        $payment_voucher = PaymentVoucher::find($id);
        $company_name_balance = Company::where('name',$payment_voucher->company_name)->first('balance');
        $company_name = Company::get();


        return view('admin-side.vouchers.edit_payment_voucher', compact('payment_voucher', 'company_name', 'company_name_balance'));
    }


    public function update_payment_voucher($id, Request $request)
    {

        //  this one is used for the company model to substract value from thr paid_payment voucher

        $payment_voucher_one = PaymentVoucher::find($id);

        $payment_voucher = PaymentVoucher::find($id);

        $payment_voucher->company_name = $request->company_name;
        $payment_voucher->description = $request->description;
        $payment_voucher->balance = $request->balance;
        $payment_voucher->paid_amount = $request->paid_amount;
        $payment_voucher->date = $request->date;

        $payment_voucher->update();

        $company = Company::where('name', $request->company_name)->first();
        
        $company->paid_payment_voucher = $company->paid_payment_voucher - $payment_voucher_one->paid_amount;
        
        $company->paid_payment_voucher = $company->paid_payment_voucher + $request->paid_amount;

        $company->total_paid_balance = $company->paid + $company->paid_payment_voucher;

        $add_purchase_open_balance = $company->open_balance + $company->purchase_price; 

        $add_purchase_return_paid_balance = $company->purchase_return + $company->total_paid_balance;

        $company->balance = $add_purchase_open_balance - $add_purchase_return_paid_balance;

         $company->save();

        //  update company ledger report with the help of payment voucher 

        $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id',$id)->first();

        $company_ledger_report->paid_amount = $request->paid_amount;

        $company_ledger_report->update();



         
        if($payment_voucher){
            return redirect('show-payment-voucher')->with('success',"Record Updated Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Updated Failed!");
        }

    }


    public function delete_payment_voucher($id)
    {

        $payment_voucher = PaymentVoucher::find($id);

        $company = Company::where('name',$payment_voucher->company_name)->first();

        $company->paid_payment_voucher = $company->paid_payment_voucher - $payment_voucher->paid_amount;

        $company->total_paid_balance = $company->paid + $company->paid_payment_voucher;

        $add_purchase_open_balance = $company->open_balance + $company->purchase_price; 

        $add_purchase_return_paid_balance = $company->purchase_return + $company->total_paid_balance;

        $company->balance = $add_purchase_open_balance - $add_purchase_return_paid_balance;

         $company->save();

         $payment_voucher->delete();

        //  delete company voucher 

        $company_ledger_report = CompanyLedgerReport::where('purchaseinvoice_id',$id);

        $company_ledger_report->delete();

        // dd($company->balance);

        if($payment_voucher){
            return redirect('show-payment-voucher')->with('success',"Record deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record deleted Failed!");
        }

    }


}
