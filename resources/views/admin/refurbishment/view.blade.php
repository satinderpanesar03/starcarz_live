@extends('admin.layouts.header')
@section('title','View Refurbnishment')
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
                                            <h5 class="pt-2 pb-2">View Refurbnishment</h5>
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
                                        <form method="post" action="{{route('admin.refurbishment.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <input type="hidden" name="ref_id" value="{{ $refurbishment->id ?? null }}">
                                                <!-- <div class="row"> -->
                                                <!-- <div class="col-md-4">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Select Mode</label>
                                                            <div class="form-group mb-2 d-flex">
                                                                <div class="controls flex-grow-1">
                                                                    <select name="mode" class="form-control" id="mode">
                                                                        <option value="">Choose...</option>
                                                                        @foreach (\App\Models\Refurbishment::refStatus() as $value => $party)
                                                                        <option value="{{$value}}" {{isset($refurbishment->id) && $refurbishment->status == $value ? ' selected' : '' }}>{{$party}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" value="1" name="mst_executive_id">

                                                    <div class="col-md-4">
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
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;"> -->
                                                <!-- <h5>Vehicle Details</h5> -->
                                                <div class="row">
                                                    <!-- <div class="col-md-3">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Select Mode</label>
                                                            <div class="form-group mb-2 d-flex">
                                                                <div class="controls flex-grow-1">
                                                                    <select name="mode" class="form-control" id="mode">
                                                                        <option value="">Choose...</option>
                                                                        @foreach (\App\Models\Refurbishment::refStatus() as $value => $party)
                                                                        <option value="{{$value}}" {{isset($refurbishment->id) && $refurbishment->status == $value ? ' selected' : '' }}>{{$party}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-3">
                                                        <label for="date">Date:</label>
                                                        <input type="date" id="date" name="date" class="form-control" value="{{ isset($refurbishment) ? \Carbon\Carbon::parse($refurbishment->date)->format('Y-m-d') : old('date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="model_id">Model:</label>
                                                        <select name="model_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($models as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($refurbishment) && $refurbishment->model_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($refurbishment->id) && $refurbishment->purchase_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="executive_id">Executive:</label>
                                                        <select name="executive_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($executives as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($refurbishment) && $refurbishment->executive_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="supplier_id">Supplier:</label>
                                                        <select name="supplier_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($suppliers as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($refurbishment) && $refurbishment->supplier_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="head">Head:</label>
                                                        <select name="head" id="head" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($headOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($refurbishment->head) && $value == $refurbishment->head? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="total_amount">Amount:</label>
                                                        <input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="Enter Amount" value="@if(isset($refurbishment->id)){{$refurbishment->total_amount}}@else{{old('total_amount')}}@endif" required data-validation-required-message="Name field is required" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="description">Description:</label>
                                                        <textarea id="description" name="description" class="form-control" rows="3" readonly>@if(isset($refurbishment->id)){{ $refurbishment->description }}@else{{ old('description') }}@endif</textarea>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <input class="form-control" type="text" name="brand" id="brand" readonly>
                                                    </div> -->
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <!-- <div class="row">
                                                    <div class="col">
                                                        <button type="button" id="add-section-btn" class="btn btn-primary float-right mt-3">+</button>
                                                    </div>
                                                </div> -->
                                                <!-- <h5>Refurbnishment Details</h5>

                                                <div id="refurbnishement_div">
                                                    <div class="row">
                                                        <h6 style="margin-left: 35%;">Description</h6>
                                                        <h6 style="margin-left: 18%;">Amount</h6>
                                                        <h6 style="margin-left: 15%;">Date</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="service_and_oil_change">Service And Oil Change:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="service_and_oil_change" name="service_and_oil_change" class="form-control" value="{{$refurbishment->service_and_oil_change ?? ''}}" required>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="service_and_oil_change_amount" name="service_and_oil_change_amount" class="form-control" value="{{$refurbishment->service_and_oil_change_amount ?? ''}}" required>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="service_date" name="service_date" class="form-control" value="{{$refurbishment->service_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Compound And Dry Clean:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="compound_and_dry_clean" name="compound_and_dry_clean" class="form-control" value="{{$refurbishment->compound_and_dry_clean ?? ''}}" required>
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="compound_and_dry_clean_amount" name="compound_and_dry_clean_amount" class="form-control" value="{{$refurbishment->compound_and_dry_clean_amount ?? ''}}" required>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="compound_date" name="compound_date" class="form-control" value="{{$refurbishment->compound_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Paint And Denting:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="paint_and_denting" name="paint_and_denting" class="form-control" value="{{$refurbishment->paint_and_denting ?? ''}}">
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="paint_and_denting_amount" name="paint_and_denting_amount" class="form-control" value="{{$refurbishment->paint_and_denting_amount ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="paint_date" name="paint_date" class="form-control" value="{{$refurbishment->paint_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Electrical And Electronics:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="electrical_and_electronics" name="electrical_and_electronics" class="form-control" value="{{$refurbishment->electrical_and_electronics ?? ''}}">
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="electrical_and_electronics_amount" name="electrical_and_electronics_amount" class="form-control" value="{{$refurbishment->electrical_and_electronics_amount ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="electrical_date" name="electrical_date" class="form-control" value="{{$refurbishment->electrical_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Engine Compartment:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="engine_compartment" name="engine_compartment" class="form-control" value="{{$refurbishment->engine_compartment ?? ''}}">
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="engine_compartment_amount" name="engine_compartment_amount" class="form-control" value="{{$refurbishment->engine_compartment_amount ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="engine_date" name="engine_date" class="form-control" value="{{$refurbishment->engine_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Accessories:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="accessories" name="accessories" class="form-control" value="{{$refurbishment->accessories ?? ''}}">
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="accessories_amount" name="accessories_amount" class="form-control" value="{{$refurbishment->accessories_amount ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="accessories_date" name="accessories_date" class="form-control" value="{{$refurbishment->accessories_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <input type="text" id="others_desc" name="others_desc" class="form-control" value="{{$refurbishment->others_desc ?? ''}}">
                                                        </div>
                                                        <div class="col-md-2 mt-2">
                                                            <input type="number" id="others_amount" name="others_amount" class="form-control" value="{{$refurbishment->others_amount ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="date" id="others_date" name="others_date" class="form-control" value="{{$refurbishment->others_date ?? ''}}">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="total">Total</label>
                                                        </div>
                                                        <div class="col-md-4 mt-2">

                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div id="sections">
                                                    @if (!empty($refurbishedDetails))
                                                    @foreach($refurbishedDetails as $index => $refurbishedDetail)
                                                    <div class="row section">
                                                        <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $refurbishedDetail->id }}">
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="mst_model_id">Model:</label>
                                                            <select name="sections[{{ $index }}][mst_model_id]" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($models as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['mst_model_id']) && $refurbishedDetail['mst_model_id'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="registration_number">Registration No.:</label>
                                                            <select name="sections[{{ $index }}][registration_number]" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($regNumbers as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['registration_number']) && $refurbishedDetail['registration_number'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
                                                        <div class="col-md-3 mt-3">
                                                            <label for="mst_supplier_id">Supplier:</label>
                                                            <select name="sections[{{ $index }}][mst_supplier_id]" class="form-control" disabled>
                                                                <option value="">Choose...</option>
                                                                @foreach($suppliers as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['mst_supplier_id']) && $refurbishedDetail['mst_supplier_id'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="payment_mode">Payment Mode:</label>
                                                            <select name="sections[{{ $index }}][payment_mode]" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($paymentmodes as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['payment_mode']) && $value == $refurbishedDetail['payment_mode'] ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="head">Head:</label>
                                                            <select name="sections[{{ $index }}][head]" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($headOptions as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['head']) && $value == $refurbishedDetail['head'] ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="mst_executive_id">Sale Executive:</label>
                                                            <select name="sections[{{ $index }}][mst_executive_id]" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($executives as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishedDetail['mst_executive_id']) && $refurbishedDetail['mst_executive_id'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
                                                        <div class="col-md-3 mt-3">
                                                            <label for="voucher_date">Date:</label>
                                                            <input type="date" name="sections[{{ $index }}][voucher_date]" class="form-control" placeholder="Enter Amount" value="{{ isset($refurbishedDetail['voucher_date']) ? $refurbishedDetail['voucher_date'] : old('voucher_date') }}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="amount">Amount:</label>
                                                            <input type="text" name="sections[{{ $index }}][amount]" class="form-control" placeholder="Enter Amount" value="{{ isset($refurbishedDetail['amount']) ? $refurbishedDetail['amount'] : old('amount') }}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="description">Description:</label>
                                                            <textarea name="sections[{{ $index }}][description]" class="form-control" rows="3" readonly>{{ isset($refurbishedDetail['description']) ? $refurbishedDetail['description'] : old('description') }}</textarea>
                                                        </div>
                                                        <!-- <div class="col-md-1 mt-3">
                                                            <button class="btn btn-danger remove-section-btn">Remove</button>
                                                        </div> -->
                                                    </div>
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    @endforeach
                                                    @endif
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
</script>

@endpush