<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefurbnishmentOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id')->select('id', 'reg_number', 'total');
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id', 'id')->select('id', 'party_name');
    }

    public function scopeModeSearch($query, $request)
    {
        $query->when($request->filled('status'), function ($subquery) use ($request) {
            return $subquery->where('status', 'like', '%' . $request->status . '%');
        });
    }

    public function scopePartySearch($query, $request)
    {
        $query->when($request->filled('mst_party_id'), function ($subquery) use ($request) {
            return $subquery->where('mst_party_id', 'like', '%' . $request->party_id . '%');
        });
    }

    public function refurbished()
    {
        return $this->hasMany(Refurbishment::class);
    }
}
