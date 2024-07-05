<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstParty extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopePartySearch($query, $request){
        $query->when($request->filled('party_name'), function ($subquery) use ($request) {
            return $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
        });
    }

    public function scopeEmailSearch($query, $request){
        $query->when($request->filled('email'), function ($subquery) use ($request) {
            return $subquery->where('email', 'like', '%' . $request->email . '%');
        });
    }

    public function scopeCitySearch($query, $request){
        $query->when($request->filled('city'), function ($subquery) use ($request) {
            return $subquery->where('residence_city', 'like', '%' . $request->city . '%');
        });
    }

    public function scopePhoneSearch($query, $request){
        $query->when($request->filled('phone_number'), function ($subquery) use ($request) {
            $subquery->whereHas('partyContact', function ($contactQuery) use ($request) {
                $contactQuery->where('number', 'like', '%' . $request->phone_number . '%');
            });
        });
    }

    public function partyFirm()
    {
        return $this->hasMany(PartyFirm::class);
    }

    public function partyContact() {
        return $this->hasMany(PartyContact::class);
    }

    public function partyCity() {
        return $this->hasMany(PartyCity::class);
    }
  
}
