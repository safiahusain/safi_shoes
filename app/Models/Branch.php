<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'branches';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'manager_name',
        'date',
        'status'
    ];
}
