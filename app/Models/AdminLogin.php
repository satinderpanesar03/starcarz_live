<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class AdminLogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['admin'];
    protected $appends = ['multi_role_name'];
    protected $fillable = [
        'name',
        'role_id',
        'email',
        'profile_image',
        'contact_number',
        'address',
        'gender',
        'password',
        'reset_link',
        'roles',
        'all_access'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getGenderOption()
    {
        return [
            '1' => 'Male',
            '2' => 'Female',
            '3' => 'Other'
        ];
    }
    CONST ADMIN = 1;

    public function role(){
        return $this->belongsTo(Role::class);
    }


    public static function getGenderName($id)
    {
        $gender = self::getGenderOption();
        return $gender[$id] ?? '';
    }

    public function getMultiRoleNameAttribute(){
        $roleName = [];
        $roles = DB::table('roles')->select('id', 'title')->get();

        foreach($roles as $role){
            if(in_array($role->id, explode(',', $this->roles))){
                array_push($roleName, $role->title);
            }
        }

        return $roleName;
    }
}
