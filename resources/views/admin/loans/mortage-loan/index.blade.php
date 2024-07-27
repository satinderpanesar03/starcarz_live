@extends('admin.layouts.header')

@section('title', 'Mortage Loan')
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
                                            <h5 class="pt-2 pb-2">Manage Mortage Loans List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.loan.mortage-loan.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Mortage Loan </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{ route('admin.loan.mortage-loan.index') }}" id="search" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <span class="text">Enter Party Name</span>
                                                        <input class="form-control" placeholder="Party Name" type="text" id="search" value="{{request()->query('party_name')}}" name="party_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="modelFilter">Select SubType:</label>
                                                        <select class="form-control model-filter" id="loanFilter" name="loan_type">
                                                            <option value="">Select Model</option>
                                                            @foreach($loanType as $id => $model)
                                                            <option value="{{ $id }}" @if(request()->query('loan_type') == $id) selected @endif>{{ $model }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="statusFilter">Select Status:</label>
                                                        <select class="form-control status-filter" id="statusFilter" name="status">
                                                            <option value="">Select Status</option>
                                                            @foreach($status as $id => $bank)
                                                            <option value="{{ $id }}" @if(request()->query('status') == $id) selected @endif>{{ $bank }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="dealerFilter">Select Bank:</label>
                                                        <select class="form-control dealer-filter" id="bankFilter" name="bank">
                                                            <option value="">Select Bank</option>
                                                            @foreach($banks as $id => $dealer)
                                                            <option value="{{ $id }}" @if(request()->query('bank') == $id) selected @endif>{{ $dealer }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="executiveFilter">Select Executive:</label>
                                                        <select class="form-control executive-filter" id="executiveFilter" name="executive">
                                                            <option value="">Select Executive</option>
                                                            @foreach($executives as $id => $executive)
                                                            <option value="{{ $id }}" {{ request()->get('executive') == $id ? 'selected' : '' }}>{{ $executive }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fromDate">From Date:</label>
                                                        <input type="date" class="form-control" id="fromDate" name="fromDate" value="{{ request()->query('fromDate') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="toDate">To Date:</label>
                                                        <input type="date" class="form-control" id="toDate" name="toDate" value="{{ request()->query('toDate') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 ml-3">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-success">Search</button>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button value="clear_search" name="clear_search" class="btn btn-danger">Clear search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.loan.mortage-loan.index')}}" method="get">
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
                                            <tr style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <th width="5%">ID</th>
                                                <th>Party</th>
                                                <th>Executive</th>
                                                <th>Type</th>
                                                <th>Bank</th>
                                                <th>Login Date</th>
                                                <th>Ln. Amt</th>
                                                <th>Disb. Amt</th>
                                                <th>Emi Period</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($mortageLoans as $key => $mortageLoan)
                                            <tr style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <td>{{ $mortageLoans->firstItem() + $key }}</td>
                                                <td style="color: inherit; font-size: 12px;">{{ ($mortageLoan->party) ? $mortageLoan->party->party_name : '' }}</td>
                                                <td style="color: inherit; font-size: 13px;">{{ ($mortageLoan->executive) ? $mortageLoan->mst_executive->name : '' }}</td>
                                                <td style="color: inherit; font-size: 12px;">{{ ($mortageLoan->getLoanTypeName($mortageLoan->loan_type)) ? $mortageLoan->getLoanTypeName($mortageLoan->loan_type) : '' }}</td>
                                                <td style="color: inherit; font-size: 12px;">{{ ($mortageLoan->bank) ? $mortageLoan->bank->name : '' }}</td>
                                                <td>{{ date('d-m-Y',strtotime($mortageLoan->login_date)) ?? '' }}</td>
                                                <td>{{ ($mortageLoan->loan_amount) ? $mortageLoan->loan_amount : '' }}</td>
                                                <td>{{ $mortageLoan->disbursed_sum_disbursed_amount ?? 'Not Added' }}</td>
                                                <td style="color: inherit; font-size: 12px;">{{ isset($mortageLoan->disbursed) ? date('d-m-Y',strtotime($mortageLoan->disbursed->emi_start_date)) . ' - ' . date('d-m-Y',strtotime($mortageLoan->disbursed->emi_end_date)) : '---' }}</td>
                                                <td>
                                                    @php
                                                    $statusClass = '';
                                                    switch($mortageLoan->status) {
                                                    case 1:
                                                    $statusClass = 'badge-light';
                                                    break;
                                                    case 2:
                                                    $statusClass = 'badge-success';
                                                    break;
                                                    case 3:
                                                    $statusClass = 'badge-warning';
                                                    break;
                                                    case 4:
                                                    $statusClass = 'badge-info';
                                                    break;
                                                    default:
                                                    $statusClass = 'badge-secondary';
                                                    }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $mortageLoan->getStatusName($mortageLoan->status) }}</span>
                                                </td>
                                                <td class="text-truncatle">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{ route('admin.loan.mortage-loan.view', $mortageLoan->id) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.loan.mortage-loan.show', $mortageLoan->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$mortageLoans->appends($_GET)->links()}}
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

        $('#listing-filter-toggle').click(function() {
            $('#listing-filter-data').toggle();
            $('#statusFilter').selectize();
            $('#loanFilter').selectize();
            $('#executiveFilter').selectize();
            $('#bankFilter').selectize();
        });

        $('.delete-color').click(function(event) {
            event.preventDefault(); // Prevent the default action of the link
            var deleteUrl = $(this).attr('href');
            var colorName = $(this).data('color');

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Confirm Deletion',
                text: 'Are you sure you want to delete the role "' + colorName + '"?',
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
