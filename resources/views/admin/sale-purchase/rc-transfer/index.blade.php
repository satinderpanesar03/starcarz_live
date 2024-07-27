@extends('admin.layouts.header')
@section('title', 'RC Transfer')
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
                                                <h5 class="pt-2 pb-2">Manage RC Transfers List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-danger px-3 py-1 mr-2"
                                                    id="listing-filter-toggle">
                                                    <i class="fa fa-filter"></i> Filter </button>
                                                <!-- @if ($type)
    <a href="{{ route('admin.rc-transfer.create') }}" class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-plus"></i> Add RC Transfer </a>
    @endif -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <form action="{{ route('admin.rc-transfer.index') }}" method="get">
                                            <div class="row mb-2" id="listing-filter-data"
                                                data-select2-id="listing-filter-data" style="display:none;">
                                                <div class="row col-sm-12 ml-2">
                                                    <div class="col-sm-3">
                                                        <span class="text">Select Source</span>
                                                        <select class="form-control" name="source" id="sourceFilter">
                                                            <option value="" selected disabled>Choose...</option>
                                                            <option value="Car Loan">Car Loan</option>
                                                            <option value="Aggregator Loan">Aggregator Loan</option>
                                                            <option value="Sale Order">Sale Order</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="partyFilter">Select Party:</label>
                                                            <select class="form-control party-filter" id="partyFilter"
                                                                name="partyFilter">
                                                                <option value="">Select Party</option>
                                                                @foreach ($parties as $id => $model)
                                                                    <option value="{{ $id }}"
                                                                        {{ request()->get('partyFilter') == $id ? 'selected' : '' }}>
                                                                        {{ $model }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="executiveFilter">Select Agent:</label>
                                                            <select class="form-control executive-filter"
                                                                id="executiveFilter" name="agent">
                                                                <option value="">Select Agent</option>
                                                                @foreach ($agents as $id => $executive)
                                                                    <option value="{{ $id }}"
                                                                        {{ request()->get('agent') == $id ? 'selected' : '' }}>
                                                                        {{ $executive }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="statusFilter">Select Status:</label>
                                                            <select class="form-control status-filter" id="statusFilter"
                                                                name="status">
                                                                <option value="">Select Status</option>
                                                                @foreach ($statusType as $id => $bank)
                                                                    <option value="{{ $id }}"
                                                                        @if (request()->query('status') == $id) selected @endif>
                                                                        {{ $bank }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="fromDate">From Date:</label>
                                                            <input type="date" class="form-control" id="fromDate"
                                                                name="fromDate" value="{{ request()->query('fromDate') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="toDate">To Date:</label>
                                                            <input type="date" class="form-control" id="toDate"
                                                                name="toDate" value="{{ request()->query('toDate') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 ml-3">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <button type="submit" class="btn btn-success">Search</button>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <button value="clear_search" name="clear_search"
                                                                class="btn btn-danger">Clear search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="card-body table-responsive">
                                            <form action="{{ route('admin.rc-transfer.index') }}" method="get">
                                                <div>
                                                    <label>Show
                                                        <select name="limit" aria-controls="all_quiz"
                                                            class="form-control-sm" onChange="submit()">
                                                            @foreach (showEntries() as $limit)
                                                                <option value="{{ $limit }}"
                                                                    @if (request()->query('limit', 10) == $limit) selected @endif>
                                                                    {{ $limit }}</option>
                                                            @endforeach
                                                        </select> entries
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                        <table class="table table-striped table-bordered dom-jQuery-events">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Party</th>
                                                    <th>Model</th>
                                                    <th>Reg. No.</th>
                                                    <th>Date</th>
                                                    <th>Source</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            @if ($combinedData->isNotEmpty())
                                                <tbody>
                                                    @foreach ($combinedData as $value => $sale)
                                                        <tr>
                                                            <td>{{ ++$value }}</td>
                                                            <td>
                                                                @if ($sale instanceof App\Models\AggregatorLoan)
                                                                    {{ $sale->firm_name }}
                                                                @else
                                                                    {{ ($sale->party) ? $sale->party->party_name : '' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($sale instanceof App\Models\AggregatorLoan)
                                                                    {{ strtoupper($sale->model) }}
                                                                @else
                                                                    {{ ($sale->carModel) ? $sale->carModel->model : '---' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($sale instanceof App\Models\SaleOrder)
                                                                    {{ $sale->purchase ? $sale->purchase->reg_number : '' }}
                                                                @else
                                                                    {{ $sale->vehicle_number }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($sale instanceof App\Models\AggregatorLoan)
                                                                    {{ $sale->disburshment_date ?? '' }}
                                                                @elseif ($sale instanceof App\Models\SaleOrder)
                                                                    {{ $sale->reg_date ?? '' }}
                                                                @elseif ($sale instanceof App\Models\CarLoan)
                                                                    {{ $sale->registration_year ?? '' }}
                                                                @else
                                                                    ---
                                                                @endif
                                                            </td>
                                                            </td>
                                                            <td>{{ preg_replace('/(?<!\s)([A-Z])/', ' $1', class_basename(get_class($sale))) }}
                                                            </td>
                                                            <td class="text-truncate">
                                                                <span style="white-space:nowrap;" class="">
                                                                    @if ($sale instanceof App\Models\SaleOrder)
                                                                        <a href="{{ route('admin.rc-transfer.sale-view', ['id' => $sale->id]) }}"
                                                                            class="btn btn-primary btn-sm" title="View">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('admin.rc-transfer.sale-show', ['id' => $sale->id]) }}"
                                                                            class="btn btn-success btn-sm" title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    @elseif ($sale instanceof App\Models\AggregatorLoan)
                                                                        <a href="{{ route('admin.rc-transfer.aggregrator-view', $sale->id) }}"
                                                                            class="btn btn-primary btn-sm" title="View">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('admin.rc-transfer.aggregrator-show', ['id' => $sale->id]) }}"
                                                                            class="btn btn-success btn-sm" title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    @elseif ($sale instanceof App\Models\CarLoan)
                                                                        <a href="{{ route('admin.rc-transfer.car-view', ['id' => $sale->id]) }}"
                                                                            class="btn btn-primary btn-sm" title="View">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('admin.rc-transfer.car-show', ['id' => $sale->id]) }}"
                                                                            class="btn btn-success btn-sm" title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @else
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5" style="text-align:center;">No data available
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endif
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
                $('#statusFilter').selectize();
                $('#sourceFilter').selectize();
                $('#executiveFilter').selectize();
                $('#partyFilter').selectize();
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
                        let date = moment(data[1],
                        'YYYY-MM-DD'); // Assuming the date is in the fourth column

                        if ((minDate === null || date >= minDate) && (maxDate === null || date <=
                                maxDate)) {
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
