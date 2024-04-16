<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use App\Models\Role;
use App\Models\warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }
}
