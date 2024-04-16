<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Company extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'open_balance',
        'dues_balance',
        'date',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'company_id');
    }
}
