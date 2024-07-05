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
                                            <h5 class="pt-2 pb-2">Mortage Loans List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{ route('admin.mortage-loan-report.index') }}" id="search" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-sm-4">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="loanFilter">Select Loan:</label>
                                                        <select class="form-control model-filter" id="loanFilter" name="loanFilter">
                                                            <option value="">Select Loan</option>
                                                            @foreach($loanType as $id => $model)
                                                            <option value="{{ $id }}" {{ request()->get('loanFilter') == $id ? 'selected' : '' }}>{{ $model }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="statusFilter">Select Status:</label>
                                                        <select class="form-control status-filter" id="statusFilter" name="statusFilter">
                                                            <option value="">Select Status</option>
                                                            @foreach($status as $id => $bank)
                                                            <option value="{{ $id }}" {{ request()->get('statusFilter') == $id ? 'selected' : '' }}>{{ $bank }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="fromDate">From Date:</label>
                                                        <input type="date" class="form-control" id="fromDate" name="fromDate" value="{{ request()->query('fromDate') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="toDate">To Date:</label>
                                                        <input type="date" class="form-control" id="toDate" name="toDate" value="{{ request()->query('toDate') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 mt-2 ml-3">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-success">Search</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button value="clear_search" name="clear_search" class="btn btn-danger">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.mortage-loan-report.index')}}" method="get">
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
                                                <th width="5%">ID</th>
                                                <th>Party</th>
                                                <th>Loan Type</th>
                                                <th>MCLR</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($mortageLoans as $key => $mortageLoan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ($mortageLoan->party->party_name) ? $mortageLoan->party->party_name : '' }}</td>
                                                <td>{{ ($mortageLoan->getLoanTypeName($mortageLoan->loan_type)) ? $mortageLoan->getLoanTypeName($mortageLoan->loan_type) : '' }}</td>
                                                <td>{{ ($mortageLoan->mclr) ? $mortageLoan->mclr : '' }}</td>
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
                                                        <!-- <a href="{{ route('admin.loan.mortage-loan.show', $mortageLoan->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form id="partyForm" action="{{ route('admin.loan.mortage-loan.status', ['id' => $mortageLoan->id, 'state_id' => $mortageLoan->state_id]) }}" method="GET" style="display: inline;">
                                                            <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                <input type="checkbox" @if($mortageLoan->state_id == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
                                                            </a>
                                                        </form> -->
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
            $('#partyFilter').selectize();
            $('#loanFilter').selectize();
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

    $(document).ready(function() {
            $('.export-to-csv').on('click', function(e) {
                e.preventDefault();

                // Get values from the form
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var loanFilter = $('#loanFilter').val();
                var partyFilter = $('#partyFilter').val();
                var statusFilter = $('#statusFilter').val();

                // Construct the URL with all the filter query parameters
                var url = '{{ route('admin.mortage-loan-report.export', ['extension' => 'csv']) }}';
                url += `?loanFilter=${loanFilter}&partyFilter=${partyFilter}&statusFilter=${statusFilter}&fromDate=${fromDate}&toDate=${toDate}`;

                window.location.href = url;
            });
        });
</script>
@endpush