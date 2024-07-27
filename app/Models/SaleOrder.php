<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id')->select('id', 'reg_number', 'registration_year','mst_executive_id');
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id', 'id')
            ->select('id', 'party_name')
            ->with('partyContact:id,mst_party_id,number,type');
    }

    public function executive(){
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id', 'id')->select('id','name');
    }

    public function carModel()
    {
        return $this->belongsTo(MstModel::class, 'model_id');
    }

    public function rc_transfer(){
        return $this->hasOne(RcTransfer::class,'sale_order_id');
    }


}
