@extends('admin.layouts.header')

@section('title', 'Documents')
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
                                            <h5 class="pt-2 pb-2">Pending Documents</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.document-report.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
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
                                        <form action="{{route('admin.document-report.index')}}" method="get">
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
                                                <th>RC</th>
                                                <th>Insurance</th>
                                                <th>Delivery Documents</th>
                                                <th>2nd Key</th>
                                                <th>Pan Card</th>
                                                <th>Aadhar Card</th>
                                                <th>Photographs</th>
                                                <th>Transfer Set</th>
                                                <!-- <th>Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($documents as $value => $sale)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ ($sale->rc) ? $sale->rc : '' }}</td>
                                                <td>{{ ($sale->insurance) ? $sale->insurance : ''}}</td>
                                                <td>{{ ($sale->delivery_document) ? $sale->delivery_document : ''}}</td>
                                                <td>{{ ($sale->key) ? $sale->key : ''}}</td>
                                                <td>{{ ($sale->pancard) ? $sale->pancard : ''}}</td>
                                                <td>{{ ($sale->aadharcard) ? $sale->aadharcard : ''}}</td>
                                                <td>{{ ($sale->photograph) ? $sale->photograph : ''}}</td>
                                                <td>{{ ($sale->transfer_set) ? $sale->transfer_set : ''}}</td>
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
                                        {{$documents->appends($_GET)->links()}}
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

                if ($.fn.DataTable.isDataTable('#example')) {
                    var table = $('#example').DataTable();

                    $('.executive-filter').on('change', function() {
                        var executiveId = $(this).val();
                        table.column(4).search(executiveId).draw();
                        console.log('executiveId:', executiveId);
                    });

                    $('.model-filter').on('change', function() {
                        var modelId = $(this).val(); // Get the selected executive ID
                        table.column(5).search(modelId).draw();
                        console.log('modelId:', modelId);
                    });

                    $('#fromDate, #toDate').on('change', function() {
                        let fromDate = $('#fromDate').val();
                        let toDate = $('#toDate').val();

                        // Convert date strings to moment objects
                        let minDate = fromDate ? moment(fromDate, 'YYYY-MM-DD') : null;
                        let maxDate = toDate ? moment(toDate, 'YYYY-MM-DD') : null;

                        // Custom filtering function
                        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                            let date = moment(data[1], 'YYYY-MM-DD'); // Assuming the date is in the fourth column

                            if ((minDate === null || date >= minDate) && (maxDate === null || date <= maxDate)) {
                                return true;
                            }
                            return false;
                        });

                        // Re-draw the DataTable to apply the filtering
                        table.draw();

                        // Remove the custom filtering function after drawing the table
                        $.fn.dataTable.ext.search.pop();
                    });
                }
            });

            $(document).ready(function() {
                $('.export-to-csv').on('click', function(e) {
                    e.preventDefault();

                    // Get values from the form
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();

                    // Construct the URL with all the filter query parameters
                    var url = '{{ route('admin.document-report.export', ['extension' => 'csv']) }}';
                    url += `?fromDate=${fromDate}&toDate=${toDate}`;

                    window.location.href = url;
                });
            });
        </script>
        @endpush