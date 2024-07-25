<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'pending_image_status',
        'fuel_type_name',
        'status_name',
        'make',
        'model',
        'color_name',
        'images'
    ];


    public static function getFuelType()
    {
        return [
            '1' => 'Petrol',
            '2' => 'Diesel',
            '3' => 'Duo'
        ];
    }

    public static function getShapeType()
    {
        return [
            '1' => 'New',
            '2' => 'Old'
        ];
    }

    public static function getServiceBooklet()
    {
        return [
            '1' => 'Available',
            '2' => 'Not-Available'
        ];
    }

    public static function getEnquiryType()
    {
        return [
            '1' => 'Walk In',
            // '2' => 'Internet',
            // '3' => 'SMS',
            '4' => 'Dealer/Freelancer',
            '5' => 'Existing Customer',
            '6' => 'Telecaller',
            '7' => 'App'
        ];
    }

    public static function getBudget(){
        return [
            '1' => '0 to 5 Lakhs',
            '2' => '5 to 10 Lakhs',
            '3' => '10 to 15 Lakhs',
            '4' => '15 to 20 Lakhs',
            '5' => '20 to 25 Lakhs',
            '6' => '25 to 30 Lakhs',
            '7' => '30 to 35 Lakhs',
            '8' => '35 to 40 Lakhs',
            '9' => '40 to 45 Lakhs',
            '10' => '45 to 50 Lakhs',
        ];
    }

    public static function getWillingType()
    {
        return [
            '1' => 'Yes',
            '2' => 'No'
        ];
    }

    public static function getRcType()
    {
        return [
            '1' => 'Yes',
            '2' => 'No'
        ];
    }

    public static function getHypothecationType()
    {
        return [
            '1' => 'Yes',
            '2' => 'No'
        ];
    }

    public static function getStatus($selectedStatusId = null)
    {
        $statuses = [
            '1' => 'Pending',
            '2' => 'Evaluated',
            '3' => 'Quoted',
            '4' => 'Follow Up',
            '5' => 'Closed',
            '6' => 'Purchased',
            '7' => 'Park and sale'
        ];

        if ($selectedStatusId !== null && $selectedStatusId !== 7) {
            // Filter out statuses that come before the selected status ID
            $statuses = array_slice($statuses, $selectedStatusId, null, true);

            // Reset keys to maintain original index values
            $statuses = array_combine(array_keys($statuses), array_values($statuses));
        }

        if ($selectedStatusId === 7) {
            $statuses = array_combine(array_keys([5,6]), array_values(['Closed','Purchased']));
        }


        return $statuses;
    }

    public static function getFollowStatus()
    {
        return [
            '5' => 'Closed',
            '6' => 'Purchased',
            '7' => 'Park and sale'
        ];
    }

    public static function getFuelTypeOption($id)
    {
        $fuelTypeArray = self::getFuelType();
        return $fuelTypeArray[$id] ?? '';
    }

    public static function getStatusName($id)
    {
        $status = self::getStatus();
        return $status[$id] ?? '';
    }

    public static function getShapeTypeOption($id)
    {
        $shapeTypeArray = self::getShapeType();
        return $shapeTypeArray[$id] ?? '';
    }

    public static function getServiceBookletOption($id)
    {
        $bookletArray = self::getServiceBooklet();
        return $bookletArray[$id] ?? '';
    }

    public static function getEnquiryTypeOption($id)
    {
        $enquiryArray = self::getEnquiryType();
        return $enquiryArray[$id] ?? '';
    }

    public static function getWillingTypeOption($id)
    {
        $willingArray = self::getWillingType();
        return $willingArray[$id] ?? '';
    }

    public static function getRcTypeOption($id)
    {
        $rcArray = self::getRcType();
        return $rcArray[$id] ?? '';
    }

    public static function getHypothecationTypeOption($id)
    {
        $hypothecationArray = self::getHypothecationType();
        return $hypothecationArray[$id] ?? '';
    }

    public function party()
    {
        return $this->belongsTo(MstParty::class, 'mst_party_id');
    }

    public function executive()
    {
        return $this->belongsTo(MstExecutive::class, 'mst_executive_id');
    }

    public function carModel()
    {
        return $this->belongsTo(MstModel::class, 'mst_model_id');
    }

    public function color()
    {
        return $this->belongsTo(MstColor::class, 'mst_color_id');
    }

    public function brand()
    {
        return $this->belongsTo(MstBrandType::class, 'mst_brand_type_id');
    }

    public function executiveName()
    {
        return $this->belongsTo(AdminLogin::class, 'user_executive_id', 'id');
    }

    public function refurbishment()
    {
        return $this->hasOne(RefurbnishmentOrder::class, 'purchase_id', 'id');
    }

    public function purchaseOrder(){
        return $this->hasOne(PurchaseOrder::class);
    }

    public function getPendingImageStatusAttribute(){
        $purchases = PurchasedImage::where('purchase_id', $this->id)->first();

        if($purchases){
            foreach ($purchases->toArray() as $column => $value) {
                if (empty($value)) {
                    return 0;
                }
            }
            return 1;
        }
        return 0;
    }

    public function scopeSelected($query){
        return $query->select('id','reg_number','manufacturing_year','registration_year','kilometer','owners','status','image','fuel_type','mst_brand_type_id','mst_model_id','mst_color_id','selling_price','insurance_due_date');
    }

    public function getFuelTypeNameAttribute(){
        $fuelTypes = static::getFuelType();
        return $fuelTypes[$this->fuel_type] ?? null;
    }

    public function getStatusNameAttribute(){
        $statuses = static::getStatus();
        return $statuses[$this->status] ?? null;
    }

    public function getMakeAttribute(){
        return $this->brand->type ?? '';
    }

    public function getModelAttribute(){
        return $this->carModel->model ?? '';
    }

    public function getColorNameAttribute(){
        return $this->color->color ?? '';
    }


    public function purchased_images(){
        return $this->hasMany(PurchasedImage::class);
    }

    public function getImagesAttribute()
    {
        $imageArray = [];

        foreach ($this->purchased_images as $image) {
            $types = ['front', 'back', 'side', 'interior', 'tyre'];

            $hasImages = false;

            foreach ($types as $type) {
                if (!empty($image->$type)) {
                    $urls = explode(',', $image->$type);
                    foreach ($urls as $url) {
                        $imageArray[] = asset('storage/purchased/' . $url);
                    }
                    $hasImages = true;
                }
            }

            if ($hasImages) {
                break;
            }
        }

        if (empty($imageArray)) {
            return null;
        }

        return $imageArray;
    }

    public function insurance_company(){
        return $this->belongsTo(MstInsurance::class, 'icompany_id', 'id');
    }



}
