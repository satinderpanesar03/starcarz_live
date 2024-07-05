<?php

namespace App\Models;

use App\View\Components\Party;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyFirm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function party(){
        return $this->belongsTo(MstParty::class);
    }
}
