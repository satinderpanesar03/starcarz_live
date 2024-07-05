<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstColor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch($query, $search){
        if ($search) {
            return $query->where('color', 'like', '%' . $search . '%');
        }
        return $query;
    }
}
