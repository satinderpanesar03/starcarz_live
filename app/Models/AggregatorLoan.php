<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AggregatorLoan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function insurance()
    {
        return $this->belongsTo(MstInsurance::class, 'insurance_company');
    }

    public function executiveName()
    {
        return $this->belongsTo(MstExecutive::class, 'executive');
    }
}
