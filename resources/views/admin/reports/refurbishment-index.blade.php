@extends('admin.layouts.header')

@section('title', 'Refurbishment')
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
                                            <h5 class="pt-2 pb-2">Refurbishment List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                                <button class="btn btn-sm btn-primary py-1 mr-2 export-to-csv">Export CSV</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.refurbishment-report.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-sm-4">
                                                    <span class="text">Select Mode</span>
                                                    <select class="form-control" name="status" id="statusFilter">
                                                        <option value="" disabled {{ request()->get('status') == null ? 'selected' : '' }}>Choose...</option>
                                                        <option value="6" {{ request()->get('status') == 6 ? 'selected' : '' }}>Purchased</option>
                                                        <option value="7" {{ request()->get('status') == 7 ? 'selected' : '' }}>Park and Sale</option>
                                                    </select>
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

                                                <div class="col-sm-4">
                                                    <span class="text">Enter Car Number</span>
                                                    <input type="text" id="car_number" name="car_number" class="form-control" value="{{request()->query('car_number') ?? ''}}" placeholder="Car Number">
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
                                        <form action="{{route('admin.refurbishment-report.index')}}" method="get">
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
                                                <th>Mode</th>
                                                <th>Party Name</th>
                                                <th>Vehicle number</th>
                                                <th>Actual</th>
                                                <th>Evaluation Estimate</th>
                                                <th>Deviation</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($refurbishments as $value => $refurbishment)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>
                                                    @if ($refurbishment->status == 6)
                                                    Purchased
                                                    @elseif ($refurbishment->status == 7)
                                                    Park and Sale
                                                    @else
                                                    ''
                                                    @endif
                                                </td>
                                                <td>{{$refurbishment->party ? ucfirst($refurbishment->party->party_name) : ''}}</td>
                                                <td>{{$refurbishment->purchase ? strtoupper($refurbishment->purchase->reg_number) : ''}}</td>
                                                <td>{{$refurbishment->total_amount}}</td>
                                                <td>{{$refurbishment->purchase ? strtoupper($refurbishment->purchase->total) : ''}}</td>
                                                <td>
                                                    @php
                                                        $deviation = $refurbishment->total_amount - ($refurbishment->purchase ? strtoupper($refurbishment->purchase->total) : 0);
                                                    @endphp
                                                    {{ $deviation }}
                                                </td>
                                                <td class="text-truncatle">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.refurbishment-report-view.view', $refurbishment->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <!-- <a href="{{route('admin.refurbishment.show', $refurbishment->id)}}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a> -->
                                                    </span>
                                                </td>

                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$refurbishments->appends($_GET)->links()}}
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
        $('#statusFilter').selectize();
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
                text: 'Are you sure you want to delete the color "' + colorName + '"?',
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
            var url = '{{ route('admin.refurbishment-report.export', ['extension' => 'csv']) }}';
            url += `?partyFilter=${partyFilter}&carFilter=${carFilter}&statusFilter=${statusFilter}&fromDate=${fromDate}&toDate=${toDate}`;

            window.location.href = url;
        });
    });
</script>
@endpush