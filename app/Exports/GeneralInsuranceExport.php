<?php

namespace App\Exports;

use App\Models\GeneralInsurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class GeneralInsuranceExport implements FromCollection, WithHeadings
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
            'Executive',
            'Company',
            'Insurance Type',
            'Insurance Done Date',
            'Insurance From Date',
            'Insurance To Date',
            'GST',
            'Sum Insured',
            'Total',
            'Policy Number',
            'Coverage Details',
        ];
    }

    public function collection()
    {
        $query = GeneralInsurance::with('party', 'executive', 'insurance', 'insuranceType');
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
            ->map(function ($insurance) {
                return [
                    $insurance->id,
                    'Party Name' => $insurance->party->party_name ?? '',
                    'Executive id' => $insurance->executive->name ?? '',
                    'Company id' => $insurance->company->name ?? '',
                    'Insurance Type' => $insurance->insuranceType->name ?? '',
                    'Insurance Done Date' => $insurance->insurance_done_date,
                    'Insurance From Date' => $insurance->insurance_from_date,
                    'Insurance To Date' => $insurance->insurance_to_date,
                    'GST' => $insurance->gst,
                    'Sum Insured' => $insurance->sum_insured,
                    'Total' => $insurance->total,
                    'Policy Number' => $insurance->policy_number,
                    'Coverage Details' => $insurance->coverage_detail,
                ];
            });
    }
}
