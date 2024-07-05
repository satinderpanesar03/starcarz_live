@extends('admin.layouts.header')
@section('title', 'Party Report')
@section('content')

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
                                            <h5 class="pt-2 pb-2">Party Data List</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.party-report.index')}}" method="get" id="search">
                                        <div class="row col-sm-12">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="partyFilter">Select Party:</label>
                                                    <select class="form-control party-filter" id="partyFilter" name="partyFilter">
                                                        <option value="">Select Party</option>
                                                        @foreach($party as $id => $model)
                                                        <option value="{{ $id }}" {{ request()->get('partyFilter') == $id ? 'selected' : '' }}>{{ $model }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-3">
                                                <button type="submit" class="btn btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.party-report.index')}}" method="get">
                                            <div><label>Show
                                                    <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                        @foreach(showEntries() as $limit)
                                                        <option value="{{ $limit }}" @if(request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
                                                        @endforeach
                                                    </select> entries</label></div>
                                        </form>
                                    </div>
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Party Name</th>
                                                <th>From</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        @if($mergedData->isNotEmpty()) <!-- Check if data is available -->
                                        <tbody>
                                            @foreach($mergedData as $value => $sale)
                                            <tr>
                                                <td>{{ ++$value }}</td>
                                                <td>{{ ($sale->party) ? $sale->party->party_name : '' }}</td>
                                                <td>{{ preg_replace('/(?<!\s)([A-Z])/', ' $1', class_basename(get_class($sale))) }}</td>
                                                <td class="text-truncate">
                                                    <span style="white-space:nowrap;" class="">
                                                        @if ($sale instanceof App\Models\SaleDetail)
                                                        <a href="{{ route('admin.sale.sale.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\Purchase)
                                                        <a href="{{ route('admin.purchase.purchase.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\CarLoan)
                                                        <a href="{{ route('admin.loan.car-loan.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\MortageLoan)
                                                        <a href="{{ route('admin.loan.mortage-loan.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\TermInsurance)
                                                        <a href="{{ route('admin.term.insurance.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\HealthInsurance)
                                                        <a href="{{ route('admin.health.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\GeneralInsurance)
                                                        <a href="{{ route('admin.general.insurance.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\CarInsurance)
                                                        <a href="{{ route('admin.car.insurance.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\RcTransfer)
                                                        <a href="{{ route('admin.rc-transfer.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @elseif ($sale instanceof App\Models\RefurbnishmentOrder)
                                                        <a href="{{ route('admin.refurbishment.view', ['id' => $sale->id]) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                        <tbody>
                                            <tr>
                                                <td colspan="4" style="text-align:center;">No data available</td>
                                            </tr>
                                        </tbody>
                                        @endif
                                    </table>
                                    <div class="container d-flex justify-content-end">

                                    </div>
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
        $('#partyFilter').selectize();

        $('.delete-color').click(function(event) {
            event.preventDefault(); // Prevent the default action of the link
            var deleteUrl = $(this).attr('href');
            var colorName = $(this).data('color');

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Confirm Deletion',
                text: 'Are you sure you want to delete the broker "' + colorName + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                // If user confirms deletion, redirect to the delete URL
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>
@endpush