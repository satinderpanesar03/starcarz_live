<?php

namespace App\Exports;

use App\Models\CarInsurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CarInsuranceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $start_date;
    protected $end_date;
    protected $partyFilter;
    protected $ploicyFilter;
    protected $statusFilter;

    public function __construct($start_date = null, $end_date = null, $partyFilter = null, $ploicyFilter = null, $statusFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->partyFilter = $partyFilter;
        $this->ploicyFilter = $ploicyFilter;
        $this->statusFilter = $statusFilter;
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Executive Name',
            'Insurance Company',
            'Vehicle Number',
            'Manufacturing Year',
            'Insurance Done Date',
            'Insurance From Date',
            'Insurance To Date',
            'GST',
            'Premium',
            'Policy Number',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = CarInsurance::with('party', 'executive', 'insurance');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('party_id', $this->partyFilter);
        }

        if (!empty($this->ploicyFilter)) {
            $query = $query->where('policy_number', $this->ploicyFilter);
        }

        // if (!empty($this->statusFilter)) {
        //     $query = $query->where('status', $this->statusFilter);
        // }

        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->party ? $carInsurance->party->party_name : "N/A",
                    $carInsurance->executive ? $carInsurance->executive->name : "N/A",
                    $carInsurance->insurance ? $carInsurance->insurance->name : "N/A",
                    $carInsurance->vehicle_number,
                    $carInsurance->manufacturing_year,
                    $carInsurance->insurance_done_date,
                    $carInsurance->insurance_from_date,
                    $carInsurance->insurance_to_date,
                    $carInsurance->gst,
                    $carInsurance->premium,
                    $carInsurance->policy_number,
                    $carInsurance->created_at,
                ];
            });
    }
}
