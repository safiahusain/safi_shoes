<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleman extends Model
{
    use HasFactory;
    protected $table = 'saleman';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'branch_name',
        'open_balance',
        'status',
    ];
}
