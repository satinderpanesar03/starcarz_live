<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarLoan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getStatus()
    {
        return [
            '1' => 'Pending',
            '2' => 'Approved',
            '3' => 'Rejected',
            '4' => 'Disbursed'
        ];
    }

    public static function getTenure()
    {
        return [
            '1' => '1 Year',
            '2' => '2 Year',
            '3' => '3 Year',
            '4' => '4 Year',
            '5' => '5 Year',
            '6' => '6 Year',
            '7' => '7 Year',
            '8' => '8 Year',
            '9' => '9 Year',
            '10' => '10 Year',
        ];
    }

    public static function getDisburseStatus()
    {
        return [
            '1' => 'Active',
            '2' => 'In-Active',
        ];
    }

    public static function getInsuredBy()
    {
        return [
            '1' => 'APEX',
            '2' => 'Others (3rd Party)'
        ];
    }

    public static function getLoanType()
    {
        return [
            '1' => 'Purchase',
            '2' => 'Refinance'
        ];
    }

    public static function getCarType()
    {
        return [
            '1' => 'Used',
            '2' => 'New'
        ];
    }

    public static function getInsuredByName($insuredBy)
    {
        $insuredByArray = self::getInsuredBy();
        return $insuredByArray[$insuredBy] ?? '';
    }

    public static function getDisburseStatusName($status)
    {
        $statuses = self::getDisburseStatus();
        return $statuses[$status] ?? '';
    }

    public static function getStatusName($status)
    {
        $statuses = self::getStatus();
        return $statuses[$status] ?? '';
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function executive()
    {
        return MstExecutive::find($this->executive);
    }

    public function dealer()
    {
        return $this->belongsTo(MstDealer::class, 'mst_dealer_id');
    }

    public function carModel()
    {
        return $this->belongsTo(MstModel::class, 'mst_model_id');
    }

    public function insurance()
    {
        return $this->belongsTo(MstInsurance::class, 'insurance_company');
    }

    public function bank()
    {
        return $this->belongsTo(MstBank::class, 'bank_id');
    }

    public function rc_transfer(){
        return $this->hasOne(RcTransfer::class,'car_loan_id');
    }

}
