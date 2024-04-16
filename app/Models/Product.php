<?php

namespace App\Models;

use App\Models\Category;
use App\Models\AssignStock;
use App\Models\BranchStock;
use App\Models\SaleInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable;
    protected $table = "products";
    protected $fillable = [
        'item_code',
        'name',
        'image',
        'category_id',
        'color_id',
        'size_id',
        'company_id',
        'brand_id',
        'purchase_price',
        'sale_price',
        'new_stock',
        'opening_balance',
        'quantity',
        'total_cost',
        'stock',
        'date',
        'status',
    ];

    // public function company()
    // {
    //     return $this->hasMany(company::class);
    // }

    // public function color()
    // {
    //     return $this->hasMany(color::class);
    // }

    // public function size()
    // {
    //     return $this->hasMany(size::class);
    // }


    // public function brand()
    // {
    //     return $this->hasMany(brand::class);
    // }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function assignStock()
    {
        return $this->hasMany(AssignStock::class);
    }
    
    public function branchStock()
    {
        return $this->hasMany(BranchStock::class);
    }
    
    public function saleInvoice()
    {
        return $this->hasMany(SaleInvoice::class);
    }
    
    public function available_stock()
    {
        return $this->assignStock()->where('target','stock')->sum('assign_stock');
    }
}
