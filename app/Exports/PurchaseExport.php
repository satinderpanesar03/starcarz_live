<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PurchaseExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $start_date;
    protected $end_date;
    protected $executiveFilter;
    protected $partyFilter;
    protected $modelFilter;
    protected $statusFilter;

    public function __construct($start_date = null, $end_date = null, $executiveFilter = null, $partyFilter = null, $modelFilter = null, $statusFilter = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->executiveFilter = $executiveFilter;
        $this->partyFilter = $partyFilter;
        $this->modelFilter = $modelFilter;
        $this->statusFilter = $statusFilter;
    }
    public function headings(): array
    {
        return [
            '#',
            'Reg Number',
            'Enquiry ID',
            'Executive ID',
            'Evaluation Date',
            'Party ID',
            'Registered Owner',
            'Manufacturing Year',
            'Insurance Due Date',
            'Remarks',
            'Followup Date',
            'Policy Number',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = Purchase::with('party', 'executive')->where('status', '!=', 5);

        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->executiveFilter)) {
            $query = $query->where('mst_executive_id', $this->executiveFilter);
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
            ->map(function ($insurance) {
                return [
                    $insurance->id,
                    $insurance->reg_number,
                    $insurance->enquiry_id,
                    $insurance->executive ? $insurance->executive->name : "N/A",
                    $insurance->evaluation_date,
                    $insurance->party ? $insurance->party->party_name : "N/A",
                    $insurance->registered_owner,
                    $insurance->manufacturing_year,
                    $insurance->insurance_due_date,
                    $insurance->remarks,
                    $insurance->policy_number,
                    $insurance->coverage_detail,
                    $insurance->created_at,
                ];
            });
    }
}
