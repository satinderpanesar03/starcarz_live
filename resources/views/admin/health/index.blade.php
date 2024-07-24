@extends('admin.layouts.header')

@section('title', 'Health Insurance')
@section('content')
<?php
use Illuminate\Support\Facades\Crypt;
$encryptedQuery = Crypt::encrypt(request()->query());
?>
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
                                            <h5 class="pt-2 pb-2">Manage Health Insurance List</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            <a href="{{route('admin.health.create')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i>Add Health Insurance</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('admin.health.index')}}" method="get">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Party Name</span>
                                                <select class="form-control" name="party_name" id="party_id">
                                                            <option value=""  selected disabled >Choose...</option>
                                                        @foreach ($parties as $party)
                                                            <option value="{{$party->party_name}}">{{$party->party_name}}</option>
                                                        @endforeach
                                                        </select>
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
                                        <form action="{{route('admin.health.index')}}" method="get">
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
                                                <th>Whatsapp</th>
                                                <th>Executive</th>
                                                <th>Type</th>
                                                <th>End Date</th>
                                                <th>T. Prm.</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($insurances as $value => $insurance)
                                                <tr>
                                                    <td>{{$insurances->firstItem() + $value}}</td>
                                                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        <a style="color: inherit; font-size: 12px;" href="{{ route('admin.master.party.view', $insurance->party->id) }}">
                                                            {{ $insurance->party ? ucfirst($insurance->party->party_name) : '' }}
                                                        </a>
                                                    </td>
                                                    <td>{{$insurance->party->partyWhatsapp ? ($insurance->party->partyWhatsapp->number ? $insurance->party->partyWhatsapp->number : '--') : '--'}}</td>
                                                    <td style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $insurance->executive ? ucfirst($insurance->executive->name) : '' }}
                                                    </td>
                                                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $insurance->type ? $insurance->type->name : '' }}
                                                    </td>
                                                    <td>{{date('d/m/Y',strtotime($insurance->end_date))}}</td>
                                                    <td>{{ number_format($insurance->gross_premium, 2) }}</td>
                                                    <td>
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="{{route('admin.health.view', $insurance->id)}}" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.health.show', [$insurance->id, 'q' => $encryptedQuery  ]) }}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <div class="container d-flex justify-content-end">
                                        {{$insurances->appends($_GET)->links()}}
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
