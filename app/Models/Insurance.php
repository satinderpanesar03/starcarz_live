<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getInsuranceTypes($type)
    {
        if (!$type) {
            return [
                '1' => 'Health Insurance',
                '2' => 'Term Insurance',
            ];
        } else {
            return [
                '3' => 'General Insurance'
            ];
        }
    }

    public static function getInsuredBy()
    {
        return [
            '1' => 'APEX',
            '2' => 'Others (3rd Party)'
        ];
    }

    public function getInsuranceTypesName($id)
    {
        $insuranceArray = ($id != 3) ? self::getInsuranceTypes(false) : self::getInsuranceTypes(true);
        return $insuranceArray[$id] ?? '';
    }

    public function getInsuredByName($id)
    {
        $insuredByArray = self::getInsuredBy();
        return $insuredByArray[$id] ?? '';
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'executive_id');
    }

    public function broker()
    {
        return $this->belongsTo(MstBroker::class, 'broker_id');
    }

    public function company()
    {
        return $this->belongsTo(MstInsurance::class, 'company_id');
    }

    public function insuranceTypes()
    {
        return $this->belongsTo(MstInsuranceType::class, 'insurance_type_id');
    }
}
