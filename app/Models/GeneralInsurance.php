<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInsurance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function partyContact()
    {
        return $this->hasMany(PartyContact::class, 'mst_party_id', 'mst_party_id');
    }

    public function partyCity()
    {
        return $this->hasMany(PartyCity::class, 'mst_party_id', 'mst_party_id');
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function insurance()
    {
        return $this->belongsTo(MstInsurance::class, 'insurance_company');
    }

    public function insuranceType()
    {
        return $this->belongsTo(MstInsuranceType::class, 'insurance_type');
    }

    public static function InsuranceBy()
    {
        return [
            '0' => 'Starcarz',
            '1' => 'Third Party'
        ];
    }

    public function scopePolicyNumber($query, $request)
    {
        $query->when($request->filled('policy_number'), function ($subquery) use ($request) {
            return $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
        });
    }

    public static function getInsuredByName($key)
    {
        $insuredByArray = self::InsuranceBy();
        return $insuredByArray[$key] ?? '';
    }
}
