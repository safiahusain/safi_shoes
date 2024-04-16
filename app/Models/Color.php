<?php

namespace App\Models;

use App\Models\Product;
use App\Models\AssignStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Color extends Model
{
    use HasFactory, Notifiable;
    protected $table = "colors";
    protected $fillable = [
        'name',
        'date',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'color_id');
    }
    
    public function assignStock()
    {
        return $this->hasMany(AssignStock::class);
    }
}
