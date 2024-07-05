@extends('admin.layouts.header')

@section('title', 'Party')
@section('content')
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <!--Extended Table starts-->
            <section id="positioning">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">

                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">Manage Parties List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.master.party.add')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Party </a>

                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('admin.master.party.index')}}" method="get">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Party Name</span>
                                                <input class="form-control" placeholder="Party Name" type="text" id="search" value="{{request()->query('party_name')}}" name="party_name">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Firm Name</span>
                                                <input class="form-control" placeholder="Firm Name" type="text" id="search" value="{{request()->query('firm_name')}}" name="firm_name">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter Phone Number</span>
                                                <input class="form-control" placeholder="Phone Number" type="number" id="phone" name="phone_number">
                                            </div>

                                            <div class="col-sm-3">
                                                <span class="text">Enter City</span>
                                                <input class="form-control" placeholder="City" type="text" id="search" value="{{request()->query('city')}}" name="city">
                                            </div>
                                        </div>
                                        <div class="row col-sm-12 ml-2 mt-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Email</span>
                                                <input class="form-control" placeholder="Email" type="text" value="{{request()->query('email')}}" id="search" name="email">
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
                                <!-- table -->
                                <div class="card-body table-responsive">
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.master.party.index')}}" method="get">
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
                                                <th>Party Name</th>
                                                <th>Email</th>
                                                <th>Whatsapp Number</th>
                                                <th>Residence City</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($parties as $value => $party)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ucfirst($party->party_name)}}</td>
                                                <td>{{$party->email}}</td>
                                                <td>
                                                    @foreach ($party->partyContact as $contact)
                                                    @if ($contact->type == 1)
                                                    {{ $contact->number }}
                                                    @break
                                                    @endif
                                                    @endforeach

                                                </td>
                                                <td>{{ucfirst($party->residence_city)}}</td>

                                                <td><span style="white-space:nowrap;" class="">
                                                        <a href="{{ route('admin.master.party.view', $party->id) }}" class="btn btn-primary btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('admin.master.party.show', $party->id) }}" class="btn btn-success btn-sm" title="View"><i class="fa fa-edit"></i></a>
                                                        <form id="partyForm" action="{{ route('admin.master.party.status', ['id' => $party->id, 'status' => $party->status]) }}" method="GET" style="display: inline;">
                                                            <a onclick="document.getElementById('partyForm').submit(); return false;">
                                                                <input type="checkbox" @if($party->status == 1) checked @endif data-toggle="toggle" data-size="xs" onchange="this.closest('form').submit()">
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
                                        {{$parties->appends($_GET)->links()}}
                                    </div>
                                </div>
                                <!-- table ends -->
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
                title: 'Confirm',
                text: 'Are you sure you want to change the status of party "' + colorName + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it'
            }).then((result) => {
                // If user confirms deletion, redirect to the delete URL
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    $(document).ready(function() {
        $('#clear_search').on('click', function() {
            window.location.href = "{{route('admin.master.party.index')}}";
        });
    });
</script>


@endpush