<?php

namespace App\Helpers;

use App\Models\SaleInvoice;
use App\Models\BranchStock;
use App\Models\AssignStock;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function randomString($length,$numbers,$chars,$target='both')
    {
        $characters     =   $numbers && !$chars
                            ?   '0123456789'
                            :   (!$numbers && $chars
                                ?   ($target != 'both'
                                    ?   ($target == 'upper'
                                        ?   'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                                        :   'abcdefghijklmnopqrstuvwxyz')
                                    :   'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
                                :   ($target != 'both'
                                    ?   ($target == 'upper'
                                        ?   '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                                        :   '0123456789abcdefghijklmnopqrstuvwxyz')
                                    :   '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'));
        $char_length    =   strlen($characters);
        $string         =   '';

        for ($i = 0; $i < $length; $i++)
        {
            $string   .=  $characters[rand(0, $char_length - 1)];
        }

        return $string;
    }
    
    public static function createUId($target)
    {
        do
        {
            $uid    =   $target."-".static::randomString(8,true,true,'upper');
            $found  =   $target ==  'SL'    
                        ?   SaleInvoice::where(['sale_id'=> $uid, 'target'=> 'sale'])->first()
                        :   ($target ==  'BS'
                            ?   BranchStock::where(['stock_id'=> $uid, 'target'=> 'stock'])->first()
                            :   AssignStock::where(['stock_id'=> $uid, 'target'=> 'stock'])->first());
        }
        while ($found);

        return $uid;
    }
}
?>
