@extends('admin.layouts.header')

@section('title', 'File Uploads')
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
                                            <h5 class="pt-2 pb-2">Manage Uploads List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <!-- <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button> -->
                                            <a href="{{route('admin.master.upload.file.add')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Upload File </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive">
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.master.upload.file.index')}}" method="get">
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
                                                <th>Filename</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($uploads as $value => $upload)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ucfirst($upload->filename)}}</td>
                                                <td class="text-truncate">
                                                    <a href="{{route('admin.master.upload.file.download', $upload->file_path)}}" class="success p-0">
                                                        <i class="fa fa-download" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$uploads->appends($_GET)->links()}}
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
                $('.delete-color').click(function(event) {
                    event.preventDefault(); // Prevent the default action of the link
                    var deleteUrl = $(this).attr('href');
                    var colorName = $(this).data('color');

                    // Display SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: 'Are you sure you want to delete the supplier "' + colorName + '"?',
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