<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Brand extends Model
{
    use HasFactory, Notifiable;
    protected $table = "brands";
    protected $fillable = [
        'name',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
