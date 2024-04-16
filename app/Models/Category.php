<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;
    protected $table = "categories";
    protected $fillable = [
        'name',
        'category_id',
        'date',
        'status',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
    
    public function size()
    {
        return $this->hasMany(Size::class);
    }
}
