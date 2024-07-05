<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMINISTATOR = 1;

    protected $guarded = ['id'];

    public function rolePermission(){
        return $this->hasMany(RoleAndPermission::class, 'role_id');
    }

    public function users()
    {
        return $this->hasMany(AdminLogin::class, 'role_id');
    }

    // public function scopeNotSuperAdmin($query){
    //     $query->where('title', '!=', 1);
    // }
}
