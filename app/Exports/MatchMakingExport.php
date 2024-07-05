<?php

namespace App\Exports;

use App\Models\CustomerDemandVehcile;
use App\Models\MstBrandType;
use App\Models\MstModel;
use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MatchMakingExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $brandFilter;
    protected $modelFilter;

    public function __construct($brandFilter = null, $modelFilter = null)
    {
        $this->brandFilter = $brandFilter;
        $this->modelFilter = $modelFilter;
    }

    public function headings(): array
    {
        return [
            '#',
            'Brand',
            'Model',
            'In Stock',
            'Park & Sale',
            'Customer Demand',
            'Total Car',
        ];
    }
    public function collection()
    {
        $brands = MstBrandType::pluck('type', 'id');
        $modelsQuery = MstModel::with('brand');

        // Apply brand filter
        if ($this->brandFilter) {
            $modelsQuery->whereHas('brand', function ($query) {
                $query->where('id', $this->brandFilter);
            });
        }

        // Apply model filter
        if ($this->modelFilter) {
            $modelsQuery->where('id', $this->modelFilter);
        }

        $models = $modelsQuery->get();


        $data = [];

        foreach ($brands as $brandId => $brand) {
            foreach ($models as $model) {
                // Ensure brand ID matches the brand of the model
                if ($model->brand->id !== $brandId) {
                    continue;
                }

                $inStockCount = Purchase::where('mst_brand_type_id', $brandId)
                    ->where('mst_model_id', $model->id)
                    ->where('status', 6)
                    ->count();

                $parkAndSaleCount = Purchase::where('mst_brand_type_id', $brandId)
                    ->where('mst_model_id', $model->id)
                    ->where('status', 7)
                    ->count();

                $customerDemand = CustomerDemandVehcile::whereRaw("FIND_IN_SET('$model->model', vehicle)")->count();

                $totalCars = $inStockCount + $parkAndSaleCount + $customerDemand;

                $data[] = [
                    'model_id' => $model->id,
                    'brand' => $brand,
                    'model' => $model->model,
                    'in_stock_count' => $inStockCount > 0 ? $inStockCount : "0",
                    'park_and_sale_count' => $parkAndSaleCount > 0 ? $parkAndSaleCount : "0",
                    'customer_demand' => $customerDemand > 0 ? $customerDemand : "0",
                    // 'total_cars' => $totalCars > 0 ? $totalCars : "0",
                ];
            }
        }

        return collect($data);
    }
}
