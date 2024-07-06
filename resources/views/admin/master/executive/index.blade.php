@extends('admin.layouts.header')

@section('title', 'Executives')
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
                                            <h5 class="pt-2 pb-2">Manage Executive List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.master.executive.add')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Executive </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('admin.master.executive.index')}}" method="get">
                                        <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                            <div class="row col-sm-12 ml-2">
                                                <div class="col-sm-3">
                                                    <span class="text">Enter Executive</span>
                                                    <input class="form-control" placeholder="Executive Name" type="text" id="search" name="name" value="{{request()->query('name') ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-8 mt-2 ml-3">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-success">Search</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button value="clear_search" name="clear_search" class="btn btn-danger">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.master.executive.index')}}" method="get">
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
                                                <th>Source By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($executives as $value => $executive)
                                            <tr @if ($executive->admin_login_id != 0) style="background-color: #bec6c9" @endif>
                                                <td>{{++$value}}</td>
                                                <td>{{ucfirst($executive->name)}}</td>
                                                <td class="text-truncate">
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <a href="{{ route('admin.master.executive.view', $executive->id) }}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.master.executive.show', $executive->id) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.master.executive.status', [$executive->id, (int)$executive->status]) }}" method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="checkbox" @checked($executive->status) onchange="this.form.submit()" data-toggle="toggle" data-size="xs">
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$executives->appends($_GET)->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
