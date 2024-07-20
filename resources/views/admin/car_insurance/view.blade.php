@extends('admin.layouts.header')
@section('title','View Car Insurance')
@section('content')

<head>
    <!-- Other head elements -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

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
                                            <h5 class="pt-2 pb-2">View Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="#" class="btn btn-sm btn-primary px-3 py-1" onclick="window.history.back();">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                @csrf
                                                <input type="hidden" name="purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">


                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_executive_id">Party</label>
                                                        <select disabled name="mst_executive_id" id="mst_party_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{$party->id}}" {{ isset($insurance->id) && $insurance->party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-4 mt-2">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" readonly>
                                                    </div> -->

                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Executive:</label>
                                                        <select disabled name="party_id" id="mst_executive_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->mst_executive_id == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="vehicle_type">Select Vehicle Type</label>
                                                        <select disabled name="vehicle_type" id="vehicle_type" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::vehicleType() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->vehicle_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="mst_brand_type_id">Select Insurance Type:</label>
                                                        <select disabled name="od_type_insurance" id="od_type_insurance" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::odType() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->vehicle_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <label for="vehicle_number">Select Vehicle</label>
                                                        <select disabled name="vehicle_number" id="vehicle_number" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($insurance->id) && $insurance->vehicle_number_input == $vehicle->reg_number ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="brand">Vehicle Make:</label>
                                                        <select name="brand" id="brand" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($brands as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->brand == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="colorType">Vehicle Model:</label>
                                                        <select name="color" id="colorType" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($models as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->color == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3"> -->
                                                    <!-- <label for="mst_brand_type_id">Vehicle Number:</label> -->
                                                    <input class="form-control" type="hidden" name="vehicle_number_input" id="vehicle_number_input" value="@if(isset($insurance)) {{$insurance->vehicle_number_input}} @endif" readonly>
                                                    <!-- </div> -->
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Select Brand & Car</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($insurance->id) && $insurance->vehicle_number == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($insurance)) {{$insurance->manufacturing_year}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Date of Registration:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if(isset($insurance)) {{$insurance->registration_year}} @endif" readonly>
                                                    </div>
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners" name="owners" class="form-control" value="@if(isset($insurance)) {{$insurance->owners}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <input type="text" id="fuel_type" name="fuel_type" class="form-control" value="@if(isset($insurance)) {{$insurance->fuel_type}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <input type="text" id="shape_type" name="shape_type" class="form-control" value="@if(isset($insurance)) {{$insurance->shape_type}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="engine_number">Engine Number:</label>
                                                        <input type="text" id="engine_number" name="engine_number" class="form-control" value="@if(isset($insurance)) {{$insurance->engine_number}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="chasis_number">Chasis Number:</label>
                                                        <input type="text" id="chasis_number" name="chassis_number" class="form-control" value="@if(isset($insurance)) {{$insurance->chassis_number}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="service_booklet">Service Booklet:</label>
                                                        <input type="text" id="service_booklet" name="service_booklet" class="form-control" value="@if(isset($insurance)) {{$insurance->service_booklet}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <input class="form-control" type="text" name="color" id="color" value="@if(isset($insurance)) {{$insurance->color}} @endif" readonly>
                                                    </div>

                                                </div> -->

                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="vehicle_number">Insurance Done By:</label>
                                                        <select disabled name="vehicle_number" id="vehicle_number" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::InsuranceBy() as $value => $item)
                                                            <option @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif value="{{$value}}">{{$item}}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="brand" value="{{$insurance->insurance_done_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="brand" value="{{$insurance->insurance_from_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="brand" value="{{$insurance->insurance_to_date ?? ''}}" readonly>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Company:</label>
                                                        <select disabled name="insurance_company" id="vehicle_number" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_company as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="sum_insured">Sum Insured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="brand" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Third Party Premium:</label>
                                                        <input class="form-control" type="number" name="third_party_premium" id="third_party_premium" value="{{$insurance->third_party_premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="brand" value="{{$insurance->gst ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Total:</label>
                                                        <input class="form-control" type="number" name="total" id="total" value="{{number_format($insurance->total, 2) ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="number" name="policy_number" id="brand" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4" readonly>@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="@if(isset($insurance)) {{$insurance->insurance_documents}} @endif" name="insurance_documents_edit">
                                                <hr style="border: #2A3F54 1px solid;">

                                                <div class="col-sm-12" id="insuranace_type_radio" @if ($case=='add' ) style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Normal:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="normal_pending" name="normal" value="Pending" {{ isset($insurance) && $insurance->normal == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="normal_pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="normal_received" name="normal" value="Received" {{ isset($insurance) && $insurance->normal == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="normal_received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="normal_na" name="normal" value="NA" {{ isset($insurance) && $insurance->normal == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="normal_na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Zero dep:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="zero_dep" value="Pending" {{ isset($insurance) && $insurance->zero_dep  == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="zero_dep" value="Received" {{ isset($insurance) && $insurance->zero_dep == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="zero_dep" value="NA" {{ isset($insurance) && $insurance->zero_dep == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Consumables:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="consumables" value="Pending" {{ isset($insurance) && $insurance->consumables == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="consumables" value="Received" {{ isset($insurance) && $insurance->consumables == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="consumables" value="NA" {{ isset($insurance) && $insurance->consumables == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Engine:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="engine" value="Pending" {{ isset($insurance) && $insurance->engine == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="engine" value="Received" {{ isset($insurance) && $insurance->engine == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="engine" value="NA" {{ isset($insurance) && $insurance->engine == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Tyre:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="tyre" value="Pending" {{ isset($insurance) && $insurance->tyre == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="tyre" value="Received" {{ isset($insurance) && $insurance->tyre == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="tyre" value="NA" {{ isset($insurance) && $insurance->tyre == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Rti:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="rti" value="Pending" {{ isset($insurance) && $insurance->rti == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="rti" value="Received" {{ isset($insurance) && $insurance->rti == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="rti" value="NA" {{ isset($insurance) && $insurance->rti == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Ncb protection:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="ncb_protection" value="Pending" {{ isset($insurance) && $insurance->ncb_protection == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="ncb_protection" value="Received" {{ isset($insurance) && $insurance->ncb_protection == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="ncb_protection" value="NA" {{ isset($insurance) && $insurance->ncb_protection == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Key:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="key" value="Pending" {{ isset($insurance) && $insurance->key == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="key" value="Received" {{ isset($insurance) && $insurance->key == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="key" value="NA" {{ isset($insurance) && $insurance->key == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Rsa:</label>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="pending" name="rsa" value="Pending" {{ isset($insurance) && $insurance->rsa == 'Pending' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="received" name="rsa" value="Received" {{ isset($insurance) && $insurance->rsa == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="received"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" id="na" name="rsa" value="NA" {{ isset($insurance) && $insurance->rsa == 'NA' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                            </div>
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <label for="lob" class="col-sm-5 col-form-label font-weight-bold">Lob:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="lob" name="lob" value="Received" {{ isset($insurance) && $insurance->lob == 'Received' ? 'checked' : '' }} disabled>
                                                                <label class="form-check-label font-weight-bold" for="lob"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
    $(document).ready(() => {
        $('select').selectize();
        $('#example').DataTable({
            // data: name,
            deferRender: true,
            // scrollY:        200,
            scrollCollapse: true,
            scroller: true,
            info: false,
            "bPaginate": false
        });
    });

    $(document).ready(function() {
        $('#mst_party_id').change(function(e) {
            $('#mst_party_id').val($(this).val());
            var partyId = this.value;

            $.ajax({
                url: '/fetch-data',
                type: 'GET',
                data: {
                    party_id: partyId
                },
                success: function(response) {
                    console.log(response);
                    $('#registered_owner').val(response.party_name);
                    $('#email').val(response.email);
                    $('#contact_number').val(response.office_number);
                    $('#address').val(response.office_address);
                    $('#city').val(response.residence_city);
                    $('#contact_number').val(response.contact_number);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#mst_party_id').trigger('change');
    });

    $(document).ready(function() {
        $('#mode').change(function(e) {
            $('#mode').val($(this).val());
            var mode = this.value;

            if (mode) {
                $.ajax({
                    url: '/fetch-status',
                    type: 'GET',
                    data: {
                        mode: mode
                    },
                    success: function(data) {
                        console.log(data);
                        $('#vehicle_number').html('<option value="">Select Vehicle</option>');
                        $.each(data, function(key, value) {
                            $('#vehicle_number').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#vehicle_number').html('<option value="">Select Vehicle</option>');
            }

        });

    });

    $(document).ready(function() {
        $('#vehicle_number').change(function(e) {
            $('#vehicle_number').val($(this).val());
            var vehicle = this.value;

            $.ajax({
                url: '/fetch-vehicles',
                type: 'GET',
                data: {
                    vehicle: vehicle
                },
                success: function(response) {
                    $('#vehicle_number_input').val(response.vehicle_number);
                    $('#brand').val(response.brand);
                    $('#color').val(response.color);
                    $('#model').val(response.model);
                    $('#manufacturing_year').val(response.manufacturing_year);
                    $('#registration_year').val(response.registration_year);
                    $('#kilometer').val(response.kilometer);
                    $('#expectation').val(response.expectation);
                    $('#owners').val(response.owners);
                    $('#fuel_type').val(response.fuel_type);
                    $('#shape_type').val(response.shape_type);
                    $('#engine_number').val(response.engine_number);
                    $('#chasis_number').val(response.chasis_number);
                    $('#service_booklet').val(response.service_booklet);
                    $('#date_of_purchase').val(response.date_of_purchase);
                    $('#purchase_id').val(response.purchase_id);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number').trigger('change');
    });

    $(document).ready(function() {
        $('input[type="number"]').on('keyup', function() {
            calculateTotal();
        });

        function calculateTotal() {
            var serviceAndOilChangeAmount = parseFloat($('#service_and_oil_change_amount').val()) || 0;
            var compoundAndDryCleanAmount = parseFloat($('#compound_and_dry_clean_amount').val()) || 0;
            var paintAndDentingAmount = parseFloat($('#paint_and_denting_amount').val()) || 0;
            var electricalAndElectronicsAmount = parseFloat($('#electrical_and_electronics_amount').val()) || 0;
            var engineCompartmentAmount = parseFloat($('#engine_compartment_amount').val()) || 0;
            var accessoriesAmount = parseFloat($('#accessories_amount').val()) || 0;
            var othersAmount = parseFloat($('#others_amount').val()) || 0;

            var totalAmount = serviceAndOilChangeAmount + compoundAndDryCleanAmount + paintAndDentingAmount + electricalAndElectronicsAmount + engineCompartmentAmount + accessoriesAmount + othersAmount;

            $('#total_amount').val(totalAmount.toFixed(2));
        }
    });
</script>
@endpush
