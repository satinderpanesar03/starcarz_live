@extends('admin.layouts.header')
@section('title','View Insurance Claim')
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
                                            <h5 class="pt-2 pb-2">View Insurance Claim</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.claim.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.claim.insurance.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="party_id" id="party_id">

                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="policy_number_id">Policy Number</label>
                                                        <select name="policy_number_id" id="policy_number_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($policyNumbers as $id => $policy)
                                                            <option value="{{$id}}" {{ isset($insurance->id) && $insurance->policy_number_id == $id ? ' selected' : '' }}>{{$policy}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <input type="text" id="mst_party_id" name="mst_party_id" class="form-control" readonly>
                                                    </div>

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
                                                        <label for="executive">Executive:</label>
                                                        <input type="text" id="executive" name="executive" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="vehicle_type">Select Vehicle Type</label>
                                                        <input class="form-control" type="text" name="vehicle_type" id="vehicle_type" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="insured_by">Select Insurance Type:</label>
                                                        <input class="form-control" type="text" name="od_type" id="od_type" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="policy_start_date">Policy Start date:</label>
                                                        <input class="form-control" type="date" name="policy_start_date" id="insurance_from_date" value="{{$insurance->policy_start_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="policy_end_date">Policy End date:</label>
                                                        <input class="form-control" type="date" name="policy_end_date" id="insurance_to_date" value="{{$insurance->policy_end_date ?? ''}}" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- <div class="col-md-3">
                                                        <label for="vehicle_number">Select Vehicle</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($insurance->id) && $insurance->vehicle_number_input == $vehicle->reg_number ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div> -->

                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Vehicle Make:</label>
                                                        <input class="form-control" type="text" name="brand" id="brand" value="@if(isset($insurance)) {{$insurance->brand}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Vehicle Model:</label>
                                                        <input class="form-control" type="text" name="model" id="model" value="@if(isset($insurance)) {{$insurance->model}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Vehicle Number:</label>
                                                        <input class="form-control" type="text" name="vehicle_number_input" id="vehicle_number_input" value="@if(isset($insurance)) {{$insurance->vehicle_number_input}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Sum Assured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($insurance)) {{$insurance->manufacturing_year}} @endif" readonly>
                                                    </div> -->
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if(isset($insurance)) {{$insurance->registration_year}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" value="@if(isset($insurance)) {{$insurance->kilometer}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" value="@if(isset($insurance)) {{$insurance->expectation}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" value="@if(isset($insurance)) {{$insurance->date_of_purchase}} @endif" readonly>
                                                    </div>
                                                </div> -->

                                                <!-- <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="vehicle_number">Insurance Done By:</label>
                                                        <input class="form-control" type="text" name="vehicle_number" id="insured_by" value="@if(isset($insurance)) {{$insurance->vehicle_number}} @endif" readonly>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="insurance_done_date" value="{{$insurance->insurance_done_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="insurance_from_date" value="{{$insurance->insurance_from_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="insurance_to_date" value="{{$insurance->insurance_to_date ?? ''}}" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_company">Insurance Company:</label>
                                                        <input class="form-control" type="text" name="insurance_company" id="insurance_company" value="@if(isset($insurance)) {{$insurance->insurance_company}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="premium" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="text" name="gst" id="gst" value="{{$insurance->gst ?? ''}}" readonly>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="policy_number" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                </div> -->
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="survyour_name">Survyour Name:</label>
                                                        <input class="form-control" type="text" name="survyour_name" id="survyour_name" value="{{$insurance->survyour_name ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input class="form-control" type="text" name="contact_number" id="contact_number" value="{{$insurance->contact_number ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="dealer">Dealer:</label>
                                                        <input class="form-control" type="text" name="dealer" id="dealer" value="{{$insurance->dealer ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($status as $value => $label)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->status == $value) selected @endif>{{$label}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-3">
                                                        <label for="claim_details">Claim Detail:</label>
                                                        <textarea id="claim_details" name="claim_details" class="form-control" rows="4" readonly>@if(isset($insurance->id)) {{ $insurance->claim_details }}@else{{ old('claim_details') }}@endif</textarea>
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
        $('#policy_number_id').change(function(e) {
            $('#policy_number_id').val($(this).val());
            var policy = this.value;

            $.ajax({
                url: '/fetch-policy-data',
                type: 'GET',
                data: {
                    policy: policy
                },
                success: function(response) {
                    $('#party_id').val(response.party_id);
                    $('#vehicle_number_input').val(response.vehicle_number);
                    $('#brand').val(response.brand);
                    $('#color').val(response.color);
                    $('#manufacturing_year').val(response.manufacturing_year);
                    $('#registration_year').val(response.registration_year);
                    $('#kilometer').val(response.kilometer);
                    $('#expectation').val(response.expectation);
                    $('#owners').val(response.owners);
                    $('#fuel_type').val(response.fuel_type);
                    $('#shape_type').val(response.shape_type);
                    $('#engine_number').val(response.engine_number);
                    $('#chassis_number').val(response.chassis_number);
                    $('#service_booklet').val(response.service_booklet);
                    $('#date_of_purchase').val(response.date_of_purchase);
                    $('#purchase_id').val(response.purchase_id);
                    $('#insurance_company').val(response.insurance_company);
                    $('#insurance_done_date').val(response.insurance_done_date);
                    $('#insurance_from_date').val(response.insurance_from_date);
                    $('#insurance_to_date').val(response.insurance_to_date);
                    $('#vehicle_type').val(response.vehicle_type);
                    $('#od_type_insurance').val(response.od_type_insurance);
                    $('#premium').val(response.premium);
                    $('#gst').val(response.gst);
                    $('#vehicle_number_input').val(response.vehicle_number_input);
                    $('#policy_number').val(response.policy_number);
                    $('#vehicle_number').val(response.vehicle_number);
                    $('#mst_party_id').val(response.mst_party_id);
                    $('#registered_owner').val(response.registered_owner);
                    $('#email').val(response.email);
                    $('#city').val(response.office_city);
                    $('#contact_number').val(response.office_number);
                    $('#address').val(response.office_address);
                    $('#executive').val(response.executive);
                    $('#insured_by').val(response.insured_by);
                    $('#vehicle_type').val(response.vehicle_type);
                    $('#od_type').val(response.od_type);
                    $('#model').val(response.model);
                    $('#sum_insured').val(response.sum_insured);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#policy_number_id').trigger('change');
    });
</script>
@endpush