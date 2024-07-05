<?php

namespace App\Exports;

use App\Models\CarLoan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CarLoanExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start_date;
    protected $end_date;
    protected $dealerFilter;
    protected $partyFilter;
    protected $modelFilter;
    protected $statusFilter;

    public function __construct($start_date = null, $end_date = null, $dealerFilter = null, $partyFilter = null, $modelFilter = null, $statusFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->dealerFilter = $dealerFilter;
        $this->partyFilter = $partyFilter;
        $this->modelFilter = $modelFilter;
        $this->statusFilter = $statusFilter;
    }
    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Dealer Name',
            'Car Model',
            'Insurance Company',
            'Manufacturing Year',
            'Insurance Done Date',
            'Insurance From Date',
            'Insurance To Date',
            'Created At'
        ];
    }
    public function collection()
    {
        $query = CarLoan::with('party', 'dealer', 'carModel', 'insurance');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->dealerFilter)) {
            $query = $query->where('mst_dealer_id', $this->dealerFilter);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('mst_party_id', $this->partyFilter);
        }

        if (!empty($this->modelFilter)) {
            $query = $query->where('mst_model_id', $this->modelFilter);
        }

        if (!empty($this->statusFilter)) {
            $query = $query->where('status', $this->statusFilter);
        }

        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->party ? $carInsurance->party->party_name : "N/A",
                    $carInsurance->dealer ? $carInsurance->dealer->name : "N/A",
                    $carInsurance->carModel ? $carInsurance->carModel->model : "N/A",
                    $carInsurance->insurance ? $carInsurance->insurance->name : "N/A",
                    $carInsurance->manufacturing_year,
                    $carInsurance->insurance_done_date,
                    $carInsurance->insurance_from_date,
                    $carInsurance->insurance_to_date,
                    $carInsurance->created_at,
                ];
            });
    }
}
