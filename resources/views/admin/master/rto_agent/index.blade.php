@extends('admin.layouts.header')

@section('title', 'Rto Agents')
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
                                            <h5 class="pt-2 pb-2">Manage Agents List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.master.rto.agent.add')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Agent </a>

                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('admin.master.rto.agent.index')}}" method="get">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Agent Name</span>
                                                <input class="form-control" placeholder="Party Name" type="text" id="search" value="{{request()->query('agent_name')}}" name="agent_name">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Email</span>
                                                <input class="form-control" placeholder="Firm Name" type="text" id="search" value="{{request()->query('email')}}" name="email">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Phone Number</span>
                                                <input class="form-control" placeholder="Phone Number" type="number" value="{{request()->query('phone_number')}}" id="phone" name="phone_number">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Location</span>
                                                <input class="form-control" placeholder="City" type="text" id="search" value="{{request()->query('location')}}" name="location">
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
                                        <form action="{{route('admin.master.rto.agent.index')}}" method="get">
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
                                                <th>Agent</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($agents as $value => $agent)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ucfirst($agent->agent)}}</td>
                                                <td>{{$agent->email}}</td>
                                                <td>{{$agent->phone_number}}</td>
                                                <td>{{$agent->location}}</td>
                                                <td>
                                                <div class="row justify-content-center">
                                                    <div class="mr-1">
                                                        <a href="{{route('admin.master.rto.agent.view',$agent->id)}}" class="btn btn-primary btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                    <div class="mr-1">
                                                        <a href="{{route('admin.master.rto.agent.show', $agent->id)}}" class="btn btn-success btn-sm" title="View"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <div>
                                                        <form id="agentForm" action="{{ route('admin.master.rto.agent.status', ['id' => $agent->id, 'status' => $agent->status]) }}" method="GET">
                                                            <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                <input type="checkbox" @if($agent->status == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
                                                            </a>
                                                        </form>
                                                    </div>
                                                    <div></div>
                                                </div>

                                            </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$agents->appends($_GET)->links()}}
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