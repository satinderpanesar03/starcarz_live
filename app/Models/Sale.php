<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getFuelType()
    {
        return [
            '1' => 'Petrol',
            '2' => 'Diesel',
            '3' => 'Duo'
        ];
    }

    public static function getEnquiryType()
    {
        return [
            '1' => 'Walk In',
            '2' => 'Internet',
            '3' => 'SMS',
            '4' => 'Dealer/Freelancer',
            '5' => 'Existing Customer',
            '6' => 'Telecaller',
            '7' => 'Close'
        ];
    }

    public static function getFinanceType()
    {
        return [
            '1' => 'Yes',
            '2' => 'No'
        ];
    }

    public static function getBudget()
    {
        return [
            '1' => '50000 to 1 Lakh',
            '2' => '1 Lakh to 2 Lakh',
            '3' => '2 Lakh to 3 Lakh',
            '4' => '3 Lakh to 4 Lakh',
            '5' => '4 Lakh to 5 Lakh',
            '6' => '5 Lakh to 6 Lakh',
            '7' => '6 Lakh to 7 Lakh',
            '8' => '7 Lakh to 8 Lakh',
            '9' => '8 Lakh to 10 Lakhs',
            '10' => '10 Lakhs to 12 Lakhs',
            '11' => '12 Lakhs to 15 Lakhs',
            '12' => '15 Lakhs to 20 Lakhs',
            '13' => 'Above 20 Lakhs'
        ];
    }

    public static function getFuelTypeOption($id)
    {
        $fuelTypeArray = self::getFuelType();
        return $fuelTypeArray[$id] ?? '';
    }

    public static function getEnquiryTypeOption($id)
    {
        $enquiryArray = self::getEnquiryType();
        return $enquiryArray[$id] ?? '';
    }

    public static function getFinanceTypeOption($id)
    {
        $financeArray = self::getFinanceType();
        return $financeArray[$id] ?? '';
    }

    public static function getBudgetOption($id)
    {
        $budgetArray = self::getBudget();
        return $budgetArray[$id] ?? '';
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function carModel()
    {
        return $this->belongsTo(MstModel::class, 'mst_model_id');
    }
}
