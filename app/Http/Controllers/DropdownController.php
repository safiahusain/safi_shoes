<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function getStates(Request $request)
    {
        $states = \DB::table('areas')
            ->where('city_id', $request->country_id)
            ->get();
        
        if (count($states) > 0) {
            return response()->json($states);
        }
    }

    public function getCities(Request $request)
    {
        // $cities = \DB::table('cities')
        //     ->where('state_id', $request->state_id)
        //     ->get();
        
        // if (count($cities) > 0) {
        //     return response()->json($cities);
        // }
    }

       //on-change-id
public function GetSubCatAgainstMainCatEdit($id){
    // dd($id);
    // echo json_encode(DB::table('areas')->where('city_id', $id)->get());
    // echo json_encode(DB::table('salers')->where('id', $id)->get());
    echo json_encode(DB::table('properties')->where('saler_id', $id)->get());
}


}
