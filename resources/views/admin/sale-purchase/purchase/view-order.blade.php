@extends('admin.layouts.header')
@section('title','view Order')
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
                                            <h5 class="pt-2 pb-2">View Order</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="#" class="btn btn-sm btn-primary px-3 py-1" onclick="window.history.back();">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.purchase.purchase.storeOrder')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <input type="hidden" name="ref_id" value="{{ $purchase->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Select Mode</label>
                                                            <div class="form-group mb-2 d-flex">
                                                                <div class="controls flex-grow-1">
                                                                    <input type="text" id="" name="" value="@if ($purchase->status == 6)Purchased @elseif ($purchase->status == 7)Park and Sale @else '' @endif" class="form-control" readonly>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="1" name="mst_party_id">
                                                    <div class="col-md-4">
                                                        <label for="mst_executive_id">Party</label>
                                                        <input type="text" name="mst_party_id" class="form-control" id="mst_party_id" value="{{($purchase->party) ? $purchase->party->party_name : ''}}" readonly>
                                                        <input type="hidden" name="party_id" id="party_id" value="{{ $purchase->party ? $purchase->party->id : '' }}">
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" value="" readonly>
                                                    </div>

                                                </div>
                                                <div class="row">


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
                                                <div class="row">

                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" readonly>
                                                    </div>


                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <input class="form-control" type="text" name="vehicle_number" id="vehicle_number" value="{{($purchase->purchase) ? strtoupper($purchase->purchase->reg_number) : ''}}" readonly>
                                                        <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{ $purchase->purchase ? $purchase->purchase->id : '' }}">
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

                                                </div>



                                                <div class="row">
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
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" readonly>
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

                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Cost</h5>
                                                <div class="row">

                                                    <div class="col-md-4 mt-2">
                                                        <label for="price_p1">Price P1:</label>
                                                        <input type="text" id="price_p1" name="price_p1" class="form-control" value="@if(isset($purchase->id)){{$purchase->price_p1}}@else{{old('price_p1')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="price_p2">Price P2:</label>
                                                        <input type="text" id="price_p2" name="price_p2" class="form-control" value="@if(isset($purchase->id)){{$purchase->price_p2}}@else{{old('price_p2')}}@endif" readonly>
                                                    </div>


                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance</h5>
                                                <div class="row">

                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->reg_date)->format('Y-m-d') : old('reg_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="icompany_id" id="icompany_id" class="form-control" disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->icompany_id) && $value == $purchase->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="ncb_insurance">NCB:</label>
                                                        <input type="text" id="ncb_insurance" name="ncb_insurance" class="form-control" value="@if(isset($purchase->id)){{$purchase->ncb_insurance}}@else{{old('ncb_insurance')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->policy_number}}@else{{old('policy_number')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Document Type</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="registration_cerificate">Registration Cerificate:</label>
                                                        <select name="registration_cerificate" id="registration_cerificate" class="form-control" disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($rcType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->registration_cerificate) && $value == $purchase->registration_cerificate? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="hypothecation">Hypothecation:</label>
                                                        <select name="hypothecation" id="registration_cerificate" class="form-control" disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($hypothecationType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->hypothecation) && $value == $purchase->hypothecation? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="name_fcompany">Name Of Finance Company:</label>
                                                        <input type="text" id="name_fcompany" name="name_fcompany" class="form-control" value="@if(isset($purchase->id)){{$purchase->name_fcompany}}@else{{old('name_fcompany')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loanos">LoanO/S(App.):</label>
                                                        <input type="text" id="loanos" name="loanos" class="form-control" value="@if(isset($purchase->id)){{$purchase->loanos}}@else{{old('loanos')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="image"> RC Image:</label>
                                                        <input type="file" id="image" name="image" class="form-control" readonly>
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
        $('#mst_party_id').on('input', function(e) {
            // $('#mst_party_id').val($(this).val());
            var partyId = $('#party_id').val();

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
        $('#mst_party_id').trigger('input');

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

        $('#vehicle_number').on('input', function(e) {
            // $('#vehicle_id').val($(this).val());
            var vehicle = $('#vehicle_id').val();
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


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number').trigger('input');
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