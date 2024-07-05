@extends('admin.layouts.header')
@section('title','Refurbnishment Deviation')
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
                                            <h5 class="pt-2 pb-2">View Refurbnishment Deviation</h5>
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
                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">

                                                <h5>Refurbnishment Actual Details</h5>
                                                <div id="refurbnishement_div">
                                                    <div class="row">
                                                        <h6 style="margin-left: 40%;">Description</h6>
                                                        <h6 style="margin-left: 35%;">Amount</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="service_and_oil_change">Service And Oil Change:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="service_and_oil_change" name="service_and_oil_change" class="form-control" value="{{$refurbishment->service_and_oil_change}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="service_and_oil_change_amount" name="service_and_oil_change_amount" class="form-control" value="{{$refurbishment->service_and_oil_change_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Compound And Dry Clean:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="compound_and_dry_clean" name="compound_and_dry_clean" class="form-control" value="{{$refurbishment->compound_and_dry_clean}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="compound_and_dry_clean_amount" name="compound_and_dry_clean_amount" class="form-control" value="{{$refurbishment->compound_and_dry_clean_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Paint And Denting:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="paint_and_denting" name="paint_and_denting" class="form-control" value="{{$refurbishment->paint_and_denting}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="paint_and_denting_amount" name="paint_and_denting_amount" class="form-control" value="{{$refurbishment->paint_and_denting_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Electrical And Electronics:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="electrical_and_electronics" name="electrical_and_electronics" class="form-control" value="{{$refurbishment->electrical_and_electronics}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="electrical_and_electronics_amount" name="electrical_and_electronics_amount" class="form-control" value="{{$refurbishment->electrical_and_electronics_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Engine Compartment:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="engine_compartment" name="engine_compartment" class="form-control" value="{{$refurbishment->engine_compartment}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="engine_compartment_amount" name="engine_compartment_amount" class="form-control" value="{{$refurbishment->engine_compartment_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Accessories:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="accessories" name="accessories" class="form-control" value="{{$refurbishment->accessories}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="accessories_amount" name="accessories_amount" class="form-control" value="{{$refurbishment->accessories_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="others_desc" name="others_desc" class="form-control" value="{{$refurbishment->others_desc}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="number" id="others_amount" name="others_amount" class="form-control" value="{{$refurbishment->others_amount}}" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="total">Total</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">

                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="total_amount" name="total_amount" class="form-control" value="{{$refurbishment->total_amount}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Refurbnishment Evaluation Estimate Details</h5>
                                                <div id="refurbnishement_div">
                                                    <div class="row mt-2">
                                                        <h6 style="margin-left: 40%;">Description</h6>
                                                        <h6 style="margin-left: 35%;">Amount</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="service_and_oil_change">Service And Oil Change:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="service_and_oil_change" name="service_and_oil_change" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change}}@else{{old('service_and_oil_change')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="service_and_oil_change_amount" name="service_and_oil_change_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change_amount}}@else{{old('service_and_oil_change_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Compound And Dry Clean:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="compound_and_dry_clean" name="compound_and_dry_clean" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean}}@else{{old('compound_and_dry_clean')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="compound_and_dry_clean_amount" name="compound_and_dry_clean_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean_amount}}@else{{old('compound_and_dry_clean_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Paint And Denting:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="paint_and_denting" name="paint_and_denting" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting}}@else{{old('paint_and_denting')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="paint_and_denting_amount" name="paint_and_denting_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting_amount}}@else{{old('paint_and_denting_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Electrical And Electronics:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="electrical_and_electronics" name="electrical_and_electronics" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics}}@else{{old('electrical_and_electronics')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="electrical_and_electronics_amount" name="electrical_and_electronics_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics_amount}}@else{{old('electrical_and_electronics_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Engine Compartment:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="engine_compartment" name="engine_compartment" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment}}@else{{old('engine_compartment')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="engine_compartment_amount" name="engine_compartment_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment_amount}}@else{{old('engine_compartment_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Accessories:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="accessories" name="accessories" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories}}@else{{old('accessories')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="accessories_amount" name="accessories_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories_amount}}@else{{old('accessories_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="others_desc" name="others_desc" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_desc}}@else{{old('others_desc')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="others_amount" name="others_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_amount}}@else{{old('others_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label for="others_desc" style="margin-left: 89%;"><b>Total: </b></label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="total_amount_evaluation" name="total" class="form-control" value="@if(isset($purchase->id)){{$purchase->total}}@else{{old('total')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-3 mt-2">
                                                        <label for="others_desc" style="margin-left: 89%;"><b>Deviation: </b></label>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                        <input type="text" id="deviation" name="total" class="form-control" value="" readonly>
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
    });

    $(document).ready(function() {
        // Function to calculate and set deviation value
        function calculateDeviation() {
            var refurbishmentTotal = parseFloat($('#total_amount').val());
            var evaluationTotal = parseFloat($('#total_amount_evaluation').val());

            var deviation = refurbishmentTotal - evaluationTotal;
            // Set the deviation value
            $('#deviation').val(deviation.toFixed(2));
        }

        // Call the function initially
        calculateDeviation();

        // Call the function whenever the evaluation amount changes
        $('#total_amount_evaluation').on('input', function() {
            calculateDeviation();
        });
    });
</script>

@endpush