<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Size extends Model
{
    use HasFactory, Notifiable;
    protected $table = "sizes";
    protected $fillable = [
        'size_no',
        'date',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
