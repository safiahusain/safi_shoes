<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use App\Models\warehouse;
use App\Models\RoleHasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
    
    public function role_permission()
    {
        return $this->hasMany(RoleHasPermission::class);
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
}
