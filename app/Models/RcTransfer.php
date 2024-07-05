<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcTransfer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'vehicle_id', 'id')->select('id', 'reg_number');
    }

    public function agent()
    {
        return $this->belongsTo(MstRtoAgent::class, 'agent_id', 'id')->select('id', 'agent');
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id', 'id')
            ->select('id', 'party_name')
            ->with('partyContact:id,mst_party_id,number,type');
    }

    public static function getStatusType()
    {
        return [
            '1' => 'Pending',
            '2' => 'Transferred',
        ];
    }
}
