@extends('admin.layouts.header')
@section('title', isset($sale->id) ? 'Edit Sale' :'Add Sale')
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
                                            <h5 class="pt-2 pb-2">@if(isset($sale->id)) Edit @else Add @endif Sale Enquiry</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.sale.sale.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.sale.sale.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $sale->id ?? null }}">
                                                <input type="hidden" name="vehicle_id" id="vehicle_id">
                                                <input type="hidden" name="suggestion_vehicle_id" id="suggestion_vehicle_id">

                                                <!-- <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <input type="hidden" name="ref_id" value="{{ $refurbishment->id ?? null }}"> -->
                                                <div class="row">
                                                    <input type="hidden" value="1" name="party_id">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($sale->id)){{$sale->firm_name}}@else{{old('firm_name')}}@endif">
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="person_name">Person Name:</label>
                                                        <input type="text" id="person_name" name="person_name" class="form-control" value="@if(isset($sale->id)){{$sale->person_name}}@else{{old('person_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($sale->id)){{$sale->contact_number}}@else{{old('contact_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" value="@if(isset($sale->id)){{$sale->address}}@else{{old('address')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" value="@if(isset($sale->id)){{$sale->city}}@else{{old('city')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($sale->id)){{$sale->email}}@else{{old('email')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_executive_id">Executive:</label>
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control">
                                                            <option value="">Search Executive</option>
                                                            @foreach($executives as $id => $label)
                                                            <option value="{{ $id }}" {{ isset($sale) && $sale->mst_executive_id == $id ? 'selected' : '' }}>{{ ucfirst($label)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status_id" class="form-control{{ $type ? ' readonly' : '' }}" {{ $type ? 'disabled' : '' }}>
                                                            @if(isset($sale->status))
                                                                <option value="{{ $sale->status }}" selected>{{ $sale->getStatusName($sale->status) }}</option>
                                                            @endif
                                                            @foreach($status as $value => $label)
                                                                @if(!isset($sale->status) || $value != $sale->status)
                                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Asked</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="vehicle_id">Vehicle:</label>
                                                        <select name="vehicle_id[]" id="vehicle_id" class="form-control" multiple>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($models as $value => $label)
                                                                <option value="{{ $value }}" @if (isset($sale->vehicle_id))
                                                                {{ in_array($value, explode(',',$sale->vehicle_id)) ? 'selected' : '' }}
                                                                @endif>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <input class="form-control" type="text" name="brand" id="brand" value="@if(isset($sale->id)){{$sale->brand}}@else{{old('brand')}}@endif">
                                                    </div> -->
                                                    <div class="col-md-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <select name="color[]" id="" multiple>
                                                            @foreach ($colors as $value => $color)
                                                                <option value="{{$color}}" @if (isset($sale->color))
                                                                {{in_array($color, explode(',',$sale->color)) ? 'selected' : '' }}
                                                                @endif >{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{-- <input class="form-control" type="text" name="color" id="color" value="@if(isset($sale->id)){{$sale->color}}@else{{old('color')}}@endif"> --}}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="model">Manufacturing Year:</label>
                                                        <input class="form-control" type="text" name="model" id="model" value="@if(isset($sale->id)){{$sale->model}}@else{{old('model')}}@endif">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="enquiry_type">Enquiry Type:</label>
                                                        <select name="enquiry_type" id="enquiry_type" class="form-control">
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($enquiryType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->enquiry_type) && $value == $sale->enquiry_type? 'selected' : '' }}>{{ $label }}</option >
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" readonly>
                                                    </div>
                                                </div> -->

                                                <div class="row">
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners" name="owners" class="form-control" readonly>
                                                    </div> -->
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type</label>
                                                        <select class="form-control" name="fuel_type[]" multiple>
                                                            @foreach (\App\Models\Purchase::getFuelType() as $value => $fuel)
                                                            <option value="{{$value}}"{{ isset($sale->fuel_type) && in_array($value, explode(',', $sale->fuel_type)) ? 'selected' : '' }} >{{$fuel}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <input type="text" id="shape_type" name="shape_type" class="form-control" readonly>
                                                    </div> -->
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="engine_number">Engine Number:</label>
                                                        <input type="text" id="engine_number" name="engine_number" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="chasis_number">Chasis Number:</label>
                                                        <input type="text" id="chasis_number" name="chasis_number" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="service_booklet">Service Booklet:</label>
                                                        <input type="text" id="service_booklet" name="service_booklet" class="form-control" readonly>
                                                    </div> -->
                                                    <div class="col-md-3 mt-3">
                                                        <label for="budget">Budget</label>
                                                        <select class="form-control" name="budget_type">
                                                            @foreach (\App\Models\Purchase::getBudget() as $value => $fuel)
                                                            <option value="{{$value}}"{{ isset($sale->budget_type) && $value == $sale->budget_type? 'selected' : '' }}>{{$fuel}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="finance_requirement">Finance:</label>
                                                        <select name="finance_requirement" id="finance_requirement" class="form-control">
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($finance as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->finance_requirement) && $value == $sale->finance_requirement? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Suggestion Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number_s">Vehicle Number</label>
                                                        <select name="suggestion_vehicle_id[]" id="vehicle_number_s" class="form-control" multiple>
                                                            <option value="">Choose...</option>
                                                            @foreach ($suggestedVehicle as $value => $vehicle)
                                                                <option value="{{$value}}" {{ isset($sale->suggestion_vehicle_id) && in_array($value, explode(',', $sale->suggestion_vehicle_id)) ? 'selected' : '' }}>{{ $vehicle }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    {{-- <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Model:</label>
                                                        <input class="form-control" type="text" name="model_s" id="model_s" readonly>
                                                    </div> --}}
                                                    <!-- <div class="col-md-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <input class="form-control" type="text" name="color" id="color_s" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year_s" name="manufacturing_year" class="form-control" readonly>
                                                    </div> -->

                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year_s" name="registration_year" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer_s" name="kilometer" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation_s" name="expectation" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase_s" name="date_of_purchase" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners_s" name="owners" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <input type="text" id="fuel_type_s" name="fuel_type" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <input type="text" id="shape_type_s" name="shape_type" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="engine_number">Engine Number:</label>
                                                        <input type="text" id="engine_number_s" name="engine_number" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="chasis_number">Chasis Number:</label>
                                                        <input type="text" id="chasis_number_s" name="chasis_number" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="service_booklet">Service Booklet:</label>
                                                        <input type="text" id="service_booklet_s" name="service_booklet" class="form-control" readonly>
                                                    </div>

                                                </div> -->
                                                @if(!empty($sale->followup_date))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Followup details </h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="quoted_date_input">Follow Date:</label>
                                                        <input type="date" name="followup_date" class="form-control" value="{{ isset($sale) ? \Carbon\Carbon::parse($sale->followup_date)->format('Y-m-d') : old('followup_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="follow_remarks">Remarks:</label>
                                                        <input type="text" name="follow_remarks" class="form-control" value="@if(isset($sale->id)){{$sale->follow_remarks}}@else{{old('follow_remarks')}}@endif">
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($sale->expected_price))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Quotation details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="amount">Amount:</label>
                                                    <input type="text" name="expected_price" id="expected_price" class="form-control" value="@if(isset($sale->id)){{$sale->expected_price}}@else{{old('expected_price')}}@endif">
                                                </div>
                                                @endif

                                                @if(isset($sale->remarks))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Closed details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="remarks">Remarks:</label>
                                                    <input type="text" id="remarks_data" name="remarks" class="form-control" value="@if(isset($sale->id)){{$sale->remarks}}@else{{old('remarks')}}@endif">
                                                </div>
                                                @endif
                                                <div id="remarks_input_1">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Closed details </h5>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="remarks_input">Remarks:</label>
                                                        <input type="text" id="remarks_input" name="remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->remarks}}@else{{old('remarks')}}@endif">
                                                    </div>
                                                </div>
                                                <div id="amount_input_1">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Quotation details </h5>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="amount_input">Amount:</label>
                                                        <input type="text" id="amount_input" name="expected_price" class="form-control" value="@if(isset($purchase->id)){{$purchase->expected_price}}@else{{old('expected_price')}}@endif">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <input type="hidden" id="followup_date_input" name="followup_date" value="{{ isset($sale) ? \Carbon\Carbon::parse($sale->followup_date)->format('Y-m-d') : old('followup_date') }}">
                                                <input type="hidden" id="followup_remark" name="follow_remarks" value="@if(isset($sale->id)){{$sale->follow_remarks}}@else{{old('follow_remarks')}}@endif">

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

<div class="modal fade text-left" id="addDemandVehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33"><b>Add Demand Vehicle</b></label>
            </div>
            <form action="{{route('admin.demand.vehicle.store')}}" method="post">
                @csrf
                <input type="hidden" value="" name="party_id" id="demand_party_id">
                <input type="hidden" value="" name="enquiry_id" id="enquiry_id">
                <div class="modal-body">
                    <div class="col-md-12 mb-3">
                        <label for="vehicle">Vehicle Model</label>
                        <select id="permissions-select" name="vehicle[]" class="form-select mb-1" multiple required>
                            <option selected value="">Choose...</option>
                            @foreach ($carList as $car)
                            <option value="{{$car->model}}">{{$car->model}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="budget">Budget</label>

                        <select class="form-control" name="_old">
                            @foreach (\App\Models\Purchase::getBudget() as $value => $fuel)
                            <option value="{{$value}}">{{$fuel}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="fuel_type">Fuel Type</label>
                        <select class="form-control" name="fuel_type_old">
                            @foreach (\App\Models\Purchase::getFuelType() as $value => $fuel)
                            <option value="{{$value}}">{{$fuel}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                    <button type="submit" class="btn btn-primary" id="saveData">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="addfollowup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33"><b>Follow Up Date</b></label>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="followup_date">Follow Up Date</label>
                    <input type="date" id="followup_date" class="form-control" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="remarks_input">Remarks:</label>
                    <input type="text" id="remarks_modal" class="form-control" value="@if(isset($sale->id)){{$sale->remarks}}@else{{old('remarks')}}@endif">
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                <button type="button" class="btn btn-primary" id="saveFollowUpDate">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // $(document).ready(() => {
    //     $('select').selectize();
    //     $('#example').DataTable({
    //         // data: name,
    //         deferRender: true,
    //         // scrollY:        200,
    //         scrollCollapse: true,
    //         scroller: true,
    //         info: false,
    //         "bPaginate": false,
    //     });
    // });

    $(document).ready(()=>{
        $('select').selectize({
            plugins: ["remove_button"],
        });
    });


    $(document).ready(function() {
        $('#mst_party_id').change(function(e) {
            $('#mst_party_id').val($(this).val());
            var partyId = this.value;

            $('#demand_party_id').val(partyId);

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
                    $('#vehicle_id').val(response.purchase_id);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number').trigger('change');

        $('#vehicle_number_s').change(function(e) {
            $('#vehicle_number_s').val($(this).val());
            var vehicle = this.value;

            $.ajax({
                url: '/fetch-vehicles',
                type: 'GET',
                data: {
                    vehicle: vehicle
                },
                success: function(response) {
                    $('#brand_s').val(response.brand);
                    $('#color_s').val(response.color);
                    $('#model_s').val(response.model);
                    $('#manufacturing_year_s').val(response.manufacturing_year);
                    $('#registration_year_s').val(response.registration_year);
                    $('#kilometer_s').val(response.kilometer);
                    $('#expectation_s').val(response.expectation);
                    $('#owners_s').val(response.owners);
                    $('#fuel_type_s').val(response.fuel_type);
                    $('#shape_type_s').val(response.shape_type);
                    $('#engine_number_s').val(response.engine_number);
                    $('#chasis_number_s').val(response.chasis_number);
                    $('#service_booklet_s').val(response.service_booklet);
                    $('#date_of_purchase_s').val(response.date_of_purchase);
                    $('#suggestion_vehicle_id').val(response.purchase_id);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number_s').trigger('change');

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
        $('#status_id').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '3') {
                $('#addfollowup').modal('show');
            }
            var savedFollowUpDate = $('#followup_date_input').val();

            if (savedFollowUpDate) {
                $('#followup_date').val(savedFollowUpDate);
            }
        });
        $('#saveFollowUpDate').click(function() {
            // Get the follow-up date from the modal input field
            var followUpDate = $('#followup_date').val();
            var remarks = $('#remarks_modal').val();
            if (!followUpDate) {
                alert("Follow Up Date is required.");
            } else {
                $('#followup_date_input').val(followUpDate);
                $('#followup_remark').val(remarks);
                $('#addfollowup').modal('hide');
            }
        });
    });

    $(document).ready(function() {
        // Initially hide the remarks field
        $('#remarks_input').hide();
        $('#remarks_input_1').hide();
        $('#amount_input').hide();
        $('#amount_input_1').hide();
        $('#status_id').change(function() {
            var selectedOption = $(this).val();

            // Determine the name of the status based on the selected option
            var name = '';
            if (selectedOption === '4') {
                name = "Evaluated";
                $('#remarks_input').show();
                $('#remarks_input_1').show(); // Show remarks field if status is Evaluated
            } else {
                $('#remarks_input').hide();
                $('#remarks_input_1').hide(); // Hide remarks field for other statuses
            }

            if (selectedOption === '2') {
                name = "Quoted";
                $('#amount_input').show();
                $('#amount_input_1').show();
            } else {
                $('#amount_input').hide();
                $('#amount_input_1').hide();
            }
        });
    });

    $(document).ready(function() {
        $('#save_button').click(function() {
            var selectedOption = $('#status_id').val();
            var name = '';

            // Determine the name of the status based on the selected option
            if (selectedOption === '4') {
                name = "Closed";
            } else if (selectedOption === '2') {
                name = "Quoted";
            }

            // Validate the remarks field
            // if ($('#remarks_data').val().trim() !== '') {
            //     var savedRemarks = $('#remarks_data').val();

            //     if (savedRemarks) {
            //         $('#remarks_input').val(savedRemarks);
            //     }
            // }

            // if ($('#expected_price').val().trim() !== '') {
            //     var savedRemarks = $('#expected_price').val();

            //     if (savedRemarks) {
            //         $('#amount_input').val(savedRemarks);
            //     }
            // }
            if ((selectedOption === '4') && $('#remarks_input').val().trim() === '') {
                alert('Remarks field is required for ' + name + ' status.');
                $('#remarks_input').focus(); // Focus on the remarks input field to bring attention to it
                return false; // Prevent form submission
            } else if ((selectedOption === '2') && $('#amount_input').val().trim() === '') {
                alert('Amount field is required for ' + name + ' status.');
                $('#amount_input').focus();
                return false;
            } else {
                // Proceed with form submission
                return true;
            }
        });
    });

    $(document).ready(() => {
        $('permissions-select').selectize({
            plugins: ["remove_button"],
        });
    });
</script>
@endpush
