<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Stock extends Model
{
    use HasFactory, Notifiable;
    protected $table = "stocks";
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
        'quantity',
        'total_cost',
        'date',
        'status',
    ];
}
