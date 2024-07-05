<?php

namespace App\Exports;

use App\Models\SaleOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GrossMarginExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start_date;
    protected $end_date;
    protected $partyFilter;
    protected $carFilter;

    public function __construct($start_date = null, $end_date = null, $partyFilter = null, $carFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->partyFilter = $partyFilter;
        $this->carFilter = $carFilter;
    }
    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Vehicle Number',
            'Purchase Price',
            'Sale Price',
            'Gross Margin',
            'Created At'
        ];
    }
    public function collection()
    {
        $query = SaleOrder::with('party', 'purchase')
            ->join('purchases', 'sale_orders.purchase_id', '=', 'purchases.id')
            ->join('purchase_orders', 'purchases.id', '=', 'purchase_orders.purchase_id')
            ->select('sale_orders.*', 'purchase_orders.price_p1 as purchase_price');

        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('sale_orders.created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('sale_orders.mst_party_id', $this->partyFilter);
        }

        if (!empty($this->carFilter)) {
            $car_number = $this->carFilter;
            $query = $query->whereHas('purchase', function ($subquery) use ($car_number) {
                $subquery->where('reg_number', 'like', '%' . $car_number . '%');
            });
        }

        $sales = $query->get();

        return $sales->map(function ($saleDetail) {
            $gross_margin = $saleDetail->price_p1 - $saleDetail->purchase_price;

            if ($saleDetail->price_p1 != 0) {
                $gross_margin_percentage = ($gross_margin / $saleDetail->price_p1) * 100;
            } else {
                $gross_margin_percentage = 0;
            }

            $gross_margin_percentage_formatted = number_format($gross_margin_percentage, 2) . '%';

            return [
                $saleDetail->id,
                $saleDetail->party ? $saleDetail->party->party_name : "N/A",
                $saleDetail->purchase ? $saleDetail->purchase->reg_number : "N/A",
                $saleDetail->purchase_price,
                $saleDetail->price_p1,
                $gross_margin_percentage_formatted,
                $saleDetail->created_at,
            ];
        });
    }
}
