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
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">Ready For Sale List</h5>
                                        </div>
                                        <!-- <div class="row">
                                            
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                    <i class="fa fa-filter"></i> Filter </button>
                                                <a href="{{route('admin.purchase.purchase.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-plus"></i> Add Purchase Enquiry </a>

                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="card-body table-responsive">
                                        <div class="card-body table-responsive">
                                            <form action="{{route('admin.purchase.purchase.ready-sale-index')}}" method="get">
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
                                                    <th>Car</th>
                                                    <th>Model</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(! empty($purchases))
                                                @forelse($purchases as $key => $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ($purchase->brand) ? $purchase->brand->type : '' }}</td>
                                                    <td>{{ ($purchase->carModel) ? $purchase->carModel->model : '' }}</td>
                                                    <td>{{ strtoupper($purchase->reg_number) ?? '' }}</td>

                                                    <td class="text-truncatle">
                                                        <span style="white-space:nowrap;" class="">
                                                            <a href="{{ route('admin.purchase.purchase.ready-sale-add-image', $purchase->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </td>

                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                            @else
                                            <tbody>
                                                <tr>
                                                    <td colspan="7" style="text-align:center;">No data available</td>
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
            $('#vehicleFilter').selectize();
            $('#modelFilter').selectize();
            $('#brandFilter').selectize();
            $('#listing-filter-toggle').click(function() {
                $('#listing-filter-data').toggle();
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