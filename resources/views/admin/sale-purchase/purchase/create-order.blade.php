@extends('admin.layouts.header')
@section('title', isset($purchase->id) ? 'Edit Order' : 'Add Order')
@section('content')

<head>
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
                                            <h5 class="pt-2 pb-2">@if(isset($purchase->id)) Edit @else Add @endif Order</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.purchase.purchase.orders')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.purchase.purchase.storeOrder')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="mst_purchase_id" id="purchase_id">
                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <input type="hidden" name="ref_id" value="{{ $refurbishment->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Select Mode</label>
                                                            <div class="form-group mb-2 d-flex">
                                                                <div class="controls flex-grow-1">
                                                                    <select name="mode" class="form-control" id="mode">
                                                                        <option value="">Choose...</option>
                                                                        @foreach (\App\Models\Refurbishment::refStatus() as $value => $party)
                                                                        <option value="{{$value}}" {{$status && $status == $value ? ' selected' : '' }}>{{$party}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="1" name="mst_party_id">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Party:</label>
                                                            <div class="input-group">
                                                                <select name="mst_party_id" id="mst_party_id" class="form-control">
                                                                    <option value="">Search Party</option>
                                                                    @foreach($parties as $party)
                                                                    <option value="{{ $party['id'] }}" {{ isset($purchase->mst_party_id) && $purchase->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                        {{ $party['name'] }} ({{ $party['contacts'] }})
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                                <div data-toggle="modal" data-target="#addParty" class="input-group-append">
                                                                    <button class="btn btn-outline-primary btn-field-height" type="button">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" readonly>
                                                    </div> -->

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
                                                        <select name="purchase_id" id="vehicle_number" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($purchase->id) && $purchase->purchase_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
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
                                                        <input type="text" id="price_p1" name="price_p1" class="form-control" value="@if(isset($purchase->id)){{$purchase->price_p1}}@else{{old('price_p1')}}@endif">
                                                    </div>
                                                    @if(Auth::guard('admin')->user()->role_id == 1)
                                                    <div class="col-md-4 mt-2">
                                                        <label for="price_p2">Price P2:</label>
                                                        <input type="text" id="price_p2" name="price_p2" class="form-control" value="@if(isset($purchase->id)){{$purchase->price_p2}}@else{{old('price_p2')}}@endif">
                                                    </div>
                                                    @endif
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->reg_date)->format('Y-m-d') : old('reg_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="icompany_id" id="icompany_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->icompany_id) && $value == $purchase->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->policy_number}}@else{{old('policy_number')}}@endif">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Document Type</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">

                                                        <label for="registration_cerificate">Registration Cerificate:</label>
                                                        <input type="file" id="image" name="image" class="form-control">
                                                        @if(isset($purchase->image))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $purchase->image) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['purchase_orders',$purchase->id,'image'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="seller_id">Seller ID:</label>
                                                        <input type="file" id="seller_id" name="seller_id" class="form-control">
                                                        @if(isset($purchase->seller_id))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $purchase->seller_id) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['purchase_orders',$purchase->id,'seller_id'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pancard_image">Pan Card:</label>
                                                        <input type="file" id="pancard_image" name="pancard_image" class="form-control">
                                                        @if(isset($purchase->pancard_image))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $purchase->pancard_image) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['purchase_orders',$purchase->id,'pancard_image'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pancard_number">Pancard Number:</label>
                                                        <input type="text" id="pancard_number" name="pancard_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->pancard_number}}@else{{old('pancard_number')}}@endif" required>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="aadharcard_number">Aadharcard Number:</label>
                                                        <input type="text" id="aadharcard_number" name="aadharcard_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->aadharcard_number}}@else{{old('aadharcard_number')}}@endif" required>
                                                    </div>
                                                    <!-- <div class="col-md-4 mt-2">
                                                        <label for="hypothecation">Hypothecation:</label>
                                                        <select name="hypothecation" id="registration_cerificate" class="form-control">
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($hypothecationType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->hypothecation) && $value == $purchase->hypothecation? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="name_fcompany">Name Of Finance Company:</label>
                                                        <input type="text" id="name_fcompany" name="name_fcompany" class="form-control" value="@if(isset($purchase->id)){{$purchase->name_fcompany}}@else{{old('name_fcompany')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loanos">LoanO/S(App.):</label>
                                                        <input type="text" id="loanos" name="loanos" class="form-control" value="@if(isset($purchase->id)){{$purchase->loanos}}@else{{old('loanos')}}@endif">
                                                    </div> -->
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
                    $('#pancard_number').val(response.pan_number);
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
                    $('#reg_date').val(regDate.getFullYear() + '-' + ('0' + (regDate.getMonth() + 1)).slice(-2) + '-' + ('0' + regDate.getDate()).slice(-2));
                    $('#insurance_due_date').val(insuranceDueDate.getFullYear() + '-' + ('0' + (insuranceDueDate.getMonth() + 1)).slice(-2) + '-' + ('0' + insuranceDueDate.getDate()).slice(-2));
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
