<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInsurance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party(){
        return $this->belongsTo(MstParty::class);
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function insurance()
    {
        return $this->belongsTo(MstInsurance::class, 'insurance_company');
    }

    public function modelName()
    {
        return $this->belongsTo(MstModel::class, 'color');
    }

    public static function InsuranceBy()
    {
        return [
            '0' => 'Starcarz',
            '1' => 'Third Party'
        ];
    }

    public static function getInsuredByName($key)
    {
        $insuredByArray = self::InsuranceBy();
        return $insuredByArray[$key] ?? '';
    }

    public static function vehicleType(){
        return [1=>'Two wheeler',2=>'Private car', 3=>'Commercial'];
    }

    public static function getVehicleType($key)
    {
        $insuredByArray = self::vehicleType();
        return $insuredByArray[$key] ?? '';
    }

    public static function odType(){
        return [1=>'OD only', 2=>'Comprehensive',3=>'Third party'];
    }

    public static function getOdType($key)
    {
        $insuredByArray = self::odType();
        return $insuredByArray[$key] ?? '';
    }

    public function scopePolicyNumber($query, $request){
        $query->when($request->filled('policy_number'), function ($subquery) use ($request) {
            return $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
        });
    }


    public function scopeCarNumber($query, $request){
        $query->when($request->filled('vehicle_number'), function ($subquery) use ($request) {
            return $subquery->where('vehicle_number_input', 'like', '%' . $request->vehicle_number . '%');
        });
    }

}
