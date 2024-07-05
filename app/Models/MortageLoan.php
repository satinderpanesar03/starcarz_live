<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortageLoan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getLoanType()
    {
        return [
            '4' => 'Home Loan',
            '5' => 'Loan Against Property',
            '6' => 'OverDraft'
        ];
    }

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

    public static function getStatusName($status)
    {
        $statuses = self::getStatus();
        return $statuses[$status] ?? '';
    }

    public static function getLoanTypeName($status)
    {
        $statuses = self::getLoanType();
        return $statuses[$status] ?? '';
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function insuranceType()
    {
        return $this->belongsTo(MstInsuranceType::class, 'insurance_type');
    }

    public function disbursed()
    {
        return $this->hasMany(MortageDisbursedDetails::class);
    }
}
