<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use App\Models\warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStock extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function warehouse()
    {
        return $this->belongsTo(User::class,'branch_id','id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
