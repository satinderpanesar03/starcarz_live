<?php

namespace App\Exports;

use App\Models\HealthInsurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HealthInsuranceExport implements FromCollection, WithHeadings
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
            'Member Name',
            'Policy Number',
            'Sum Assured',
            'Start Date',
            'End Date',
            'GST',
            'Premium',
            'Gross Premium',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = HealthInsurance::with('party', 'memberName');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('party_id', $this->partyFilter);
        }

        if (!empty($this->ploicyFilter)) {
            $query = $query->where('policy_number', $this->ploicyFilter);
        }

        return $query->get()
            ->map(function ($healthInsurance) {
                $memberNames = $healthInsurance->memberName->pluck('member_name')->implode(', ');
                return [
                    $healthInsurance->id,
                    $healthInsurance->party ? $healthInsurance->party->party_name : "N/A",
                    $memberNames,
                    $healthInsurance->policy_number,
                    $healthInsurance->sum_assured,
                    $healthInsurance->start_date,
                    $healthInsurance->end_date,
                    $healthInsurance->gst,
                    $healthInsurance->premium,
                    $healthInsurance->gross_premium,
                    $healthInsurance->created_at,
                ];
            });
    }
}
