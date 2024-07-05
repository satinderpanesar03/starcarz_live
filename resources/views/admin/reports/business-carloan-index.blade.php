@extends('admin.layouts.header')

@section('title', 'Car Loan')
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
                                            <h5 class="pt-2 pb-2">Car Loans List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{ route('admin.businesscar-loan-report.index') }}" method="get">
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="modelFilter">Select Model:</label>
                                                        <select class="form-control model-filter" id="modelFilter" name="modelFilter">
                                                            <option value="">Select Model</option>
                                                            @foreach($models as $id => $model)
                                                            <option value="{{ $id }}" {{ request()->get('modelFilter') == $id ? 'selected' : '' }}>{{ $model }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dealerFilter">Select Dealer:</label>
                                                        <select class="form-control dealer-filter" id="dealerFilter" name="dealerFilter">
                                                            <option value="">Select Dealer</option>
                                                            @foreach($dealers as $id => $dealer)
                                                            <option value="{{ $id }}" {{ request()->get('dealerFilter') == $id ? 'selected' : '' }}>{{ $dealer }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
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
                                        <form action="{{route('admin.businesscar-loan-report.index')}}" method="get">
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
                                                <!-- <th>Dealer</th> -->
                                                <th>Model</th>
                                                <th>Manufacturing Year</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($carLoans as $key => $carLoan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ($carLoan->party->party_name)?$carLoan->party->party_name:'' }}</td>
                                                <!-- <td>{{ ($carLoan->dealer->name)?$carLoan->dealer->name:'' }}</td> -->
                                                <td>{{ ($carLoan->carModel->model)?$carLoan->carModel->model:'' }}</td>
                                                <td>{{ ($carLoan->manufacturing_year)?$carLoan->manufacturing_year:'' }}</td>
                                                <td>
                                                    @php
                                                    $statusClass = '';
                                                    switch($carLoan->status) {
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
                                                    <span class="badge {{ $statusClass }}">{{ $carLoan->getStatusName($carLoan->status) }}</span>
                                                </td>
                                                <td class="text-truncatle">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{ route('admin.loan.car-loan.view', $carLoan->id) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <!-- <a href="{{ route('admin.loan.car-loan.show', $carLoan->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form id="partyForm" action="{{ route('admin.loan.car-loan.status', ['id' => $carLoan->id, 'state_id' => $carLoan->state_id]) }}" method="GET" style="display: inline;">
                                                            <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                <input type="checkbox" @if($carLoan->state_id == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
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
                                        {{$carLoans->appends($_GET)->links()}}
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
            $('#modelFilter').selectize();
            $('#dealerFilter').selectize();
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
                var dealerFilter = $('#dealerFilter').val();
                var partyFilter = $('#partyFilter').val();
                var modelFilter = $('#modelFilter').val();
                var statusFilter = $('#statusFilter').val();

                // Construct the URL with all the filter query parameters
                var url = '{{ route('admin.businesscar-loan-report.export', ['extension' => 'csv']) }}';
                url += `?dealerFilter=${dealerFilter}&partyFilter=${partyFilter}&modelFilter=${modelFilter}&statusFilter=${statusFilter}&fromDate=${fromDate}&toDate=${toDate}`;

                window.location.href = url;
            });
        });
</script>
@endpush