@extends('admin.layouts.header')
@section('title', isset($insurance->id) ? 'Edit Car Insurance' : 'Add Car Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif Car Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.car.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.car.insurance.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">

                                                    @if (!empty($renewal) && $renewal == 1)
                                                    <input type="hidden" name="renewal" value="true">
                                                    @endif
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_executive_id">Party</label>
                                                        <select name="party_id" id="mst_party_id" class="form-control" required>
                                                            <option value="">Search By Name/Number</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($carLoan->mst_party_id) && $carLoan->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }}

                                                                @if ($party['father_name'])
                                                                    S/O <span style="color: green;">{{ ucfirst($party['father_name']) }}</span>
                                                                @endif

                                                                @if ($party['contacts'])
                                                                ({{ $party['contacts'] }})
                                                                @endif

                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div data-toggle="modal" data-target="#addParty" class="input-group-append">
                                                            <button class="btn btn-outline-primary btn-field-height" type="button">+</button>
                                                        </div>
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
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control">
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
                                                        <select name="vehicle_type" id="vehicle_type" class="form-control" required>
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::vehicleType() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->vehicle_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="mst_brand_type_id">Select Sub Type:</label>
                                                        <select name="od_type_insurance" id="od_type_insurance" class="form-control" required>
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::odType() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->vehicle_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="sub_model">Enter Sub Model:</label>
                                                        <input type="text" id="sub_model" name="sub_model" class="form-control" value="@if(isset($insurance)) {{$insurance->sub_model}} @endif">
                                                    </div>


                                                </div>

                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <label for="colorType">Vehicle Model:</label>
                                                        <select name="color" id="od_type_insurance" class="form-control" required>
                                                            <option value="">Choose...</option>
                                                            @foreach ($models as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->color == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Vehicle Number:</label>
                                                        <input type="text" id="vehicle_number" name="vehicle_number" class="form-control" value="@if(isset($insurance)) {{$insurance->vehicle_number}} @endif">
                                                    </div>

                                                    <!-- <div class="col-md-3"> -->
                                                    <!-- <label for="mst_brand_type_id">Vehicle Number:</label> -->
                                                    <input class="form-control" type="hidden" name="vehicle_number_input" id="vehicle_number_input" value="@if(isset($insurance)) {{$insurance->vehicle_number_input}} @endif" readonly>
                                                    <!-- </div> -->
                                                    <!-- <div class="col-md-3">
                                                        <label for="vehicle_number">Select Brand & Car</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($insurance->id) && $insurance->vehicle_number == $vehicle->reg_number ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($insurance)) {{$insurance->manufacturing_year}} @endif">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="registration_year">Date of Registration:</label>
                                                        <input type="date" id="registration_year" name="registration_year" class="form-control" value="@if(isset($insurance)) {{$insurance->registration_year}} @endif">
                                                    </div>

                                                </div>

                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_company">Insurance Done By:</label>
                                                        <select name="insurance_company1" id="insurance_company" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::InsuranceBy() as $value => $item)
                                                            <option @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif value="{{$value}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="insurance_done_date" value="{{$insurance->insurance_done_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="insurance_from_date" value="{{$insurance->insurance_from_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="insurance_to_date" value="{{$insurance->insurance_to_date ?? ''}}" required>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Company:</label>
                                                        <select name="insurance_company" id="insurance_company" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_company as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="sum_insured">Sum Insured:</label>
                                                        <input class="form-control" type="number" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">OD Premium:</label>
                                                        <input class="form-control" type="number" name="premium" id="premium" value="{{$insurance->premium ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Third Party Premium:</label>
                                                        <input class="form-control" type="number" name="third_party_premium" id="third_party_premium" value="{{$insurance->third_party_premium ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="gst" value="{{$insurance->gst ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Total:</label>
                                                        <input class="form-control" type="number" name="total" id="total" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="policy_number" value="{{$insurance->policy_number ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Document:</label>
                                                        <input class="form-control" type="file" name="insurance_documents" id="insurance_documents">
                                                        @if(isset($insurance->insurance_documents))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $insurance->insurance_documents) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['car_insurances',$insurance->id,'insurance_documents'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="ncb">NCB:</label>
                                                        <input type="text" id="ncb" name="ncb" class="form-control" value="@if(isset($insurance)) {{$insurance->ncb}} @endif">
                                                    </div>

                                                    <div class="col-md-6 mt-3">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4">@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
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
                                                                <input class="form-check-input" type="checkbox" id="normal_received" name="normal" value="Received" {{ isset($insurance) && $insurance->normal == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="zero_dep" value="Received" {{ isset($insurance) && $insurance->zero_dep == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="consumables" value="Received" {{ isset($insurance) && $insurance->consumables == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="engine" value="Received" {{ isset($insurance) && $insurance->engine == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="tyre" value="Received" {{ isset($insurance) && $insurance->tyre == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="rti" value="Received" {{ isset($insurance) && $insurance->rti == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="ncb_protection" value="Received" {{ isset($insurance) && $insurance->ncb_protection == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="key" value="Received" {{ isset($insurance) && $insurance->key == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="received" name="rsa" value="Received" {{ isset($insurance) && $insurance->rsa == 'Received' ? 'checked' : '' }}>
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
                                                                <input class="form-check-input" type="checkbox" id="lob" name="lob" value="Received" {{ isset($insurance) && $insurance->lob == 'Received' ? 'checked' : '' }}>
                                                                <label class="form-check-label font-weight-bold" for="lob"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!empty($endorsement))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Endorsement Insurance Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="survyour_name">Date:</label>
                                                        <input class="form-control" type="date" name="date" id="date" value="{{$endorsement->date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="contact_number">Sum Assured:</label>
                                                        <input class="form-control" type="text" name="sum_assured" id="contact_number" value="{{$endorsement->sum_assured ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="dealer">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="dealer" value="{{$endorsement->premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="endorsement_details">Endorsement Detail:</label>
                                                        <textarea id="endorsement_details" name="endorsement_details" class="form-control" rows="4" readonly>@if(isset($endorsement->id)) {{ $endorsement->endorsement_details }}@else{{ old('endorsement_details') }}@endif</textarea>
                                                    </div>
                                                </div>
                                                @endif
                                                <button type="submit" id="save_button" class="btn btn-primary mt-3">Save</button>

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
@php
    $selectedVehicle = $insurance->vehicle_number ?? null; // Assuming $insurance is available in your Blade template
@endphp

<div class="modal fade text-left" id="addParty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33"><b>Add Party</b></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" id="updateForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="party_name">Party Name</label>
                            <input type="text" id="party_name" placeholder="Party Name" name="party_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="father_name">Father Name</label>
                            <input type="text" id="father_name" placeholder="Father Name" name="father_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="whatsapp_number">Whatsapp Number</label>
                            <input type="number" id="whatsapp_number" placeholder="Whatsapp Number" name="whatsapp_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="office_address">Office Address</label>
                            <input type="text" id="office_address" placeholder="Office Address" name="office_address" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="email">Email</label>
                            <input type="email" id="email" placeholder="Email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="residence_city">Residence City</label>
                            <input type="text" id="residence_city" placeholder="Residence City" name="residence_city" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="office_number">Office Number</label>
                            <input type="text" id="office_number" placeholder="Office Number" name="office_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="office_city">Office City</label>
                            <input type="text" id="office_city" placeholder="Office City" name="office_city" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="residence_address">Residence Address</label>
                            <input type="text" id="residence_address" placeholder="Residence Address" name="residence_address" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="pan_number">Pan Number</label>
                            <input type="text" id="pan_number" placeholder="Pan Number" name="pan_number" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="firm_name">Firm Name</label>
                            <input type="text" id="firm_name" placeholder="Firm Name" name="firm_name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                    <button type="button" class="btn btn-primary modal_submit">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').not('#colorType, #vehicle_number').selectize();
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
                    // $('#brand').val(response.brand);
                    // $('#model').val(response.model);
                    // $('#color').val(response.color);
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

    $(document).ready(function() {
        $('#od_type_insurance').on('change', function(e) {
            $('#od_type_insurance').val($(this).val());
            var odType = this.value;

            if (odType == 1 || odType == 2) {
                $('#insuranace_type_radio').css('display', 'block');
            } else {
                $('#insuranace_type_radio').css('display', 'none');
            }
        });
    });
    $(document).ready(function() {
        function calculateTotal() {
            const premium = parseFloat($('#premium').val()) || 0;
            const gst = parseFloat($('#gst').val()) || 0;
            const thirdPartyPremium = parseFloat($('#third_party_premium').val()) || 0;
            const amtAll = premium + thirdPartyPremium;

            let totalAmount;
            if (!isNaN(gst) || gst != '' || gst !== 0) {
                const gstAmount = (amtAll * gst) / 100;
                totalAmount = amtAll + gstAmount;
            } else {
                totalAmount = amtAll;
            }

            $('#total').val(totalAmount);
        }

        $('#premium, #gst').on('input', function() {
            calculateTotal();
        });
    });

    $(document).ready(function() {
        $('#insurance_from_date').change(function() {
            var fromDate = new Date($(this).val());
            var toDate = new Date(fromDate);
            toDate.setFullYear(fromDate.getFullYear() + 1);
            toDate.setDate(toDate.getDate() - 1);
            var formattedToDate = toDate.toISOString().slice(0, 10);
            $('#insurance_to_date').val(formattedToDate);
        });
    });
    $(document).ready(function() {
        $('#brand').change(function(e) {
            var selectedType = $(this).val();
            if (selectedType) {
                $.ajax({
                    url: '/get-models',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'brand_type': selectedType,
                        'selected_subtype': $('#colorType').val()
                    },
                    success: function(response) {
                        $('#colorType').html(response);
                    },
                });
            } else {
                $('#colorType').html('<option selected disabled>Choose...</option>');
            }
        });
        $('#brand').trigger('change');
    });

    $(document).ready(function() {
        function getCars() {
            var selectedBrand = $('#brand').val();
            var selectedModel = $('#colorType').val();
            var selectedVehicleId = '{{ $selectedVehicle }}';
            if (selectedBrand && selectedModel) {
                $.ajax({
                    url: '/get-cars',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'brand_type': selectedBrand,
                        'model_type': selectedModel,
                        'selected_subtype': selectedVehicleId,
                    },
                    success: function(response) {
                        $('#vehicle_number').html(response);
                    },
                });
            } else {
                $('#vehicle_number').html('<option selected disabled>Choose...</option>');
            }
        }

        $('#brand, #colorType').change(function() {
            getCars();
        });

        getCars();
    });
    $(document).ready(function() {
        $('.modal_submit').click(function(e) {
            e.preventDefault();
            var formData = $('#updateForm').serialize();
            console.log(formData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/save-party-data',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    alert('Party data saved successfully');
                    location.reload();
                    $('#addParty input').val('');
                    $('#addParty').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    var errorMessage = 'Error: ';

                    try {
                        var response = JSON.parse(xhr.responseText);
                        console.log(response); // Debugging: Log the parsed response
                        if (response.errors) {
                            for (var key in response.errors) {
                                errorMessage += response.errors[key][0] + '<br>';
                            }
                        }
                    } catch (e) {
                        console.error(e); // Debugging: Log any parsing errors
                        errorMessage += 'Unknown error occurred.';
                    }

                    console.log(errorMessage); // Debugging: Log the final error message
                    toastr.error(errorMessage);
                }
            });
        });
    });
</script>
@endpush
