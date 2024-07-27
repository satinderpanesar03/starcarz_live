<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id')->select('id', 'reg_number','mst_executive_id','mst_model_id');
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id', 'id')
        ->select('id', 'party_name')
        ->with('partyContact:id,mst_party_id,number,type');
    }

    public function scopeModeSearch($query, $request)
    {
        $query->when($request->filled('status'), function ($subquery) use ($request) {
            return $subquery->where('status', 'like', '%' . $request->status . '%');
        });
    }
    public static function getStatusName($id)
    {
        $status = Purchase::getStatus();
        return $status[$id] ?? '';
    }
    public function scopePartySearch($query, $request)
    {
        $query->when($request->filled('mst_party_id'), function ($subquery) use ($request) {
            return $subquery->where('mst_party_id', 'like', '%' . $request->party_id . '%');
        });
    }
}
