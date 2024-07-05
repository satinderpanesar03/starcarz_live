<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermInsuranceClaim extends Model
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

    public function termInsurance()
    {
        return $this->belongsTo(GeneralInsurance::class, 'policy_number_id');
    }

    public static function InsuranceBy()
    {
        return [
            'Starcarz', 'Third Party'
        ];
    }

    public static function getStatus()
    {
        return [1 => 'Pending', 2 => 'Closed'];
    }

    public function scopePolicyNumber($query, $request)
    {
        if ($request->filled('policy_number')) {
            $query->whereHas('termInsurance', function ($subquery) use ($request) {
                $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
            });
        }
    }
}
