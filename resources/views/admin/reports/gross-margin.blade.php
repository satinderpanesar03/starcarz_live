@extends('admin.layouts.header')

@section('title', 'Gross Margin')
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
                                            <h5 class="pt-2 pb-2">Gross Margin</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.gross-margin-report.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-md-3">
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
                                                <div class="col-sm-3">
                                                    <span class="text">Enter Car Number</span>
                                                    <input type="text" id="car_number" name="car_number" class="form-control" value="{{request()->query('car_number') ?? ''}}" placeholder="Car Number">
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
                                        <form action="{{route('admin.gross-margin-report.index')}}" method="get">
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
                                                <th>Car Name</th>
                                                <th>Purchase Price</th>
                                                <th>Sale Price</th>
                                                <th>Gross Margin</th>
                                                <!-- <th>Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($sales as $value => $sale)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ ($sale->party) ? $sale->party->party_name : '' }}</td>
                                                <td>{{ ($sale->purchase) ? $sale->purchase->reg_number : ''}}</td>
                                                <td>{{ $sale->purchase_price }}</td>
                                                <td>{{ $sale->price_p1 }}</td>
                                                <td>{{ $sale->gross_margin_percentage.'%' }}</td>
                                                <!-- <td class="text-truncate">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.sale.sale.view', $sale->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </span>
                                                </td> -->
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$sales->appends($_GET)->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @endsection
        @push('scripts')

        <script>
            $(document).ready(function() {

                $('#listing-filter-toggle').click(function() {
                    $('#listing-filter-data').toggle();
                    $('#partyFilter').selectize();
                    $('#statusFilter').selectize();
                });

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

            $(document).ready(function() {
                $('.export-to-csv').on('click', function(e) {
                    e.preventDefault();

                    // Get values from the form
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();
                    var partyFilter = $('#partyFilter').val();
                    var carFilter = $('#car_number').val();
                    var statusFilter = $('#statusFilter').val();

                    // Construct the URL with all the filter query parameters
                    var url = '{{ route('admin.gross-margin-report.export', ['extension' => 'csv']) }}';
                    url += `?partyFilter=${partyFilter}&carFilter=${carFilter}&statusFilter=${statusFilter}&fromDate=${fromDate}&toDate=${toDate}`;

                    window.location.href = url;
                });
            });
        </script>
        @endpush