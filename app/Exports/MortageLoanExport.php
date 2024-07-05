<?php

namespace App\Exports;

use App\Models\MortageLoan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MortageLoanExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start_date;
    protected $end_date;
    protected $loanFilter;
    protected $partyFilter;
    protected $statusFilter;

    public function __construct($start_date = null, $end_date = null, $loanFilter = null, $partyFilter = null, $statusFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->loanFilter = $loanFilter;
        $this->partyFilter = $partyFilter;
        $this->statusFilter = $statusFilter;
    }
    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Loan Type',
            'Insurance Type',
            'MCLR',
            'Margin',
            'Effective Rate',
            'Created At'
        ];
    }
    public function collection()
    {
        $query = MortageLoan::with('party', 'insuranceType');
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->loanFilter)) {
            $query = $query->where('loan_type', $this->loanFilter);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('mst_party_id', $this->partyFilter);
        }

        if (!empty($this->statusFilter)) {
            $query = $query->where('status', $this->statusFilter);
        }

        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->party ? $carInsurance->party->party_name : "N/A",
                    MortageLoan::getLoanTypeName($carInsurance->loan_type),
                    $carInsurance->insuranceType ? $carInsurance->insuranceType->name : "N/A",
                    $carInsurance->mclr,
                    $carInsurance->margin,
                    $carInsurance->effective_rate,
                    $carInsurance->created_at,
                ];
            });
    }
}
