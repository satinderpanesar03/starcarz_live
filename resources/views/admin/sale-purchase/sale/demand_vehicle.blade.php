@extends('admin.layouts.header')

@section('title', 'Demand Vehicle')
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
                                            <h5 class="pt-2 pb-2">Manage Demand Vehicle</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- form -->
                                <form action="{{route('admin.demand.vehicle.index')}}" method="get">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="col-sm-3">
                                                <span class="text">Enter Party Name</span>
                                                <input class="form-control" placeholder="Party Name" type="text" id="search" value="{{request()->query('party_name')}}" name="party_name">
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
                                <!-- form end -->


                                <div class="card-body table-responsive">
                                    <div class="card-body table-responsive">
                                        <form action="{{route('admin.master.article.index')}}" method="get">
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
                                                <th>Vehicle</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach ($vehicles as $value => $vehicle)
                                             <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{$vehicle->party ? ucfirst($vehicle->party->party_name) : ''}}</td>
                                                <td>
                                                    @foreach(explode(',',$vehicle->vehicle) as $i)
                                                        {{ucfirst($i)}}
                                                    @break
                                                    @endforeach
                                                </td>
                                                <td class="text-truncatle">
                                                        <span style="white-space:nowrap;" class="">
                                                            <a href="{{route('admin.demand.vehicle.view', $vehicle->id)}}" class="btn btn-primary btn-sm" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{route('admin.demand.vehicle.edit', $vehicle->id)}}" class="btn btn-success btn-sm" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </span>
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

        @endsection
        @push('scripts')

        <script>
            $(document).ready(function() {

                $('#listing-filter-toggle').click(function() {
                    $('#listing-filter-data').toggle();
                });
            });
        </script>
        @endpush