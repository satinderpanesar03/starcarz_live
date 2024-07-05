<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refurbishment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function getHeadOption()
    {
        return [
            '1' => 'Service & Oil Change',
            '2' => 'Compound & Dry Clean',
            '3' => 'Paint & Denting',
            '4' => 'Electrical & Electronics',
            '5' => 'Engine Compartment',
            '6' => 'Accessories',
            '7' => 'Others'
        ];
    }

    public static function getPaymentOption()
    {
        return [
            '1' => 'Cash',
            '2' => 'Credit'
        ];
    }

    public static function refStatus(){
        return [
            '6' => 'Purchased',
            '7' => 'Park and sale'
        ];
    }

    public static function getHeadName($id)
    {
        $headArray = self::getHeadOption();
        return $headArray[$id] ?? '';
    }

    public static function getPaymentName($id)
    {
        $paymentArray = self::getPaymentOption();
        return $paymentArray[$id] ?? '';
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function model()
    {
        return $this->belongsTo(MstModel::class, 'mst_model_id');
    }

    public function suppliers()
    {
        return $this->belongsTo(MstSupplier::class, 'mst_supplier_id');
    }

    public function regNumber()
    {
        return $this->belongsTo(Purchase::class, 'registration_number');
    }
}
