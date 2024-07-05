<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDemandVehcile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party(){
        return $this->belongsTo(MstParty::class)->select('id','party_name');
    }

}
