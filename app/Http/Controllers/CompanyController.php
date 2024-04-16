<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Branch;
use App\Models\multiple;
use App\Models\PaymentVoucher;
use App\Models\PurchaseInvoiceParti;
use App\Models\PurchaseInvoicePartii;
use App\Models\purchaseInvoiceReturnParti;
use App\Models\purchaseInvoiceReturnPartii;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{
    public function fetch_company(){

        $data = DB::table('companies')
        ->get();
        // dd($data);
        $branches = Branch::all();
        return view('admin-side.companies.fetch_company',compact('data','branches'));
    }



   public function show_company_balance_detail($id)
   {
    $data = company::where('id',$id)->get();
    return response([ 'company' => $data]);

   }



    public function store_company(Request $request){
        // dd($request->all());
      
       
        $data = new Company();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        
        $data->date = $request->input('date');
        $data->balance = $request->input('open_balance');
        $data->balance = $request->input('open_balance');
       
        $data->save();
        if($data){
            return redirect('show-company')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_company($id){
        
        $data = Company::find($id);
        $branches = Branch::all();
        return view('admin-side.companies.edit_company',compact('data','branches'));
    }

    public function update_company(Request $request, $id){

        $data = Company::find($id);

        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        
        $data->date = $request->input('date');
        $data->balance = $request->input('open_balance');
        // $data->dues_balance = $request->input('dues_balance');
        $data->update();

        if($data){
            return redirect('show-company')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }

    
    public function destroy_company($id){

        $data = Company::find($id)->first();

        $payment_voucher = PaymentVoucher::where('company_name', $data->name);

        $data->delete();
        $payment_voucher->delete();
        // dd($payment_voucher);

        $purchase_invoice_parti = purchaseInvoiceParti::where('company_id', $id)->first();
        
        $purchase_invoice_partii = purchaseInvoicePartii::where('purchaseInoviceParti_id', $purchase_invoice_parti->id);

        $purchase_invoice_parti->delete();
        $purchase_invoice_partii->delete();

        $purchase_return_invoice_parti = purchaseInvoiceReturnParti::where('company_id', $id)->first();

        $purchase_return_invoice_partii = purchaseInvoiceReturnPartii::where('purchaseInvoiceReturnParti_id', $purchase_return_invoice_parti->id);

        $purchase_return_invoice_parti->delete();
        $purchase_return_invoice_partii->delete();

        // dd($purchase_return_invoice_partii);
      


        
        if($purchase_return_invoice_partii){

            return redirect('show-company')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }


    public function retreive_company($id)
    {
        $company = company::where('name', $id)->first();

        return response()->json([ 'company' => $company]);
    }
    
    
     public function retreive_company_one($id)
    {
        $company = company::where('name', $id)->first();

        return response()->json([ 'company' => $company]);
    }


    // public function multiple_data_form()
    // {
    //     return view('admin-side.multiple');
    // }

    // public function edit_multiple_data($id)
    // {
    //     $multiple = multiple::where('multiple_id', $id)->get();
    //     return view('admin-side.edit-multiple', compact('multiple'));
    // }

    // public function add_multiple_data(Request $request)
    // {
    //     $name = $request->name;
    //     $number = $request->number;

    //     for($i=0; $i < count($name); $i++)
    //     {
    //         $multiple = new multiple;

    //         $multiple->name = $name[$i];
    //         $multiple->number = $number[$i];

    //         $multiple->save();
    //     }

    //     $latest = multiple::latest()->first('id');

    //     dd( $latest);
    // }


    // public function update_multiple_data(Request $request, $id)
    // {
    //     $name = $request->name;
    //     $number = $request->number;

        
    //      $j = $id;

    //     for($i=0; $i < count($name); $i++)
    //     {
    //         $multiple = multiple::find($j);

    //         $multiple->name = $name[$i];
    //         $multiple->number = $number[$i];

    //         $multiple->save();
    //         $j++;
    //     }
    // }
}
