@extends('admin.layouts.header')

@section('title', 'Base Rate Report')
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
                                            <h5 class="pt-2 pb-2">Base Rate Report List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <!-- <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button> -->
                                            <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.base-rate-report.index')}}" method="get" id="search">
                                        <div class="row col-sm-12">
                                            <div class="col-sm-4">
                                                <span class="text">Base Rate</span>
                                                <input class="form-control" placeholder="Base Rate" type="text" id="base_rate" value="{{request()->query('base_rate')}}" name="base_rate">
                                            </div>
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
                                        <form action="{{route('admin.base-rate-report.index')}}" method="get">
                                            <div><label>Show
                                                    <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                        @foreach(showEntries() as $limit)
                                                        <option value="{{ $limit }}" @if(request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
                                                        @endforeach
                                                    </select> entries</label></div>
                                        </form>
                                    </div>
                                    <!-- <div class="card-body table-responsive">
                                        <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.sale.enquiry.export',['extension' => 'xlsx']) }}'">Export to Excel</button>
                                        <button class="btn btn-secondary" onclick="window.location.href='{{ route('admin.sale.enquiry.export',['extension' => 'csv']) }}'">Export to CSV</button>
                                    </div> -->
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Party Name</th>
                                                <th>Base Rate</th>
                                                <th>Total Amount</th>
                                                <!-- <th>Actions</th> -->
                                            </tr>
                                        </thead>
                                        @if($mortgageLoanData->isNotEmpty())
                                        <tbody>
                                            @foreach($mortgageLoanData as $value => $sale)
                                            <tr>
                                                <td>{{ ++$value }}</td>
                                                <td>{{ ($sale->party) ? $sale->party->party_name : '' }}</td>
                                                <td>{{ $sale->mclr }}</td>
                                                <td>{{ $sale->effective_rate }}</td>
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
                                    {{$mortgageLoanData->appends($_GET)->links()}}
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
        $('#listing-filter-toggle').click(function() {
            $('#listing-filter-data').toggle();
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
            var rateFilter = $('#base_rate').val();
            var partyFilter = $('#partyFilter').val();

            // Construct the URL with all the filter query parameters
            var url = '{{ route('admin.base-rate-report.export', ['extension' => 'csv']) }}';
            url += `?rateFilter=${rateFilter}&partyFilter=${partyFilter}`;

            window.location.href = url;
        });
    });
</script>
@endpush