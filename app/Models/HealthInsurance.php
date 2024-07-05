<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInsurance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function status(){
        return [
            1 => 'Pending',
            2 => 'Closed'
        ];
    }

    public static function getStatusName($key)
    {
        $insuredByArray = self::status();
        return $insuredByArray[$key] ?? '';
    }

    public function party(){
        return $this->belongsTo(MstParty::class,'party_id','id');
    }

    public function partyContact()
    {
        return $this->hasMany(PartyContact::class, 'mst_party_id', 'party_id');
    }

    public function partyCity()
    {
        return $this->hasMany(PartyCity::class, 'mst_party_id', 'party_id');
    }

    public function scopePolicyNumber($query, $request){
        $query->when($request->filled('policy_number'), function ($subquery) use ($request) {
            return $subquery->where('policy_number', 'like', '%' . $request->policy_number . '%');
        });
    }

    public function memberName() {
        return $this->hasMany(FamilyMember::class);
    }
}
