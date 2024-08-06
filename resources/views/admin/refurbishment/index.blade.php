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
                                            <h5 class="pt-2 pb-2">Manage Refurbishment List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.refurbishment.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Refurbishment </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.refurbishment.index')}}" method="get">
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
                                        <form action="{{route('admin.refurbishment.index')}}" method="get">
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
                                                <th>Date</th>
                                                <!-- <th>Party Name</th> -->
                                                <th>Vehicle number</th>
                                                <th>Ref Total Amount</th>
                                                <th>Ref EST Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($refurbishments as $value => $refurbishment)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{$refurbishment->date ? strtoupper($refurbishment->date) : ''}}</td>
                                                <!-- <td>{{$refurbishment->party ? ucfirst($refurbishment->party->party_name) : ''}}</td> -->
                                                <td>{{$refurbishment->purchase ? strtoupper($refurbishment->purchase->reg_number) : ''}}</td>
                                                <td>{{$refurbishment->total_amount ? ($refurbishment->total_amount +$totalAmount) : ''}}</td>
                                                <td>{{$refurbishment->total_amount}}</td>
                                                <td class="text-truncatle">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.refurbishment.view', $refurbishment->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{route('admin.refurbishment.show', $refurbishment->id)}}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
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
</script>
@endpush
