<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\saleInvoiceParti;
use App\Models\saleInvoicePartii;
use App\Models\saleInvoiceReturnPartii;
use App\Models\PurchaseInvoiceParti;
use App\Models\Product;
use App\Models\Complaint;
use App\Models\Property;
use App\Models\AssignStock;
use App\Models\SalesBalance;
use App\Models\SaleInvoice;
use App\Models\BranchStock;
use App\Models\Role;
use App\Models\Sale_Property;
use App\Models\Saler;

use Session;
use Hash;
use Illuminate\Support\Facades\DB;


class CustomAuthController extends Controller
{


    public function redirect()
    {
        // $user_id    =   Auth::user();
        //     dd($user_id);
        if(Auth::id())
        {
            return redirect('/home');
        }
        else{
            return view('auth.login');
        }
    
    }


    public function index()
    {
       
        // return view('auth.login');
      
        // if(Auth::id()){

            // $user = Auth::user()->id;
            // $data =User::find($id);

            $id = Auth::id();
            

            // if($id->role_id == 0){
                // $count1= User::count();   
                // dd($count1); 
                // $count1= User::count();   
                // $count2= Property::count();   
                // $count3= Sale_Property::count();   
                // $count4= City::count();   
                // $count5=Buyer::count();   
                // $count6= Saler::count();   
                // $count7= Sale_Property::where('role','=','completed')->count();
                // $count8= Sale_Property::where('role','=','pending')->count();
                // dd($count1);
            //   $user = User::limit(5)->get();
                // $data =User::find($id);
                // dd($data);
                // return view('admin-side.master',compact('data'));
                // return view('admin-side.master',compact('data','user','count1','count2','count3',
                //             'count4','count5','count6','count7','count8'));
            // }
            // elseif($id->role_id == 0){

            //     $id= Auth::user()->id;
            //     $data =User::find($id);
            //     // $members =Member::all();
            //     // $products =Product::all();
            // //  dd(2);
            //     // return view('front-side.master',compact('data'));
            //     return view('asad');
            // }
        
        // if($id->role_id == 0)
        // {
            // $members = Member::all(); 
            // $products =Product::all();
                //  dd(2);
            $data       =   User::find($id);
            
            if($data->role_id == 1)
            {
                $total_product    =   Product::count();
                $branches         =   User::where('role_id',2)->count();
                $warehouse        =   User::where('role_id',5)->count();
                $products         =   Product::latest()->get();
                $sales            =   saleInvoicePartii::where('warehouse',$id)->sum('net');
                $return_sales     =   saleInvoiceReturnPartii::where('warehouse',$id)->sum('net');
                $total_sales      =   $sales+$return_sales;
                $sale_invoices    =   saleInvoiceParti::count();
                $total_purchase   =   PurchaseInvoiceParti::count();
            }
            else
            {
                $warehouses =   AssignStock::where([
                                'user_id'  =>  $data->id,
                                'target'   =>  'stock',
                                ])->with('product')->get();
                
                $product_id =   [];
                $i          =   0;
                
                foreach ($warehouses as $key => $value) 
                {
                    $productId   = $value->product->id;
                
                    if (!in_array($productId, $product_id)) 
                    {
                        $product_id["id_$i"]      =   $productId;
                        $i++;
                    }
                }
        
                $total_product    =   count($product_id);
                $branches         =   null;
                $warehouse        =   null;
                $total_sales      =   null;
                $products         =   Product::whereIn('id', $product_id)->get();
                
                if($data->role_id == 2)
                {
                    $sale_invoices    =   SalesBalance::where([
                                              'user_id' =>  $id,
                                              'target'  =>  'sales',
                                              ])->count();
                }
                else
                {
                    $sale_invoices    =   AssignStock::where([
                                              'created_by'  =>  $id,
                                              'target'      =>  'stock',
                                              ])->count();
                }
                $total_purchase   =   AssignStock::where([
                                      'user_id' =>  $id,
                                      'target'  =>  'stock',
                                      ])->count();
                
                // dd($products,$product_id);
                
            }
            
            return view('front-side.master',compact('total_product','total_sales','total_purchase','products','branches','warehouse','sale_invoices','sale_invoices'));

        // }

    } 
    
    //index home function closed here

    public function create_login()
    {
        return view('auth.login');
    }

    public function check_login(Request $request)
    {
        // dd(1);
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        //$credentials contains info obtained from login form
        $credentials = $request->only('email', 'password');

        // dd($credentials);
        if (Auth::attempt($credentials)) {
            // dd(2);
            return redirect()->intended('home')
                        ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function create_register()
    {
        return view('auth.registration');
    }

    public function store_register(Request $request)
    {
        $request->validate([

            'name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8',
        
        ]);

        $data = $request->all();
        // dd($data);
        $check = $this->createUser($data);
        return redirect("dashboard")->withSuccess('Successfully logged-in!');
    }

    public function createUser(array $data)
    {
        // $is_admin = $data['is_admin'];
        // dd($is_admin);
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        // 'role_id' => '1',
        'role_id' => $data['role_id'],
        'password' => Hash::make($data['password']),
        // 'is_admin' => $is_admin,
      ]);
    }


    public function dashboardView()
    {
       
         if(Auth::id()){
            
            $id = Auth::id();
            // dd($id);
            $data =User::find($id);
            
            // dd($data);
            Auth::user()->user;
            $id         =   Auth::id();
            $data       =   User::find($id);
            
            if($data->role_id == 1)
            {
                $total_product    =   Product::count();
                $branches         =   User::where('role_id',2)->count();
                $warehouse        =   User::where('role_id',5)->count();
                $products         =   Product::latest()->get();
                $sales            =   saleInvoicePartii::where('warehouse',$id)->sum('net');
                $return_sales     =   saleInvoiceReturnPartii::where('warehouse',$id)->sum('net');
                $total_sales      =   $sales+$return_sales;
                $sale_invoices    =   saleInvoiceParti::count();
                $total_purchase   =   PurchaseInvoiceParti::count();
            }
            else
            {
                $warehouses =   AssignStock::where([
                                'user_id'  =>  $data->id,
                                'target'   =>  'stock',
                                ])->with('product')->get();
                
                $product_id =   [];
                $i          =   0;
                
                foreach ($warehouses as $key => $value) 
                {
                    $productId   = $value->product->id;
                
                    if (!in_array($productId, $product_id)) 
                    {
                        $product_id["id_$i"]      =   $productId;
                        $i++;
                    }
                }
        
                $total_product    =   count($product_id);
                $branches         =   null;
                $warehouse        =   null;
                $total_sales      =   null;
                $products         =   Product::whereIn('id', $product_id)->get();
                
                if($data->role_id == 2)
                {
                    $sale_invoices    =   SalesBalance::where([
                                              'user_id' =>  $id,
                                              'target'  =>  'sales',
                                              ])->count();
                }
                else
                {
                    $sale_invoices    =   AssignStock::where([
                                              'created_by'  =>  $id,
                                              'target'      =>  'stock',
                                              ])->count();
                }
                $total_purchase   =   AssignStock::where([
                                      'user_id' =>  $id,
                                      'target'  =>  'stock',
                                      ])->count();
                
                // dd($products,$product_id);
                
            }
                
            return view('admin-side.master',compact('data','total_product','total_sales','total_purchase','products','branches','warehouse','sale_invoices'));
            
            if(Auth::User()->role_id =='0')
            {
                
                $data =User::find($id);
                $total_product    =   Product::count();
                $products         =   Product::latest()->get();
                $total_sales      =   saleInvoiceParti::count();
                $total_purchase   =   PurchaseInvoiceParti::count();
               return view('front-side.master',compact('data','total_product','total_sales','total_purchase','products'));
           }
           

        }

        else{
                return redirect("login")->withSuccess('Access is not permitted');
            }

    } //dashboard view function closed here


    public function logout() {
        Session::flush();
        Auth::logout();
        // dd(1);
        return redirect('login')->with(Auth::logout());

    }

    public function front_end(){
        $data =User::find($id);
        // $members =Member::all();
        // $products =Product::all();
        // dd(2);
        $id         =   Auth::id();
        $data       =   User::find($id);
        
        if($data->role_id == 1)
        {
            $total_product    =   Product::count();
            $branches         =   User::where('role_id',2)->count();
            $warehouse        =   User::where('role_id',5)->count();
            $products         =   Product::latest()->get();
            $sales            =   saleInvoicePartii::where('warehouse',$id)->sum('net');
            $return_sales     =   saleInvoiceReturnPartii::where('warehouse',$id)->sum('net');
            $total_sales      =   $sales+$return_sales;
            $sale_invoices    =   saleInvoiceParti::count();
            $total_purchase   =   PurchaseInvoiceParti::count();
        }
        else
        {
            $warehouses =   AssignStock::where([
                            'user_id'  =>  $data->id,
                            'target'   =>  'stock',
                            ])->with('product')->get();
            
            $product_id =   [];
            $i          =   0;
            
            foreach ($warehouses as $key => $value) 
            {
                $productId   = $value->product->id;
            
                if (!in_array($productId, $product_id)) 
                {
                    $product_id["id_$i"]      =   $productId;
                    $i++;
                }
            }
    
            $total_product    =   count($product_id);
            $branches         =   null;
            $warehouse        =   null;
            $total_sales      =   null;
            $products         =   Product::whereIn('id', $product_id)->get();
            
            if($data->role_id == 2)
            {
                $sale_invoices    =   SalesBalance::where([
                                          'user_id' =>  $id,
                                          'target'  =>  'sales',
                                          ])->count();
            }
            else
            {
                $sale_invoices    =   AssignStock::where([
                                          'created_by'  =>  $id,
                                          'target'      =>  'stock',
                                          ])->count();
            }
            
            $total_purchase   =   AssignStock::where([
                                  'user_id' =>  $id,
                                  'target'  =>  'stock',
                                  ])->count();
            
            // dd($products,$product_id);
            
        }
        return view('front-side.master',compact('data','total_product','total_sales','total_purchase','products','branches','warehouse','sale_invoices'));
    }

    public function store_user(Request $request){

        // dd($request->all());
        // $request->validate([

        //     'name' => 'required|min:3|max:50',
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        //     'role_id' => 'required',
        // ]);

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request['password']);
        $data->role_id = $request->role_id;
        $data->save();
        // dd($data);
        if ($data) {
            
            return redirect('show-user')->with('success', 'Success! Record added Successfully');
        
        }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }
    
    // profile
    public function fetch_profile($id = null){
        // dd($id);
        $id = Auth::id();
        // dd($id);
        $data =User::find($id);
        // dd($data);
       return view('admin-side.users.fetch_profile',compact('data'));
    }
    public function edit_profile($id = null){
        $id = Auth::id();
        // dd($id);
        $data =User::find($id);
        // dd($data);
       return view('admin-side.users.edit_profile',compact('data'));
    }
    
    
    public function update_profile(Request $request) {
        
        // dd($request->all());
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            // 'current-password' => 'required',
            // 'new-password' => 'required|string|min:8|confirmed',
        ]);

        
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();
        if ($user) {
            
            return redirect()->back()->with("success","Password successfully changed!");
            return redirect('show-user')->with('success', 'Success! Record added Successfully');
        
        }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }

    public function fetch_user(){
            // dd(1);
            $data = User::all();
            // dd($data);
            $roles = Role::where('status', '=', 'active')->orderBy('id', 'ASC')->get();
            // dd($roles);
            return view('admin-side.users.fetch_user', compact('data','roles'));
            // return view('admin-side.users.fetch_user', compact('data'));
        
    }
    public function edit_user($id){
        // dd($id);
        $data   =   User::find($id);
        $roles  =   Role::where('status', '=', 'active')->orderBy('id', 'ASC')->get();
        // dd($roles);
        return view('admin-side.users.edit_user', compact('data','roles'));
    }
    public function update_user(Request $request, $id){

        // dd($request->all());
        $data = User::find($id);
        if($request->has('name') || $request->has('email') || $request->has('is_admin')){
            // dd(1);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->role_id = $request->role_id;
            $data->update();
        // dd($data);
        if ($data) {
            
            return redirect('show-user')->with('success', 'Success! Record added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
            }
        
        }
        else{
            echo 'no data exist';
        }
        
    }

    public function destroy_user($id){

        // dd(1);
        $data = User::find($id);
        $data->delete();
        if($data){
            return redirect('show-user')->with('success', " Record deleted Successfully");
        }
        else{
            return redirect()->back()->with('failed',"Record not Deleted!");
        }
    }

    public function fetch_role(){
        // dd(1);
        $data = Role::get();
        // dd($data);
        
        return view('admin-side.users.fetch_role', compact('data'));
    
    }
    public function store_role(Request $request)
    {
        // dd(2);
        // $request->validate([
            
        //     'role_as' => 'required|max:255',
        // ]);
        // dd(1);
        $data = new Role();
        $data->role_as = $request->input('role_as');
       
        $data->save();
        if ($data) {
            
            return back()->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
        
    }


public function edit_role($id){
    // dd($id);
    $roles = Role::where('id', $id)->get();
    // dd($roles);
    $user_id = Auth::user()->id;
    $data = user::find($user_id);
    // dd($roles);
    // $roles = role::all();
    // $roles =DB::table('users')->select('is_admin')->where('status', '=', 'active')->orderBy('id', 'ASC')->get();
    return view('admin-side.users.edit_role', compact('roles', 'data'));
}


public function update_role(Request $request, $id){

    // dd($request->all());
    $data = Role::find($id);
    if($request->has('role_id')){
        // dd(1);
        $data->role_as = $request->role_id;
        // $data->email = $request->email;
        // $data->is_admin = $request->is_admin;
        $data->update();
    // dd($data);
    if ($data) {
        
        return redirect('show-role')->with('success', 'Success! Record added Successfully');
    
        }
        else {
        
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
    
    }
    // else{
    //     echo 'no data exist';
    // }
    
}


public function destroy_role($id){

    // dd(1);
    $data = Role::find($id);
    $data->delete();
    if($data){
        return redirect('show-role')->with('success', " Record deleted Successfully");
    }
    else{
        return redirect()->back()->with('failed',"Record not Deleted!");
    }
}


        public function asad()
        {
            return view('asad');
        }



} //custom-auth controller
