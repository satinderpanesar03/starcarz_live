<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstInsuranceType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getInsurance()
    {
        return [
            // '1' => 'Health Insurance',
            // '2' => 'Term Insurance',
            '3' => 'General Insurance',
            '4' => 'Home Loan',
            '5' => 'Loan Against Property',
            '6' => 'OverDraft'
        ];
    }

    public static function getInsuranceName($id)
    {
        $insurance = self::getInsurance();
        return $insurance[$id] ?? '';
    }
}
