<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Property_type;
use App\Models\Type;
use App\Models\Saler;
use Illuminate\Support\Facades\DB;
use App\Models\Buyer;
use App\Models\Property;
use App\Models\Sale_Property;


class PropertyController extends Controller
{
    
    public function fetch_city(){
        // dd(1);
       $data = City::get();
    //    dd($data);
       return view('admin-side.property.fetch_city',compact('data'));
    }

    public function store_city(Request $request)
    {
        // dd(2);
        $data = new City; 

        $validated = $request->validate([
            'name' => 'required',
            ], [
            'name.required' => 'Name is required',
        ]);
        $data->name = $request->input('name');
        $data->save();
       
        if ($data) {
            
            return back()->with('success', 'Success! Record added Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not created');
        }
       
    }   

    public function edit_city($id){
        // dd($id);
        $data = City::find($id);
        // dd($data);
        return view('admin-side.property.edit_city', compact('data'));
       
    }
    public function update_city(Request $request, $id)
    {
        // dd($id);
        $data = City::find($id);
        $data->name = $request->name;
        $data->update();
        if ($data) {
            
            return redirect('show-city')->with('success', 'Success! Record Updated Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
      

    }
    public function destroy_city($id){
      
        $data = City::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-city')->with('success', 'Success! Record Deleted Successfully');
        }
        else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
        }
       
    }

    public function fetch_area(){
        // dd(1);
    //    $data = Area::all();
        $city = City::all();
       $data = Area::join('cities', 'areas.city_id', '=', 'cities.id')
       ->select('areas.*','cities.name as city_name')
       ->get();
    //    dd($data);
       return view('admin-side.property.fetch_area',compact('data','city'));
    }

    public function store_area(Request $request)
    {
        // dd(2);
        $validated = $request->validate([
            'name' => 'required',
            'city_id' => 'required',
            ], [
            'name.required' => 'Name is required',
            'city_id.required' => 'City Name is required',
        ]);
        $data = new Area; 
        $data->name = $request->input('name');
        $data->city_id = $request->input('city_id');
        $data->save();
        if ($data) {
            
            return redirect('show-area')->with('success', 'Success! Record added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
            }
        
        }
        
        
    public function edit_area($id){
        // dd($id);
        $city = City::all();
        $data = Area::find($id);
        // dd($data);
        return view('admin-side.property.edit_area', compact('data','city'));
       
    }

    public function update_area(Request $request, $id)
    {
        // dd($id);
        $data = Area::find($id);
        $data->name = $request->name;
        $data->city_id = $request->city_id;
        $data->update();
        if ($data) {
            
            return redirect('show-area')->with('success', 'Success! Record Updated Successfully');
        
            }
        else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Updated');
            }
        

    } 

    public function destroy_area($id){
      
        $data = Area::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-area')->with('success', 'Success! Record Deleted Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not deleted');
            }
        
    }

    public function fetch_type(){
        // dd(1);
       $data = Property_type::all();
    //    dd($data);
       return view('admin-side.property.fetch_type',compact('data'));
    }

    public function store_type(Request $request)
    {
        // dd(2);
        $data = new Property_type(); 
        $data->name = $request->input('name');
        $data->save();
        if ($data) {
            
            return redirect('show-type')->with('success', 'Success! Record added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
            }
      
    }   

    public function edit_type ($id){
        // dd($id);
        $data = Property_type::find($id);
        // dd($data);
        return view('admin-side.property.edit_type', compact('data'));
       
    }
    public function update_type(Request $request, $id)
    {
        // dd($id);
        $data = Property_type::find($id);
        $data->name = $request->name;
        $data->update();
        if ($data) {
            
            return redirect('show-type')->with('success', 'Success! Record Updated Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Updated');
            }

    }
    public function destroy_type($id){
      
        $data = Property_type::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-type')->with('success', 'Success! Record Deleted Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
            }
        
    }

    //Saler and Buyer
    public function fetch_saler(){
        // dd(1);
    //    $data = Saler::all();
    $data = DB::table('salers')->get();
    // ->join('cities', 'cities.id', '=', 'salers.city_id')
    // ->join('areas', 'areas.id', '=', 'salers.area_id')
    // ->join('property_types', 'property_types.id', '=', 'salers.type_id')
    // ->where('salers.status','active')
    // // ->where('salers.id', '=', 5)
    // ->select('salers.*', 'cities.name as city_name','areas.name as area_name','property_types.name as type_name' )
    // ->get();
    // dd($data);

       $city = City::all();
       $area = Area::all();
       $type = Property_type::all();
     
    //    dd($data);
       return view('admin-side.dealers.fetch_saler',compact('data','city','area','type'));
    }
   
    public function store_saler(Request $request)
    {
        // dd($request->all());
        $data = new Saler;

        // if($request->hasFile('avatar')){
      
        //     // dd(1);
        //     $file = $request->file('avatar');
        //     $extenstion = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$extenstion;
        //     $file->move('uploads/products/', $filename);
        //     $avatar =$data->avatar= $filename;
        //     // dd($avatar);
        // }
      
        $data->name = $request->input('name');
        // $data->title = $request->input('title');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        // dd($data);
        $data->save();
        if ($data) {
            
            return redirect('show-saler')->with('success', 'Success! Record added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not created');
            }
       
    }

    public function edit_saler($id){
        // dd($id);
        $data = Saler::find($id);
       
        $city = City::all();
        $area = Area::all();
        $saler = Saler::all();
        $buyer = Buyer::all();
        $type = Property_type::all();
        return view('admin-side.dealers.edit_saler',compact('data','city','type','area','saler','buyer'));
       
    }
    public function update_saler(Request $request, $id)
    {
        // dd($request->all());
        $data = Saler::find($id);
        
        $data->name = $request->input('name');
        // $data->title = $request->input('title');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        // dd($data);
        $data->update();
        if ($data) {
            
            return redirect('show-saler')->with('success', 'Success! Record Updated Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Updated');
            }
         
    }
    public function destroy_saler($id){
      
        $data = Saler::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-saler')->with('success', 'Success! Record Deleted Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
            }
         
        
    }
    
    // Buyer's functions
    public function fetch_buyer(){
        // dd(1);
        $data = DB::table('buyers')
        // ->join('cities', 'cities.id', '=', 'buyers.city_id')
        // ->join('areas', 'areas.id', '=', 'buyers.area_id')
        // ->join('property_types', 'property_types.id', '=', 'buyers.type_id')
        // ->where('buyers.status','active')
        // // ->where('salers.id', '=', 5)
        // ->select('buyers.*', 'cities.name as city_name','areas.name as area_name','property_types.name as type_name' )
        ->get();
        // dd($data);
       $city = City::all();
       $area = Area::all();
       $type = Property_type::all();
     
    //    dd($data);
       return view('admin-side.dealers.fetch_buyer',compact('data','city','area','type'));
    }

    public function store_buyer(Request $request)
    {
        // dd($request->all());
        $data = new Buyer();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        // dd($data);
        $data->save();
        if ($data) {
            
            return redirect('show-buyer')->with('success', 'Success! Record Added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Inserted');
            }
       
    }
   
    public function edit_buyer($id){
        // dd($id);
        $data = Buyer::find($id);
       
        $city = City::all();
        $area = Area::all();
        $type = Property_type::all();
        // dd($data);
        return view('admin-side.dealers.edit_buyer', compact('data','city','area','type'));
       
    }
    public function update_buyer(Request $request, $id)
    {
        // dd($request->all());
        $data = Buyer::find($id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->phone = $request->input('phone');
        $data->address = $request->input('address');
        // dd($data);
        $data->update();
        if ($data) {
            
            return redirect('show-buyer')->with('success', 'Success! Record Updated Successfully');
        
            }
        else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Updated');
        }
    
    }
    public function destroy_buyer($id){
      
        $data = Buyer::find($id);
        $data->delete();
        if ($data) {
            return redirect('show-buyer')->with('success', 'Success! Record Deleted Successfully');
        
            }
            else {
            
            return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
        }
    }

    // public function GetSubCatAgainstMainCatEdit($id){
    //     // dd($id);
    //     echo json_encode(DB::table('areas')->where('city_id', $id)->get());
    //     // echo json_encode(DB::table('salers')->where('id', $id)->get());
    // }
   
    public function fetch_property(){
        // dd(1);
        $data = DB::table('properties')
        ->join('salers', 'salers.id', '=', 'properties.saler_id')
        ->join('areas', 'areas.id', '=', 'properties.area_id')
        ->join('property_types', 'property_types.id', '=', 'properties.type_id')
        ->join('cities', 'cities.id', '=', 'properties.city_id')
        ->select('properties.*', 'properties.title as title', 'properties.price as price',
            'areas.name as area_name', 'property_types.name as type_name','cities.name as city_name',
            'salers.name as name','salers.email as email','salers.phone as phone','salers.address as address'
            )
        // ->where('properties.saler_id','=','salers.id')    
        ->get();
        // dd($data);
        $saler = Saler::all();
        $buyer = Buyer::all();
        $city = City::all();
        $area = Area::all();
        $type = Property_type::all();

       return view('admin-side.dealers.fetch_property',compact('saler','buyer','data','city','area','type'));
    }
    
    public function store_property(Request $request)
    {
        // dd($request->all());
        $data = new Property();

        if($request->hasFile('avatar')){
      
            // dd(1);
            $file = $request->file('avatar');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/products/', $filename);
            $avatar =$data->avatar= $filename;
            // dd($avatar);
            $data->avatar = $avatar;
        }
        else{
            unset($request->avatar);
        }

        $data->title = $request->input('title');
        $data->saler_id = $request->input('saler_id');
        // $data->avatar = $request->input('avatar');
        $data->price = $request->input('price');
        $data->marlas = $request->input('marlas');
        $data->type_id = $request->input('type_id');
        $data->city_id = $request->input('city_id');
        $data->area_id = $request->input('area_id');
        // $data->avatar = $avatar;
        // dd($data);
        $data->save();
        if ($data) {
            
            return redirect('show-property')->with('success', 'Success! Record Added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Added');
            }
       
    }

    public function edit_property($id){

        $data = Property::find($id);
        // dd($data);
        $city = City::all();
        $area = Area::all();
        $buyer = Buyer::all();
        $saler = Saler::all();
     //    $buyer = Buyer::all();
        $type = Property_type::all();

        return view('admin-side.dealers.edit_property',compact('data','city','area','type','buyer','saler'));
    }
    public function update_property(Request $request, $id){
        // dd(1);
        // dd($request->all());
        $data = Property::find($id);
        if($request->hasFile('avatar')){
      
            // dd(1);
            $file = $request->file('avatar');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/products/', $filename);
            $avatar =$data->avatar= $filename;
            // dd($avatar);
            $data->avatar = $avatar;
        }
        else{
            unset($request->avatar);
        }
        $data->title = $request->input('title');
        $data->price = $request->input('price');
        $data->marlas = $request->input('marlas');
        $data->type_id = $request->input('type_id');
        $data->city_id = $request->input('city_id');
        $data->area_id = $request->input('area_id');
        // $data->avatar = $avatar;
        $data->update();
        // dd($data);
        if ($data) {
            
            return redirect('show-property')->with('success', 'Success! Record Updated Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
            }
        }

        public function destroy_property($id){
      
            $data = Property::find($id);
            $data->delete();
            if ($data) {
                return redirect('show-property')->with('success', 'Success! Record Deleted Successfully');
            
                }
                else {
                
                return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
            }
        }
        
    // sale_property
    public function fetch_sale_property(){
        // dd(1);
    
        $data = DB::table('sale_properties')
        ->join('properties', 'properties.id', '=', 'sale_properties.property_id')
        // ->join('areas', 'areas.id', '=', 'properties.area_id')
        // ->join('property_types', 'property_types.id', '=', 'properties.type_id')
        // ->join('cities', 'cities.id', '=', 'areas.city_id')
        ->join('salers', 'salers.id', '=', 'sale_properties.saler_id')
        ->join('buyers', 'buyers.id', '=', 'sale_properties.buyer_id')
        ->select('sale_properties.*', 'properties.title as title', 'properties.price as price',
            // 'areas.name as area_name', 'property_types.name as type_name','cities.name as city_name',
            'salers.name as saler_name','salers.email as saler_email','salers.phone as saler_phone','salers.address as saler_address',
            'buyers.name as buyer_name','buyers.email as buyer_email','buyers.phone as buyer_phone','buyers.address as buyer_address'
            )
        ->get();
        // dd($data);
         
       $city = City::all();
       $area = Area::all();
       $buyer = Buyer::all();
       $saler = Saler::all();
    //    $buyer = Buyer::all();
       $type = Property_type::all();
     
    //    dd($data);
       return view('admin-side.dealers.fetch_sale_property',compact('data','city','area','type','buyer','saler'));
    }
    public function store_sale_property(Request $request)
    {
        //  dd($request->all());

        $data = new Sale_Property();

        $data->buyer_id = $request->input('buyer_id');
        $data->saler_id = $request->input('category_id');
        $data->property_id= $request->input('subcategory_id');
        $data->price = $request->input('price');
        $offer = $data->offer_amount = $request->input('offer_amount');
        $paid =$data->paid_amount = $request->input('paid_amount');
        $dues_amount = ($offer-$paid);

        if($dues_amount == '0')
        {
            $data->role = "completed";
        }
        else{
            $data->role = "pending";
        }
        $data->dues_amount = $dues_amount;
        // dd($data);
        $data->save();
        if ($data) {
            
            return redirect('show-sale-property')->with('success', 'Success! Record Added Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Inserted');
            }
       
    }
  
    public function edit_sale_property($id){
        // dd($id);
        $data = Sale_Property::find($id);
    
    //   dd($data);
        $city = City::all();
        $area = Area::all();
        $type = Property_type::all();
        // dd($data);
        return view('admin-side.dealers.edit_sale_property', compact('data','city','area','type'));
       
    }
    public function update_sale_property(Request $request, $id)
    {
        // dd($request->all());
        $data = Sale_Property::find($id);
        
        $offer =  $request->input('offer_amount');
        $paid =  $request->input('paid_amount');
        $amount =  $request->input('new_amount');
        $received = $paid+$amount;
        // dd($received); 
        $dues = $offer-$received;
        // dd($dues);
        $data->paid_amount = $received;
        
        if($dues == '0'){
            $data->role ="completed";
        }
        else{
            $data->role ="pending";
        }
        $data->dues_amount = $dues;
        // dd($data);
        $data->update();
        if ($data) {
            
            return redirect('show-sale-property')->with('success', 'Success! Record Updated Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Updated');
            }
      
    }
    public function destroy_sale_property($id){
      
        $data = Sale_Property::find($id);
        $data->delete();
        if ($data) {
            
            return redirect('show-sale-property')->with('success', 'Success! Record Deleted Successfully');
        
            }
            else {
            
                return redirect()->back()->with('failed', 'Failed! Record  not Deleted');
            }
        

    }
    

    public function getStates(Request $request)
    {
        $states = \DB::table('properties')
            ->where('saler_id', $request->country_id)
            ->get();
        
        if (count($states) > 0) {
            return response()->json($states);
        }
    }

    /**
     * return cities list
     *
     * @return json
     */
    public function getCities(Request $request)
    {
        $cities = \DB::table('properties')
            ->where('state_id', $request->state_id)
            ->get();
        
        if (count($cities) > 0) {
            return response()->json($cities);
        }
    }
}
