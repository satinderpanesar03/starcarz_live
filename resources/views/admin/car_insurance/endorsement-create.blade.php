@extends('admin.layouts.header')
@section('title', isset($endorsement->id) ? 'Edit Endorsement Insurance' :'Add Endorsement Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($endorsement->id)) Edit @else Add @endif Endorsement Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.endorsement.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.endorsement.insurance.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="insurance_id" id="insurance_id">
                                                <input type="hidden" name="policy_number" id="policy">

                                                <input type="hidden" name="id" value="{{ $endorsement->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="policy_number_id">Policy Number</label>
                                                        <select name="policy_id" id="policy_number_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($policyNumbers as $id => $policy)
                                                            <option value="{{$id}}" {{ isset($endorsement->id) && $endorsement->policy_id == $id ? ' selected' : '' }}>{{$policy}}</option>
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
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_company">Insurance Company:</label>
                                                        <input class="form-control" type="text" name="insurance_company" id="insurance_company" value="@if(isset($insurance)) {{$insurance->insurance_company}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="policy_number" value="{{$insurance->policy_number ?? ''}}" readonly>
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
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Sum Assured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="premium" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="text" name="gst" id="gst" value="{{$insurance->gst ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Endorsement details</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="survyour_name">Date:</label>
                                                        <input class="form-control" type="date" name="date" id="date" value="{{$endorsement->date ?? ''}}">
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="contact_number">Sum Assured:</label>
                                                        <input class="form-control" type="text" name="sum_assured" id="contact_number" value="{{$endorsement->sum_assured ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="dealer">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="dealer" value="{{$endorsement->premium ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="endorsement_details">Endorsement Detail:</label>
                                                        <textarea id="endorsement_details" name="endorsement_details" class="form-control" rows="4">@if(isset($endorsement->id)) {{ $endorsement->endorsement_details }}@else{{ old('endorsement_details') }}@endif</textarea>
                                                    </div>
                                                </div>
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
@endsection

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').selectize();
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
        $('#policy_number_id').change(function(e) {
            $('#policy_number_id').val($(this).val());
            var policy = this.value;

            $.ajax({
                url: '{{ route("fetch-policy-data")}}',
                type: 'GET',
                data: {
                    policy: policy
                },
                success: function(response) {
                    $('#party_id').val(response.party_id);
                    $('#vehicle_number_input').val(response.vehicle_number);
                    $('#brand').val(response.brand);
                    $('#model').val(response.model);
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
                    $('#policy').val(response.policy_number);
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