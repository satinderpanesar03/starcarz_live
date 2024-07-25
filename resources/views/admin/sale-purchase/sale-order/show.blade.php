@extends('admin.layouts.header')
@section('title', 'View Sale Order')
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
                                            <h5 class="pt-2 pb-2">View Sale Order</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.sale.sale.order-index')}}" class="btn btn-sm btn-primary px-3 py-1">
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
                                                    <div class="col-md-4 mt-2">
                                                        <label for="residence_city">Executive Name</label>
                                                        <select name="executive_id" id="mst_executive_id" disabled>
                                                            <option value="{{($saleOrder->executive) ? $saleOrder->executive->id : ''}}" selected>{{($saleOrder->executive) ? $saleOrder->executive->name : ''}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="brand_id">Vehicle Make:</label>
                                                        <select name="brand_id" id="brand_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($brands as $value => $party)
                                                            <option value="{{$value}}" {{ isset($saleOrder->id) && $saleOrder->brand_id == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="model_id">Vehicle Model:</label>
                                                        <select name="model_id" id="model_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($models as $value => $party)
                                                            <option value="{{$value}}" {{ isset($saleOrder->id) && $saleOrder->model_id == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <input type="text" name="purchase_id" id="vehicle_number" class="form-control" value="{{ isset($saleOrder->purchase)  ? $saleOrder->purchase->reg_number : '' }}" disabled>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <input class="form-control" type="text" name="brand" id="brand" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <input class="form-control" type="text" name="color" id="color" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" readonly>
                                                    </div>
                                                    <!--
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" readonly>
                                                    </div>-->
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_sale">Date Of Purchase:</label>
                                                        <input type="text" id="date_of_sale" name="date_of_sale"  class="form-control" value="{{ date('d-m-Y',strtotime($saleOrder->date_of_sale)) }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
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
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" value="@if(isset($saleOrder->id)){{$saleOrder->kilometer}}@else{{old('kilometer')}}@endif" readonly>
                                                    </div>
                                                </div>
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
                                                        <label for="policy_number_id">Policy Number</label>
                                                        <select name="policy_number" id="policy_number_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($policyNumbers as $id => $policy)
                                                            <option value="{{$id}}" {{ isset($saleOrder->id) && $saleOrder->policy_number == $id ? ' selected' : '' }}>{{$policy}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_company">Insurance Company:</label>
                                                        <select name="insurance_company" id="insurance_company" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($saleOrder->insurance_company) && $saleOrder->insurance_company == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_done_date">Insurance Done Date:</label>
                                                        <input type="date" id="insurance_done_date" name="insurance_done_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->insurance_done_date)->format('Y-m-d') : old('insurance_done_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_from_date">Insurance From Date:</label>
                                                        <input type="date" id="insurance_from_date" name="insurance_from_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->insurance_from_date)->format('Y-m-d') : old('insurance_from_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_to_date">Insurance To Date:</label>
                                                        <input type="date" id="insurance_to_date" name="insurance_to_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->insurance_to_date)->format('Y-m-d') : old('insurance_to_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number_id">Policy Number</label>
                                                        <select name="policy_id" id="policy_number_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($policyNumbers as $id => $policy)
                                                            <option value="{{$id}}" {{ isset($carLoan->id) && $carLoan->policy_id == $id ? ' selected' : '' }}>{{$policy}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="icompany_id" id="icompany_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($saleOrder->icompany_id) && $value == $saleOrder->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="insurance_from_date" name="reg_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->reg_date)->format('Y-m-d') : old('reg_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_to_date" name="insurance_due_date" class="form-control" value="{{ isset($saleOrder) ? \Carbon\Carbon::parse($saleOrder->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}">
                                                    </div>
                                                </div> -->
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Document Type</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="buyer_id_image">Buyer ID:</label>
                                                        <input type="file" id="buyer_id_image" name="buyer_id_image" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pancard_image">Pan Card:</label>
                                                        <input type="file" id="pancard_image" name="pancard_image" class="form-control">
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
                                                <!-- <button type="submit" id="save_button" class="btn btn-primary mt-3">Save</button> -->
                                        </div>
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

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').not('#model_id, #vehicle_number').selectize();
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
                    // $('#kilometer').val(response.kilometer);
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

    $(document).ready(function() {
        $('#brand_id').change(function(e) {
            var selectedType = $(this).val();
            if (selectedType) {
                $.ajax({
                    url: '/get-models',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'brand_type': selectedType,
                        'selected_subtype': $('#model_id').val()
                    },
                    success: function(response) {
                        $('#model_id').html(response);
                    },
                });
            } else {
                $('#model_id').html('<option selected disabled>Choose...</option>');
            }
        });
        $('#brand_id').trigger('change');
    });

    $(document).ready(function() {
        function getCars() {
            var selectedBrand = $('#brand_id').val();
            var selectedModel = $('#model_id').val();
            var selectedVehicleId = $('#vehicle_number').val();
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

        $('#brand_id, #model_id').change(function() {
            getCars();
        });

        getCars();
    });

    $(document).ready(function() {
        $('#policy_number_id').change(function(e) {
            $('#policy_number_id').val($(this).val());
            var policy = this.value;

            $.ajax({
                url: '{{ route("fetch-insurance-data")}}',
                type: 'GET',
                data: {
                    policy: policy
                },
                success: function(response) {
                    // $('#insurance_company').val(response.insurance_company);
                    $('#insurance_done_date').val(response.insurance_done_date);
                    $('#insurance_from_date').val(response.insurance_from_date);
                    $('#insurance_to_date').val(response.insurance_to_date);
                    var selectize = $('#insurance_company')[0].selectize;
                    selectize.addOption({
                        value: response.icompany_id,
                        text: response.icompany_id
                    });
                    selectize.refreshOptions(false);
                    selectize.setValue(response.insurance_company);
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
