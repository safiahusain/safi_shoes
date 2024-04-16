<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use App\Models\Role;
use App\Models\warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
