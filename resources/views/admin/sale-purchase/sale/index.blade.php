@extends('admin.layouts.header')

@section('title', 'Sales')
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
                                            <h5 class="pt-2 pb-2">Manage Sale Enquiry List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            @if ($type)
                                            <a href="{{route('admin.sale.sale.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Sale Enquiry </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.sale.sale.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-sm-3">
                                                    <label for="statusFilter">Select Status:</label>
                                                    <select class="form-control status-filter" id="statusFilter" name="status">
                                                        <option value="">Select Status</option>
                                                        @foreach($status as $id => $model)
                                                        <option value="{{ $id }}">{{ $model }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-3">
                                                    <span class="text">Enter Party Name</span>
                                                    <select class="form-control" name="party_id" id="party_id">
                                                            <option value=""  selected disabled >Choose...</option>
                                                        @foreach ($parties as $party)
                                                            <option value="{{$party->party_name}}">{{$party->party_name}}</option>
                                                        @endforeach
                                                        </select>
                                                </div>

                                                <div class="col-sm-3">
                                                    <span class="text">Enter Car Number</span>
                                                    <input type="text" id="car_number" name="car_number" class="form-control" value="{{request()->query('car_number') ?? ''}}" placeholder="Car Number">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mt-2 ml-3">
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
                                        <form action="{{route('admin.sale.sale.index')}}" method="get">
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
                                                <th>Car Name</th>
                                                <th>Enquiry Date</th>
                                                <th>Status</th>
                                                <!-- <th>Executive</th>
                                                <th>Model</th>
                                                <th>Budget</th>
                                                <th>Remarks</th> -->
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($sales as $value => $sale)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ ($sale->firm_name) ? $sale->firm_name : '' }}</td>
                                                <td>{{ ($sale->modelName) ? $sale->modelName->model : ''}}</td>
                                                <td>{{date('d M,Y', strtotime($sale->created_at))}}</td>
                                                <td>
                                                    @php
                                                    $statusClass = '';
                                                    switch($sale->status) {
                                                    case 1:
                                                    $statusClass = 'badge-light'; // Pending - Blue
                                                    break;
                                                    case 2:
                                                    $statusClass = 'badge-warning'; // In Progress - Yellow
                                                    break;
                                                    case 3:
                                                    $statusClass = 'badge-success'; // Completed - Green
                                                    break;
                                                    case 4:
                                                    $statusClass = 'badge-info'; // On Hold - Light Blue
                                                    break;
                                                    default:
                                                    $statusClass = 'badge-secondary'; // Default - Gray
                                                    }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $sale->getStatusName($sale->status) }}</span>
                                                </td>
                                                <td class="text-truncate">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.sale.sale.view', $sale->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{route('admin.sale.sale.show', $sale->id)}}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form id="partyForm" action="{{ route('admin.sale.sale.status', ['id' => $sale->id, 'state_id' => $sale->state_id]) }}" method="GET" style="display: inline;">
                                                            <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                <input type="checkbox" @if($sale->state_id == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
                                                            </a>
                                                        </form>
                                                    </span>
                                                </td>
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
        </script>
        @endpush