@extends('admin.layouts.header')
@section('title', 'Stock Report')
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
                                            <h5 class="pt-2 pb-2">Stock Report</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.stock-report.index')}}" method="get">
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
                                                <th>Car</th>
                                                <th>Model</th>
                                                <th>Fuel</th>
                                                <th>Reg. No.</th>
                                                <th>Color</th>
                                                <th>KM</th>
                                                <th>Owners</th>
                                                <th>Ins</th>
                                                @if(Auth::guard('admin')->user()->role_id == 1)
                                                <th>Price</th>
                                                <th>Ref Cost</th>
                                                <th>Total</th>
                                                @endif
                                                <th>Selling Price</th>

                                                @if(Auth::guard('admin')->user()->role_id == 1)
                                                <th></th>
                                                @endif

                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($purchased as $value => $item)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{$item->brand ? ucfirst($item->brand->type) : '---'}}</td>
                                                <td>{{$item->carModel ? ucfirst($item->carModel->model) : '---'}}</td>
                                                <td>
                                                    @foreach (\App\Models\Purchase::getFuelType() as $key => $value)
                                                    @if($key == $item->fuel_type)
                                                    {{$value}}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{strtoupper($item->reg_number)}}</td>
                                                <td>{{$item->color ? ucfirst($item->color->color) : '---'}}</td>

                                                <td>{{$item->kilometer}}</td>
                                                <td>{{$item->owners}}</td>
                                                <td>{{date('d M, Y',strtotime($item->insurance_due_date))}}</td>
                                                @if(Auth::guard('admin')->user()->role_id == 1)
                                                <td>{{$item->purchaseOrder ? $item->purchaseOrder->price_p1 : '---'}}</td>

                                                <td>{{$item->refurbishment_sum_total_amount}}</td>

                                                <td>{{$item->purchaseOrder ? $item->purchaseOrder->price_p1 + $item->refurbishment_sum_total_amount : '---'}}</td>
                                                @endif

                                                <td>{{$item->selling_price ?? '---'}}</td>

                                                @if(Auth::guard('admin')->user()->role_id == 1)
                                                <td><i style="cursor: pointer;" data-id="{{$item->id}}" data-toggle="modal" data-target="#exampleModal" class="fa fa-edit"></i></td>
                                                @endif

                                                <td>
                                                    @if($item->pending_image_status == 0)
                                                    <a class="btn btn-sm btn-danger" href="{{route('admin.purchase.purchase.ready-sale-add-image', $item->id)}}">Pending Pics</a>
                                                    @else
                                                    <button class="btn btn-sm btn-success">IN STOCK</button>
                                                    @endif
                                                </td>

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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('admin.add.selling.price')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Selling Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="item_id" name="item_id">
                    <label class="mb-2" for="">Selling Price</label>
                    <input type="number" class="form-control" placeholder="Enter Selling Price" name="selling_price" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
        </form>
    </div>
</div>
</div>

@endsection
@push('scripts')

<script>
    $(document).ready(function() {

        $(document).on('click', '.fa-edit', function() {
            var itemId = $(this).data('id');
            $('#item_id').val(itemId);
        });


        $('#vehicleFilter').selectize();

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
</script>
@endpush
