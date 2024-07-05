<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstBrandType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function models(){
        return $this->hasMany(MstModel::class);
    }
}
