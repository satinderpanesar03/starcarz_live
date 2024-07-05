<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function saleEnquiry()
    {
        return $this->belongsTo(SaleDetail::class, 'sale_enquiry_id');
    }

    public function purchase()
    {
        return $this->belongsTo(SaleDetail::class, 'sale_enquiry_id');
    }
}
