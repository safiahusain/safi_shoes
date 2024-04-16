<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Manager extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'managers';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'branch_id',
        'date',
        'open_balance',
        'dues_balance',
        'status'
    ];
}

