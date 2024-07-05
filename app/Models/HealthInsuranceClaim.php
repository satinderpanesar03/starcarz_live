<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInsuranceClaim extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function healthInsurance()
    {
        return $this->belongsTo(HealthInsurance::class, 'policy_number_id');
    }

    public static function getStatus()
    {
        return [1 => 'Pending', 2 => 'Closed'];
    }

    public function scopePolicyNumber($query, $request)
    {
        if ($request->filled('policy_number')) {
            $query->whereHas('healthInsurance', function ($subquery) use ($request) {
                $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
            });
        }
    }
}
