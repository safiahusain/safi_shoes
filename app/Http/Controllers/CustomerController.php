<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Company;
use App\Models\CashVoucher;
use App\Models\Saleman;
use App\Models\saleInvoiceParti;
use App\Models\saleInvoicePartii;
use App\Models\saleInvoiceReturnParti;
use App\Models\saleInvoiceReturnPartii;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Node\FunctionNode;

class CustomerController extends Controller
{
    public function fetch_customer(Request $request){

        $search = $request['search'] ?? "";
        
        if($search != ""){
            $data = customer::where('name','LIKE', "%$search%")->get();
            $branches = Branch::all();
            $saleman = Saleman::all();
            $company = company::all();
            return view('admin-side.customers.fetch_customer',compact('data','branches','saleman','company'));
        }
             $data = customer::all();
             $branches = Branch::all();
            $saleman = Saleman::all();
            $company = company::all();

            return view('admin-side.customers.fetch_customer',compact('data','branches','saleman','company'));

    }


    public function store_customer(Request $request){
       
        $data = new Customer();
        $data->code = $request->input('code');
        $data->date = $request->input('date');
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->mobile = $request->input('mobile');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        $data->saleman_name = $request->input('saleman_name');
        $data->company_name = $request->input('company_name');
        // $data->balance = $request->input('balance');
        $data->balance = $request->input('open_balance');
        $data->balance = $request->input('open_balance');
        
        $data->save();
        if($data){
            return redirect('show-customer')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }
    public function edit_customer($id){
        
        $data = Customer::find($id);
        $branches = Branch::all();
        return view('admin-side.customers.edit_customer',compact('data','branches'));
    }

    public function update_customer(Request $request, $id){

        $data = Customer::find($id);

        $data->code = $request->input('code');
        $data->date = $request->input('date');
        $data->name = $request->input('name');
        $data->mobile = $request->input('mobile');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        $data->saleman_name = $request->input('saleman_name');
        $data->company_name = $request->input('company_name');
        // $data->balance = $request->input('balance');
        $data->balance = $request->input('open_balance');
        $data->update();

        if($data){
            return redirect('show-customer')->with('success',"Record Inserted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Insertion Failed!");
        }
    }


    
    public function destroy_customer($id){

        $data = Customer::find($id);

        $cash_voucher = CashVoucher::where('customer_name', $data->name);

        $data->delete();
        $cash_voucher->delete();

        $sale_invoice_parti = saleInvoiceParti::where('customer_id', $id)->first();

        $sale_invoice_partii = saleInvoicePartii::where('saleInvoiceParti_id', $sale_invoice_parti->id);
        // dd($sale_invoice_partii);

        $sale_invoice_parti->delete();
        $sale_invoice_partii->delete();

        $sale_return_invoice_parti = saleInvoiceReturnParti::where('customer_id', $id)->first();

        $sale_return_invoice_partii = saleInvoiceReturnPartii::where('saleInvoiceReturnParti_id', $sale_return_invoice_parti->id);

        $sale_return_invoice_parti->delete();
        $sale_return_invoice_partii->delete();
        
        
        if($data){
            return redirect('show-customer')->with('success',"Record Deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record Deletion Failed!");
        }
    }


   public function show_customer_balance_detail($id)
   {
    $customer = Customer::where('id', $id)->get();

    return response()->json([ 'customer' => $customer]);
   }
    

}
