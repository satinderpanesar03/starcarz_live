<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstRtoAgent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeAgentSearch($query, $request){
        $query->when($request->filled('agent_name'), function ($subquery) use ($request) {
            return $subquery->where('agent', 'like', '%' . $request->agent_name . '%');
        });
    }

    public function scopeEmailSearch($query, $request){
        $query->when($request->filled('email'), function ($subquery) use ($request) {
            return $subquery->where('email', 'like', '%' . $request->email . '%');
        });
    }
    public function scopePhoneSearch($query, $request){
        $query->when($request->filled('phone_number'), function ($subquery) use ($request) {
            return $subquery->where('phone_number', 'like', '%' . $request->phone_number . '%');
        });
    }
    public function scopeLocationSearch($query, $request){
        $query->when($request->filled('location'), function ($subquery) use ($request) {
            return $subquery->where('location', 'like', '%' . $request->location . '%');
        });
    }
}
