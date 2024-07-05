@extends('admin.layouts.header')
@section('title', 'Term Insurance')
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
                                            <h5 class="pt-2 pb-2">Manage Term Insurance List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <!-- <a href="{{route('admin.general.insurance.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i>Add General Insurance</a> -->
                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('admin.term.insurance.index')}}" method="get">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Party Name</span>
                                                <input class="form-control" placeholder="Party Name" type="text" id="search" value="{{request()->query('party_name')}}" name="party_name">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Policy Number</span>
                                                <input class="form-control" placeholder="Policy Number" type="text" id="search" value="{{request()->query('policy_number')}}" name="policy_number">
                                            </div>
                                        </div>
                                        <div class="row col-sm-12 m-2">
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-success">Search</button>
                                                <button value="clear_search" name="clear_search" class="btn btn-danger">Clear search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card-body table-responsive">
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.term.insurance.index')}}" method="get">
                                            <div><label>Show
                                                    <select name="limit" aria-controls="all_quiz" class="form-control-sm" onChange="submit()">
                                                        @foreach(showEntries() as $limit)
                                                        <option value="{{ $limit }}" @if(request()->query('limit', 10) == $limit) selected @endif>{{ $limit }}</option>
                                                        @endforeach
                                                    </select> entries</label>
                                            </div>
                                        </form>
                                    </div>
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th>Party</th>
                                                <th>Policy Number</th>
                                                <th>Insurance Company</th>
                                                <th>Insurance To Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($termInsurances as $value => $item)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{$item->party ? ucfirst($item->party->party_name) : ''}}</td>
                                                <td>{{ucfirst($item->policy_number)}}</td>
                                                <td>{{$item->company ? ucfirst($item->company->name) : ''}}</td>
                                                <td>{{($item->insurance_to_date)}}</td>
                                                <td><span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.term.insurance.view', $item->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{route('admin.term.insurance.show', ['id' => $item->id, 'renewal' => true])}}" class="btn btn-secondary btn-sm" title="Renewal">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </span></td>
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
                text: 'Are you sure you want to delete the agent "' + colorName + '"?',
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