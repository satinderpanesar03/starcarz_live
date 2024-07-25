@extends('admin.layouts.header')

@section('title', 'Sale Order')
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
                                            <h5 class="pt-2 pb-2">Manage Sale Register List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            @if ($type)
                                            {{-- <a href="{{route('admin.sale.sale.order-create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Sale Order </a> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.sale.sale.order-index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
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
                                        <form action="{{route('admin.sale.sale.order-index')}}" method="get">
                                            <div>
                                                <label>Show
                                                    <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                        @foreach(showEntries() as $limit)
                                                        <option value="{{ $limit }}" @if(request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
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
                                                <th>Whatsapp</th>
                                                <th>Model</th>
                                                <th>Vehicle</th>
                                                <th>Executive</th>
                                                <th>Sale Price</th>
                                                <th>Delivery date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($saleOrders as $value => $sale)
                                            <tr>
                                                <td>{{$saleOrders->firstItem() + $value}}</td>
                                                <td>{{ ($sale->party) ? $sale->party->party_name : '' }}</td>
                                                <td>
                                                    @if($sale->party)
                                                    @foreach ($sale->party->partyContact as $contact)
                                                    @if ($contact->type == 1)
                                                    {{ $contact->number }}
                                                    @break
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ ($sale->party) ? $sale->party->party_name : '' }}</td>
                                                <td>{{ ($sale->purchase) ? strtoupper($sale->purchase->reg_number) : ''}}</td>
                                                <td>{{ ($sale->executive) ? $sale->executive->name : '' }}</td>
                                                <td>{{ ($sale->price_p1) ? $sale->price_p1 : '' }}</td>
                                                <td>{{ date('d M Y',strtotime($sale->date_of_sale)) }}</td>

                                                <td class="text-truncate">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.sale.sale.order-view', $sale->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if(in_array(1, $roleNames))
                                                        <a href="{{route('admin.sale.sale.order-show', $sale->id)}}" class="btn btn-success btn-sm" title="Edit">
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
                                        {{$saleOrders->appends($_GET)->links()}}
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
    });
</script>
@endpush
