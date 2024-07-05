<?php

namespace App\Exports;

use App\Models\TermInsurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TermInsuranceExport implements FromCollection, WithHeadings
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
            'Policy Number',
            'Insurance Done Date',
            'Insurance From Date',
            'Insurance To Date',
            'Sum Insured',
            'GST',
            'Premium',
            'Total',
            'Coverage Details',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = TermInsurance::with('party', 'executive', 'insurance');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('mst_party_id', $this->partyFilter);
        }

        if (!empty($this->ploicyFilter)) {
            $query = $query->where('policy_number', $this->ploicyFilter);
        }

        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->party ? $carInsurance->party->party_name : "N/A",
                    $carInsurance->executive ? $carInsurance->executive->name : "N/A",
                    $carInsurance->insurance ? $carInsurance->insurance->name : "N/A",
                    $carInsurance->policy_number,
                    $carInsurance->insurance_done_date,
                    $carInsurance->insurance_from_date,
                    $carInsurance->insurance_to_date,
                    $carInsurance->sum_insured,
                    $carInsurance->gst,
                    $carInsurance->premium,
                    $carInsurance->total,
                    $carInsurance->coverage_detail,
                    $carInsurance->created_at,
                ];
            });
    }
}
