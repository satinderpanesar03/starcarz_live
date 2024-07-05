<?php

namespace App\Exports;

use App\Models\PendingDocument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendingDocumentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start_date;
    protected $end_date;

    public function __construct($start_date = null, $end_date = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function headings(): array
    {
        return [
            '#',
            'RC',
            'Insurance',
            'Delivery Documents',
            '2nd Key',
            'Pan Card',
            'Aadhar Card',
            'Photographs',
            'Transfer Set',
            'Created At'
        ];
    }

    public function collection()
    {
        $query = PendingDocument::query();
        $query = $query->where(function ($query) {
            $query->where('rc', 'Pending')
                ->orWhere('insurance', 'Pending')
                ->orWhere('delivery_document', 'Pending')
                ->orWhere('key', 'Pending')
                ->orWhere('pancard', 'Pending')
                ->orWhere('aadharcard', 'Pending')
                ->orWhere('photograph', 'Pending')
                ->orWhere('transfer_set', 'Pending');
        });
        if ($this->start_date && $this->end_date) {
            $query = $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        return $query->get()
            ->map(function ($carInsurance) {
                return [
                    $carInsurance->id,
                    $carInsurance->rc,
                    $carInsurance->insurance,
                    $carInsurance->delivery_document,
                    $carInsurance->key,
                    $carInsurance->pancard,
                    $carInsurance->aadharcard,
                    $carInsurance->photograph,
                    $carInsurance->transfer_set,
                    $carInsurance->created_at,
                ];
            });
    }
}
