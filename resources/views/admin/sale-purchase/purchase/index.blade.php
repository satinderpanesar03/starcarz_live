    @extends('admin.layouts.header')

    @section('title', 'Purchase')
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
                                                <h5 class="pt-2 pb-2">Manage Purchase Enquiry List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                    <i class="fa fa-filter"></i> Filter </button>
                                                @if ($list)
                                                <a href="{{route('admin.purchase.purchase.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-plus"></i> Add Purchase Enquiry </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <form action="{{ route('admin.purchase.purchase.index') }}" id="search" method="get">
                                            <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                                <div class="row col-sm-12 ml-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="executiveFilter">Select Executive:</label>
                                                                <select class="form-control executive-filter" id="executiveFilter" name="executiveFilter">
                                                                    <option value="">Select Executive</option>
                                                                    @foreach($executives as $id => $executive)
                                                                    <option value="{{ $id }}">{{ $executive }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="partyFilter">Select Party:</label>
                                                                <select class="form-control party-filter" id="partyFilter" name="partyFilter">
                                                                    <option value="">Select Party</option>
                                                                    @foreach($party as $id => $model)
                                                                    <option value="{{ $id }}">{{ $model }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="modelFilter">Select Model:</label>
                                                                <select class="form-control model-filter" id="modelFilter" name="modelFilter">
                                                                    <option value="">Select Model</option>
                                                                    @foreach($models as $id => $model)
                                                                    <option value="{{ $id }}">{{ $model }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="statusFilter">Select Status:</label>
                                                                <select class="form-control status-filter" id="statusFilter" name="statusFilter">
                                                                    <option value="">Select Status</option>
                                                                    @foreach($status as $id => $model)
                                                                    <option value="{{ $id }}">{{ $model }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="fromDate">From Date:</label>
                                                                <input type="date" class="form-control" id="fromDate" name="fromDate">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="toDate">To Date:</label>
                                                                <input type="date" class="form-control" id="toDate" name="toDate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
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
                                            <form action="{{route('admin.purchase.purchase.index')}}" method="get">
                                                <div><label>Show
                                                        <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                            @foreach(showEntries() as $limit)
                                                            <option value="{{ $limit }}" @if(request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
                                                            @endforeach
                                                        </select> entries</label></div>
                                            </form>
                                        </div>
                                        <!-- <div class="card-body table-responsive">
                                            <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.purchase.enquiry.export',['extension' => 'xlsx']) }}'">Export to Excel</button>
                                            <button class="btn btn-secondary" onclick="window.location.href='{{ route('admin.purchase.enquiry.export',['extension' => 'csv']) }}'">Export to CSV</button>
                                        </div> -->
                                        <table class="table table-striped table-bordered dom-jQuery-events">
                                            <thead>
                                                <tr>
                                                    <th width="5%">ID</th>
                                                    <th>Party Name</th>
                                                    <th>Party Number</th>
                                                    <th>Executive Name</th>
                                                    <th>Car Model</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Manufacturing Year</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($purchases as $key => $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ($purchase->firm_name) ? $purchase->firm_name : '' }}</td>
                                                    <td>{{ $purchase->contact_number ?? '' }}</td>
                                                    <td>{{ ($purchase->executive) ? $purchase->executive->name : '' }}</td>
                                                    <td>{{ ($purchase->carModel) ? $purchase->carModel->model : '' }}</td>
                                                    <td>{{ strtoupper($purchase->reg_number) ?? ''}}</td>
                                                    <td>{{ $purchase->manufacturing_year ?? ''}}</td>
                                                    <td>{{ ($purchase->evaluation_date) ? date('d M, Y', strtotime($purchase->evaluation_date)) : '' }}</td>

                                                    <!-- <td>{{ ($purchase->getStatusName($purchase->status))}}</td> -->
                                                    <td>
                                                        @php
                                                        $statusClass = '';
                                                        switch($purchase->status) {
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
                                                        case 5:
                                                        $statusClass = 'badge-danger'; // Failed - Red
                                                        break;
                                                        case 6:
                                                        $statusClass = 'badge-primary'; // Failed - Red
                                                        break;
                                                        default:
                                                        $statusClass = 'badge-secondary'; // Default - Gray
                                                        }
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">{{ $purchase->getStatusName($purchase->status) }}</span>
                                                    </td>

                                                    <td class="text-truncatle">
                                                        <span style="white-space:nowrap;" class="">
                                                            <a href="{{ route('admin.purchase.purchase.view', $purchase->id) }}" class="btn btn-primary btn-sm" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.purchase.purchase.show', $purchase->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form id="partyForm" action="{{ route('admin.purchase.purchase.status', ['id' => $purchase->id, 'state_id' => $purchase->state_id]) }}" method="GET" style="display: inline;">
                                                                <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                    <input type="checkbox" @if($purchase->state_id == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
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
                                            {{$purchases->appends($_GET)->links()}}
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



    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit <span id="modalFieldName"></span></h5>
                </div>
                <div class="modal-body">
                    <form method="GET" id="updateForm" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="updateId" name="updateId" value="{{ !empty($purchase) ? $purchase->id : '' }}">
                            <div class="col-12 text-center">
                                <div class="form-group" id="expected_price_group">
                                    <label for="expected_price" class="common_label" style="margin-right: 73%;">Expected Price:</label>
                                    <input type="text" id="expected_price" class="form-control" name="expected_price">
                                </div>
                                <div class="form-group" id="valuation_group">
                                    <label for="valuation" class="common_label" style="margin-right: 81%;">Valuation:</label>
                                    <input type="text" id="valuation" class="form-control" name="valuation">
                                </div>
                                <div class="form-group" id="remarks_group">
                                    <label for="remarks" class="common_label" style="margin-right: 84%;">Remarks:</label>
                                    <input type="text" id="remarks" class="form-control" name="remarks">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary modal_submit">Save changes</button>
                </div>
            </div>
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
                $('#statusFilter').selectize();
                $('#executiveFilter').selectize();
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


            $('.modal_updated_value').on('click', function() {
                var field = $(this).data('field');
                var fieldName = $(this).data('field-name');
                $('#modalFieldName').text(fieldName);
                $('.form-group').hide();
                $('#' + field + '_group').show();
                $('#exampleModal').modal('show');
            });

            $('.modal_submit').click(function() {
                var id = $('#updateId').val();
                var expected_price = $('#expected_price').val();
                var valuation = $('#valuation').val();
                var remarks = $('#remarks').val();

                $.ajax({
                    url: '/update-data',
                    type: 'GET',
                    data: {
                        'id': id,
                        'expected_price': expected_price,
                        'valuation': valuation,
                        'remarks': remarks
                    },
                    success: function(response) {
                        console.log('Data updated successfully');
                        $('#exampleModal').modal('hide');

                        var updatedExpectedPrice = (expected_price) ? expected_price : '';
                        var updatedValuation = (valuation) ? valuation : '';
                        var updatedRemarks = (remarks) ? remarks : '';

                        if (updatedExpectedPrice !== '') {
                            $('#expected_price_edit').closest('td').html(updatedExpectedPrice + '<a id="expected_price_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="expected_price" data-field-name="Expected Price"><i class="fa fa-edit"></i></a>');
                        }
                        if (updatedValuation !== '') {
                            $('#valuation_edit').closest('td').html(updatedValuation + '<a id="valuation_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="valuation" data-field-name="Valuation"><i class="fa fa-edit"></i></a>');
                        }
                        if (updatedRemarks !== '') {
                            $('#remarks_edit').closest('td').html(updatedRemarks + '<a id="remarks_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="remarks" data-field-name="Remarks"><i class="fa fa-edit"></i></a>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating data:', error);
                    }
                });
            });
        });
    </script>
    @endpush
