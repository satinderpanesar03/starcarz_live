<?php

namespace App\Exports;

use App\Models\SaleDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SaleEnquiryExport implements FromCollection, WithHeadings
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
            'Suggestion Vehicle Number',
            'Remarks',
            'Followup Date',
            'Amount',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = SaleDetail::with('party', 'purchase', 'sugVehicle')->where('status', '!=', 4);

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
            ->map(function ($saleDetail) {
                return [
                    $saleDetail->id,
                    $saleDetail->party ? $saleDetail->party->party_name : "N/A",
                    $saleDetail->purchase ? $saleDetail->purchase->reg_number : "N/A",
                    $saleDetail->sugVehicle ? $saleDetail->sugVehicle->reg_number : "N/A",
                    $saleDetail->remarks,
                    $saleDetail->followup_date,
                    $saleDetail->amount,
                    $saleDetail->created_at,
                ];
            });
    }
}
