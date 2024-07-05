<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorInsuranceClaim extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function company()
    {
        return $this->belongsTo(MstInsurance::class, 'insurance_company');
    }

    public function carInsurance()
    {
        return $this->belongsTo(CarInsurance::class, 'policy_number_id');
    }

    public static function InsuranceBy()
    {
        return [
            'Starcarz', 'Third Party'
        ];
    }

    public static function vehicleType()
    {
        return [1 => 'Bike', 2 => 'Car'];
    }

    public static function getStatus()
    {
        return [1 => 'Pending', 2 => 'Closed'];
    }

    public static function odType()
    {
        return [1 => 'OD only', 2 => 'Comprehensive', 3 => 'Third party'];
    }

    public function scopePolicyNumber($query, $request)
    {
        $query->when($request->filled('policy_number'), function ($subquery) use ($request) {
            return $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
        });
    }


    public function scopeCarNumber($query, $request)
    {
        $query->when($request->filled('vehicle_number'), function ($subquery) use ($request) {
            return $subquery->where('vehicle_number_input', 'like', '%' . $request->vehicle_number . '%');
        });
    }
}
