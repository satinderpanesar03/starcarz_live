@extends('admin.layouts.header')

@section('title', 'Edit Demand Vehicle')
@section('content')
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="simple-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">Edit Demand Vehicle</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.demand.vehicle.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <form method="post" action="{{route('admin.demand.vehicle.update')}}">
                                            @csrf
                                            <input type="hidden" value="{{$vehicle->id}}" name="id" id="demand_party_id">
                                            <div class="modal-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-8 mb-3">
                                                        <label for="followup_date">Vehicle Name</label>
                                                        <input type="text" id="followup_date" name="vehicle[]" class="form-control" value="{{$vehicle->vehicle}}" data-role="tagsinput">
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="followup_date">Budget</label>

                                                        <select class="form-control" name="budget">
                                                            @foreach (\App\Models\Purchase::getBudget() as $value => $fuel)
                                                            <option value="{{$value}}" @if ($vehicle->budget == $value) selected @endif>{{$fuel}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="followup_date">Fuel Type</label>
                                                        <select class="form-control" name="fuel_type">
                                                            @foreach (\App\Models\Purchase::getFuelType() as $value => $fuel)
                                                            <option value="{{$value}}" @if ($vehicle->fuel_type == $value) selected @endif>{{$fuel}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="margin-left: 18%;">Save</button>
                                        </form>
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