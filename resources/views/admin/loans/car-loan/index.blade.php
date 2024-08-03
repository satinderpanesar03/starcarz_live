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
                                            <h5 class="pt-2 pb-2">Manage Car Loans List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.loan.car-loan.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Car Loan </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{ route('admin.loan.car-loan.index') }}" id="search" method="get">
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
                                                        <label for="dealerFilter">Select Bank:</label>
                                                        <select class="form-control dealer-filter" id="dealerFilter" name="bank">
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
                                                        <label for="executiveFilter">Select Loan Type:</label>
                                                        <select class="form-control executive-filter" id="loanFilter" name="loan_type">
                                                            <option value="">Choose...</option>
                                                            @foreach($loanType as $id => $executive)
                                                            <option value="{{ $id }}" {{ request()->get('loan_type') == $id ? 'selected' : '' }}>{{ $executive }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="executiveFilter">Select Car TYpe:</label>
                                                        <select class="form-control executive-filter" id="carFilter" name="car_type">
                                                            <option value="">Choose...</option>
                                                            @foreach($carType as $id => $executive)
                                                            <option value="{{ $id }}" {{ request()->get('car_type') == $id ? 'selected' : '' }}>{{ $executive }}</option>
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
                                        <form action="{{route('admin.loan.car-loan.index')}}" method="get">
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
                                                <th>Party Name</th>
                                                <th>Bank Name</th>
                                                <!-- <th>Dealer</th> -->
                                                <th>Loan Amount</th>
                                                <th>Executive Name</th>
                                                <!-- <th>Registration Date</th> -->
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($carLoans as $key => $carLoan)
                                            <tr>
                                                <td>{{ $carLoans->firstItem() + $key }}</td>
                                                {{-- <td>{{ ($carLoan->party)?$carLoan->party->party_name:'' }}</td> --}}
                                                <td><a style="color: inherit;" @if(isset($carLoan->party->id)) href="{{route('admin.master.party.view', $carLoan->party->id)}}" @endif>{{$carLoan->party ? ucfirst($carLoan->party->party_name) : ''}}</a></td>
                                                <!-- <td>{{ ($carLoan->dealer)?$carLoan->dealer->name:'' }}</td> -->
                                                <td>{{ ($carLoan->bank)?$carLoan->bank->name:'' }}</td>
                                                <td>{{ ($carLoan->loan_amount)?$carLoan->loan_amount:'' }}</td>
                                                <td>{{ $carLoan->executive() ? $carLoan->executive()->name : '' }}</td>
                                                <!-- <td>{{ $carLoan->getStatusName($carLoan->status) }}</td> -->
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

                                                        @if($carLoan->status != 4 || in_array(1, $roleNames))
                                                        <a href="{{ route('admin.loan.car-loan.show', $carLoan->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @endif

                                                        <a href="{{ route('admin.loan.chart.index', $carLoan->id) }}" class="btn btn-success btn-sm" title="Chart">
                                                            <i class="fa fa-file"></i>
                                                        </a>
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
            $('#statusFilter').selectize();
            $('#modelFilter').selectize();
            $('#dealerFilter').selectize();
            $('#executiveFilter').selectize();
            $('#loanFilter').selectize();
            $('#carFilter').selectize();
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
