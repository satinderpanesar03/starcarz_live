@extends('admin.layouts.header')

@section('title', 'Match Making')
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
                                            <h5 class="pt-2 pb-2">Match Making</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.match-making-report.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="partyFilter">Select Brand:</label>
                                                    <select class="form-control party-filter" id="brandFilter" name="brandFilter">
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $id => $model)
                                                        <option value="{{ $id }}" {{ request()->get('brandFilter') == $id ? 'selected' : '' }}>{{ $model }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="partyFilter">Select Model:</label>
                                                    <select class="form-control party-filter" id="modelFilter" name="modelFilter">
                                                        <option value="">Select Model</option>
                                                        @foreach($modelData as $id => $model)
                                                        <option value="{{ $id }}" {{ request()->get('modelFilter') == $id ? 'selected' : '' }}>{{ $model }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-sm-8 mt-2">
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
                                        <form action="{{route('admin.match-making-report.index')}}" method="get">
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
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Park & Sale</th>
                                                <th>Purchased</th>
                                                <th>Customer Demand</th>
                                                <!-- <th>Total Cars</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $row)
                                            <tr>
                                                <td>{{ $row['model_id'] }}</td>
                                                <td>{{ $row['brand'] }}</td>
                                                <td>{{ $row['model'] }}</td>
                                                <td>{{ $row['park_and_sale_count'] }}</td>
                                                <td>{{ $row['purchased'] }}</td>
                                                <td>{{ $row['customer_demand'] }}</td>
                                                <!-- <td>{{ $row['total_cars'] }}</td> -->
                                            </tr>
                                            @endforeach
                                        </tbody>
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

        $('#listing-filter-toggle').click(function() {
            $('#listing-filter-data').toggle();
            $('#brandFilter').selectize();
            $('#modelFilter').selectize();
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
            var brandFilter = $('#brandFilter').val();
            var modelFilter = $('#modelFilter').val();

            // Construct the URL with all the filter query parameters
            var url = '{{ route('admin.match-making-report.export', ['extension' => 'csv']) }}';
            url += `?brandFilter=${brandFilter}&modelFilter=${modelFilter}`;

            window.location.href = url;
        });
    });
</script>
@endpush