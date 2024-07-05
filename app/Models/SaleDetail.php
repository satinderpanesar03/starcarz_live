<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getStatus($selectedStatusId = null)
    {
        $status = [
            '1' => 'Pending',
            // '2' => 'Quoted',
            '3' => 'Follow Up',
            '4' => 'Closed',
            '5' => 'Sold',
            '6' => 'Customer Demand'
        ];

        if ($selectedStatusId !== null) {
            // Filter out statuses that come before the selected status ID
            $status = array_slice($status, $selectedStatusId, null, true);

            // Reset keys to maintain original index values
            $status = array_combine(array_keys($status), array_values($status));
        }

        return $status;
    }

    public static function getStatusName($id)
    {
        $status = self::getStatus();
        return $status[$id] ?? '';
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'vehicle_id', 'id')->select('id', 'reg_number');
    }

    public function sugVehicle()
    {
        return $this->belongsTo(Purchase::class, 'suggestion_vehicle_id', 'id')->select('id', 'reg_number');
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id', 'id')->select('id', 'party_name');
    }

    public function modelName()
    {
        return $this->belongsTo(MstModel::class, 'vehicle_id');
    }
}
