<?php

namespace App\Exports;

use App\Models\RefurbnishmentOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RefurbishmentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $start_date;
    protected $end_date;
    protected $partyFilter;
    protected $carFilter;
    protected $statusFilter;

    public function __construct($start_date = null, $end_date = null, $partyFilter = null, $carFilter = null, $statusFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->partyFilter = $partyFilter;
        $this->carFilter = $carFilter;
        $this->statusFilter = $statusFilter;
    }
    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Vehicle Number',
            'Service & Oil Change',
            'Amount',
            'Compound & Dry Clean',
            'Amount',
            'Paint & Denting',
            'Amount',
            'Electronics',
            'Amount',
            'Engine',
            'Amount',
            'Accessories',
            'Amount',
            'Others',
            'Amount',
            'Actual',
            'Evaluation Estimate',
            'Deviation',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = RefurbnishmentOrder::with('party', 'purchase');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('mst_party_id', $this->partyFilter);
        }

        if (!empty($this->carFilter)) {
            $car_number = $this->carFilter;
            $query = $query->whereHas('purchase', function ($subquery) use ($car_number) {
                $subquery->where('reg_number', 'like', '%' . $car_number . '%');
            });
        }

        if (!empty($this->statusFilter)) {
            $query = $query->where('status', $this->statusFilter);
        }
        return $query->get()
            ->map(function ($refurbishment) {
                $deviation = $refurbishment->total_amount - ($refurbishment->purchase ? $refurbishment->purchase->total : 0);
                return [
                    $refurbishment->id,
                    $refurbishment->party ? $refurbishment->party->party_name : "N/A",
                    $refurbishment->purchase ? $refurbishment->purchase->reg_number : "N/A",
                    $refurbishment->service_and_oil_change,
                    $refurbishment->service_and_oil_change_amount,
                    $refurbishment->compound_and_dry_clean,
                    $refurbishment->compound_and_dry_clean_amount,
                    $refurbishment->paint_and_denting,
                    $refurbishment->paint_and_denting_amount,
                    $refurbishment->electrical_and_electronics,
                    $refurbishment->electrical_and_electronics_amount,
                    $refurbishment->engine_compartment,
                    $refurbishment->engine_compartment_amount,
                    $refurbishment->accessories,
                    $refurbishment->accessories_amount,
                    $refurbishment->others_desc,
                    $refurbishment->others_amount,
                    $refurbishment->total_amount,
                    $refurbishment->purchase ? $refurbishment->purchase->total : "0",
                    $deviation, 
                    $refurbishment->created_at,
                ];
            });
    }
}
