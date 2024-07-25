    @extends('admin.layouts.header')

    @section('title', 'Purchase Order')
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
                                                <h5 class="pt-2 pb-2">Manage Purchase Register List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                    <i class="fa fa-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <form action="{{ route('admin.purchase.purchase.orders') }}" method="get">
                                            <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                                <div class="row col-sm-12 ml-2">
                                                    <div class="col-sm-3">
                                                        <span class="text">Select Mode</span>
                                                        <select class="form-control" name="status" id="statusFilter">
                                                            <option value="" selected disabled>Choose...</option>
                                                            <option value="6">Purchased</option>
                                                            <option value="7">Park and Sale</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <span class="text">Enter Party Name</span>
                                                        <select class="form-control" name="party_id" id="party_id">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{ $party->party_name }}">{{ $party->party_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <span class="text">Enter Car Number</span>
                                                        <input type="text" id="carFilter" name="car_number" class="form-control" value="{{ request()->query('car_number') ?? '' }}" placeholder="Car Number">
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
                                            <form action="{{ route('admin.purchase.purchase.orders') }}" method="get">
                                                <div>
                                                    <label>Show
                                                        <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                            @foreach (showEntries() as $limit)
                                                            <option value="{{ $limit }}" @if (request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
                                                            @endforeach
                                                        </select> entries
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                        <table class="table table-striped table-bordered dom-jQuery-events">
                                            <thead>
                                                <tr>
                                                    <th width="5%">ID</th>
                                                    <th>Party</th>
                                                    <th>Vehicle No.</th>
                                                    <th>Price</th>
                                                    <th>Contact</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($purchases as $key => $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $purchase->party ? $purchase->party->party_name : '' }}</td>
                                                    <td>{{ $purchase->purchase ? $purchase->purchase->reg_number : '' }}</td>
                                                    <td>{{ $purchase->price_p1 ? $purchase->price_p1 : '' }}</td>
                                                    <td>
                                                        @if ($purchase->party)
                                                        @foreach ($purchase->party->partyContact ?? [] as $contact)
                                                        @if ($contact->type == 1)
                                                        {{ $contact->number }}
                                                        @break
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                        $statusClass = '';
                                                        switch ($purchase->status) {
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
                                                    <td class="text-truncate">
                                                        <span style="white-space:nowrap;" class="">
                                                            <a href="{{ route('admin.purchase.purchase.view-order', $purchase->id) }}" class="btn btn-primary btn-sm" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @if(in_array(1, $roleNames))
                                                            <a href="{{ route('admin.purchase.purchase.showOrder', $purchase->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="container d-flex justify-content-end">
                                            {{ $purchases->appends($_GET)->links() }}
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
                    $('#party_id').selectize();
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
                                $('#expected_price_edit').closest('td').html(updatedExpectedPrice +
                                    '<a id="expected_price_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="expected_price" data-field-name="Expected Price"><i class="fa fa-edit"></i></a>'
                                );
                            }
                            if (updatedValuation !== '') {
                                $('#valuation_edit').closest('td').html(updatedValuation +
                                    '<a id="valuation_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="valuation" data-field-name="Valuation"><i class="fa fa-edit"></i></a>'
                                );
                            }
                            if (updatedRemarks !== '') {
                                $('#remarks_edit').closest('td').html(updatedRemarks +
                                    '<a id="remarks_edit" class="modal_updated_value" data-toggle="modal" data-target="#exampleModal" data-field="remarks" data-field-name="Remarks"><i class="fa fa-edit"></i></a>'
                                );
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
