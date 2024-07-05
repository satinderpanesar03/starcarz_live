@extends('admin.layouts.header')
@section('title', isset($rcTransfer->id) ? 'Edit RC Transfer' : 'Add RC Transfer')
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
                                            <h5 class="pt-2 pb-2">@if(isset($rcTransfer->id)) Edit @else Add @endif RC Transfer Sale Order</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.rc-transfer.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.sale.sale.order-store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="mst_purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $saleOrder->id ?? null }}">
                                                <div class="row">
                                                    <input type="hidden" name="mst_party_id">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control" disabled>
                                                            <option value="">Search By Name/Number</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($saleOrder->mst_party_id) && $saleOrder->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }} ({{ $party['contacts'] }})
                                                            </option>
                                                            @endforeach
                                                        </select>
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
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <select name="purchase_id" id="vehicle_number" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($saleOrder->id) && $saleOrder->purchase_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <input class="form-control" type="text" name="brand" id="brand" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <input class="form-control" type="text" name="color" id="color" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" readonly>
                                                    </div> -->
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners" name="owners" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <input type="text" id="fuel_type" name="fuel_type" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <input type="text" id="shape_type" name="shape_type" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
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
                                                    </div>

                                                </div> -->
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Sale Price</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="price_p1">Price S1:</label>
                                                        <input type="text" id="price_p1" name="price_p1" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->price_p1}}@else{{old('price_p1')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="price_p2">Price S2:</label>
                                                        <input type="text" id="price_p2" name="price_p2" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->price_p2}}@else{{old('price_p2')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->reg_date)->format('Y-m-d') : old('reg_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="icompany_id" id="icompany_id" class="form-control" disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($saleOrder->icompany_id) && $value == $saleOrder->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->policy_number}}@else{{old('policy_number')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Document Type</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="buyer_id_image">Buyer ID:</label>
                                                        <input type="file" id="buyer_id_image" name="buyer_id_image" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pancard_image">Pan Card:</label>
                                                        <input type="file" id="pancard_image" name="pancard_image" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pancard_number">Pancard Number:</label>
                                                        <input type="text" id="pancard_number" name="pancard_number" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->pancard_number}}@else{{old('pancard_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="aadharcard_number">Aadharcard Number:</label>
                                                        <input type="text" id="aadharcard_number" name="aadharcard_number" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->aadharcard_number}}@else{{old('aadharcard_number')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>RC Transfer Details</h5>
                                                <input type="hidden" name="rc_id" value="{{ $rcTransfer->id ?? null }}">
                                                <input type="hidden" name="rc_transfer" value="true">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="agent_id">Agent:</label>
                                                        <select name="agent_id" id="agent_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($agents as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->agent_id) && $value == $rcTransfer->agent_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="transfer_date">Transfer Date:</label>
                                                        <input type="date" id="transfer_date" name="transfer_date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->transfer_date)->format('Y-m-d') : old('transfer_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="date">Doc Given Date:</label>
                                                        <input type="date" id="date" name="date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->date)->format('Y-m-d') : old('date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="amount_paid">Amount Paid:</label>
                                                        <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="@if(isset($rcTransfer->id)){{$rcTransfer->amount_paid}}@else{{old('amount_paid')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Select Status:</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach($statusType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->status) && $rcTransfer->status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
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
                    var regDate = new Date(response.reg_date);
                    var insuranceDueDate = new Date(response.insurance_due_date);
                    $('#reg_date').val(regDate.toISOString().split('T')[0]);
                    $('#insurance_due_date').val(insuranceDueDate.toISOString().split('T')[0]);
                    $('#policy_number').val(response.policy_number);
                    var selectize = $('#icompany_id')[0].selectize;
                    selectize.addOption({
                        value: response.icompany_id,
                        text: response.icompany_id
                    });
                    selectize.refreshOptions(false);
                    selectize.setValue(response.icompany_id);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number').trigger('change');
    });
</script>
@endpush