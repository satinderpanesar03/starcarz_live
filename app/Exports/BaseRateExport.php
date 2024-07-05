<?php

namespace App\Exports;

use App\Models\MortageLoan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BaseRateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $rateFilter;
    protected $partyFilter;

    public function __construct($rateFilter = null, $partyFilter = null)
    {
        $this->rateFilter = $rateFilter;
        $this->partyFilter = $partyFilter;
    }

    public function headings(): array
    {
        return [
            '#',
            'Party Name',
            'Loan Type',
            'Base Rate',
            'Total Amount',
        ];
    }
    public function collection()
    {
        $query = MortageLoan::with('party', 'insuranceType');

        if (!empty($this->rateFilter)) {
            $query = $query->where('mclr', $this->rateFilter);
        }

        if (!empty($this->partyFilter)) {
            $query = $query->where('mst_party_id', $this->partyFilter);
        }


        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->party ? $carInsurance->party->party_name : "N/A",
                    MortageLoan::getLoanTypeName($carInsurance->loan_type),
                    $carInsurance->mclr,
                    $carInsurance->effective_rate,
                ];
            });
    }
}
