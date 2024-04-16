<?php

namespace App\Models;

use App\Models\AssignStock;
use App\Models\warehouse;
use App\Models\Role;
use App\Models\BranchStock;
use App\Models\RoleHasPermission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function assignStock()
    {
        return $this->hasMany(AssignStock::class);
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function warehouse()
    {
        return $this->hasMany(warehouse::class);
    }
    
    public function branchStock()
    {
        return $this->hasMany(BranchStock::class);
    }
    
    public function role_permission()
    {
        return $this->hasMany(RoleHasPermission::class);
    }
}
