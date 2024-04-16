<?php

namespace App\Models;

use App\Models\User;
use App\Models\AssignStock;
use App\Models\BranchStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warehouse extends Model
{
    use HasFactory;
    
    public function assignStock()
    {
        return $this->hasMany(AssignStock::class);
    }
    
    public function branchStock()
    {
        return $this->hasMany(BranchStock::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
