<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = ['filename', 'filepath', 'purchase_id'];

    public function images()
    {
        return $this->belongsToMany(Purchase::class)->withTimestamps();
    }
}
