@extends('admin.layouts.header')

@section('title', ($type == false) ? 'Insurances' : 'General Insurances')
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
                                            <h5 class="pt-2 pb-2">{{($type == false) ? 'Manage Insurances List' : 'Manage General Insurances List'}}</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-danger px-3 py-1 mr-2" id="listing-filter-toggle">
                                                <i class="fa fa-filter"></i> Filter </button>
                                            @if ($type == false)
                                            <a href="{{route('admin.insurance.add',$type)}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add Insurance </a>
                                            @else
                                            <a href="{{route('admin.insurance.general.create',$type)}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-plus"></i> Add General Insurance </a>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="row mb-2" id="listing-filter-data" data-select2-id="listing-filter-data" style="display:none;">
                                        <div class="row col-sm-12 ml-2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="executiveFilter">Select Executive:</label>
                                                        <select class="form-control executive-filter" id="executiveFilter">
                                                            <option value="">Select Executive</option>
                                                            @foreach($executives as $id => $executive)
                                                            <option value="{{ $executive }}">{{ $executive }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fromDate">From Date:</label>
                                                        <input type="date" class="form-control" id="fromDate">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="toDate">To Date:</label>
                                                        <input type="date" class="form-control" id="toDate">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <a class="btn btn-success">Search</a>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <a class="btn btn-danger">Clear search</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <form action="{{ $type ? route('admin.insurance.general.index',true) : route('admin.insurance.index')}}" method="get">
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
                                                <th>Firm Name</th>
                                                <th>Person Name</th>
                                                <th>Insurance</th>
                                                <th>Insurance Type</th>
                                                <th>Insured By</th>
                                                <th>Executive</th>
                                                <th>Insurance Done Date</th>
                                                <th>Company</th>
                                                <th>Broker</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($insurances as $value => $insurance)
                                            <tr>
                                                <td>{{++$value}}</td>
                                                <td>{{ucfirst($insurance->firm_name)}}</td>
                                                <td>{{ucfirst($insurance->person_name)}}</td>
                                                <td>{{$insurance->getInsuranceTypesName($insurance->insurance_id)}}</td>
                                                <td>{{ ($insurance->insuranceTypes->name)?$insurance->insuranceTypes->name:'' }}</td>
                                                <td>{{$insurance->getInsuredByName($insurance->insured_by)}}</td>
                                                <td>{{ ($insurance->executive->name)?$insurance->executive->name:'' }}</td>
                                                <td>{{ ($insurance->insurance_date) ? \Carbon\Carbon::parse($insurance->insurance_date)->format('Y-m-d'):'' }}</td>
                                                <td>{{ ($insurance->company->name)?$insurance->company->name:'' }}</td>
                                                <td>{{ ($insurance->broker->name)?$insurance->broker->name:'' }}</td>
                                                <td class="text-truncate">
                                                    <span style="white-space:nowrap;" class="">
                                                        <a href="#" class="btn btn-primary btn-sm" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{route('admin.insurance.show', ['id'=>$insurance->id, 'type'=>$type])}}" class="btn btn-success btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#">
                                                            <input type="checkbox" checked data-toggle="toggle" data-size="xs">
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
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
                        text: 'Are you sure you want to delete the insurance "' + colorName + '"?',
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

                if ($.fn.DataTable.isDataTable('#example')) {
                    var table = $('#example').DataTable();
                    $('.executive-filter').on('change', function() {
                        var executiveId = $(this).val();
                        table.column(6).search(executiveId).draw();
                        console.log('executiveId:', executiveId);
                    });

                    $('#fromDate, #toDate').on('change', function() {
                        let fromDate = $('#fromDate').val();
                        let toDate = $('#toDate').val();

                        // Convert date strings to moment objects
                        let minDate = fromDate ? moment(fromDate, 'YYYY-MM-DD') : null;
                        let maxDate = toDate ? moment(toDate, 'YYYY-MM-DD') : null;

                        // Custom filtering function
                        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                            let date = moment(data[7], 'YYYY-MM-DD'); // Assuming the date is in the fourth column

                            if ((minDate === null || date >= minDate) && (maxDate === null || date <= maxDate)) {
                                return true;
                            }
                            return false;
                        });

                        // Re-draw the DataTable to apply the filtering
                        table.draw();

                        // Remove the custom filtering function after drawing the table
                        $.fn.dataTable.ext.search.pop();
                    });
                }
            });
        </script>
        @endpush