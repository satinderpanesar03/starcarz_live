@extends('admin.layouts.header')

@section('title', 'Chart Instalment')
@section('content')
<style>
    @media print {
        .print-button {
            display: none !important;
        }
    }

    .label-cell {
        width: 40%;
    }

    .data-cell {
        width: 60%;
    }
</style>
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="positioning">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2"></h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-info px-3 py-1 mr-2 print-button" onclick="window.print()">Print</button>

                                            <div class="d-flex justify-content-end align-items-center">
                                                <a href="{{route('admin.loan.car-loan.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-arrow-left"></i> Back </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="label-cell"><strong>Name</strong></td>
                                                <td class="data-cell"><strong>CHEMICALS</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>Car</strong></td>
                                                <td class="data-cell"></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>Loan Amt</strong></td>
                                                <td class="data-cell">{{ ($carLoan->loan_amount) ? $carLoan->loan_amount : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>Tenure</strong></td>
                                                <td class="data-cell">{{ ($carLoan->tenure) ? $carLoan->tenure.' Year' : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>EMI amount</strong></td>
                                                <td class="data-cell">{{ ($carLoan->emi_amount) ? $carLoan->emi_amount : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>Advance EMI</strong></td>
                                                <td class="data-cell">{{ ($carLoan->emi_advance) ? $carLoan->emi_advance : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>Net Loan Amount</strong></td>
                                                <td class="data-cell">{{ ($carLoan->loan_amount) ? $carLoan->loan_amount : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>EMI Start Date</strong></td>
                                                <td class="data-cell">{{ ($carLoan->emi_start_date) ? $carLoan->emi_start_date : 'Not available'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell"><strong>EMI End Date</strong></td>
                                                <td class="data-cell">{{ $emiEndDate ? $emiEndDate->format('Y-m-d') : 'Not available' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="6" class="text-center">Amortisation Schedule</th>
                                            </tr>
                                            <tr>
                                                <th>EMI Date</th>
                                                <th>Open Balance</th>
                                                <th>EMI</th>
                                                <th>Interest</th>
                                                <th>Repayment</th>
                                                <th>Outstanding</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            use Carbon\Carbon;

                                            $loanAmount = $carLoan->loan_amount;
                                            $roi = (float) str_replace('%', '', $carLoan->roi);
                                            $interestRate = $roi / 100;
                                            $emiAmount = $carLoan->emi_amount;
                                            $advanceEMI = $carLoan->emi_advance;
                                            $emiStartDate = Carbon::parse($carLoan->emi_start_date);
                                            $currentDate = $emiStartDate->copy();
                                            $outstanding = $loanAmount;
                                            $emiEndDate = null;
                                            $tenureYears = $carLoan->tenure; // Assuming tenure is the number of years
                                            $tenureMonths = $tenureYears * 12; // Convert years to months
                                            @endphp

                                            @for ($i = 0; $i < $tenureMonths; $i++) @php $interest=$outstanding * $interestRate / 12; $repayment=$emiAmount - $interest; $openBalance=max(0, $outstanding - $repayment); $outstanding=max(0, $outstanding - $repayment); @endphp <tr>
                                                <td>{{ $currentDate->format('Y-m-d') }}</td>
                                                <td>{{ number_format($openBalance, 2) }}</td>
                                                <td>{{ number_format($emiAmount, 2) }}</td>
                                                <td>{{ number_format($interest, 2) }}</td>
                                                <td>{{ number_format($repayment, 2) }}</td>
                                                <td>{{ number_format($outstanding, 2) }}</td>
                                                </tr>
                                                @php
                                                if ($outstanding == 0 && $emiEndDate === null) {
                                                $emiEndDate = $currentDate->copy();
                                                }
                                                $currentDate->addMonth();
                                                @endphp
                                                @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        async function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const table = document.querySelector('.table').outerHTML;

            doc.html(table, {
                callback: function(doc) {
                    doc.save('insurance-data.pdf');
                },
                x: 10,
                y: 10
            });
        }
    });
</script>
@endpush