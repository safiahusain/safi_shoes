<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use App\Models\warehouse;
use App\Models\SalesBalance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sales_balance()
    {
        return $this->belongsTo(SalesBalance::class);
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    
    public function auth_user()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
}
