@extends('admin.layouts.header')
@section('title','View General Insurance Claim')
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
                                            <h5 class="pt-2 pb-2">View General Insurance Claim</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.claim.general-insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
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
                                                        <label for="executive">Executive:</label>
                                                        <input type="text" id="executive" name="executive" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_company">Insurance Company:</label>
                                                        <input class="form-control" type="text" name="insurance_company" id="insurance_company" value="@if(isset($insurance)) {{$insurance->insurance_company}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_type">Insurance Type:</label>
                                                        <input class="form-control" type="text" name="insurance_type" id="insurance_type" value="@if(isset($insurance)) {{$insurance->insurance_type}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="vehicle_number">Insurance Done By:</label>
                                                        <input class="form-control" type="text" name="vehicle_number" id="insured_by" value="@if(isset($insurance)) {{$insurance->vehicle_number}} @endif" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
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
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="premium" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="premium_payment_period">Premium Payment Period:</label>
                                                        <input class="form-control" type="text" name="premium_payment_period" id="premium_payment_period" value="{{$insurance->premium_payment_period ?? ''}}" required>
                                                    </div> -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="gst" value="{{$insurance->gst ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="sum_insured">Sum Insured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="total">Total:</label>
                                                        <input class="form-control" type="text" name="total" id="total" value="{{$insurance->total ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="policy_number">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="policy_number" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-2">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4" readonly>@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
                                                    </div>
                                                </div>
                                                <div id="additionalFields">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <div class="row">
                                                        <!-- <h6 style="margin-left: 40%;">Description</h6> -->
                                                        <h6 style="margin-left: 35%;">Amount</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Building:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="building" name="building" class="form-control" value="@if(isset($insurance->id)){{$insurance->building}}@else{{old('building')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Plant and machinery:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="plant_machinery" name="plant_machinery" class="form-control" value="@if(isset($insurance->id)){{$insurance->plant_machinery}}@else{{old('plant_machinery')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Stock:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="stock" name="stock" class="form-control" value="@if(isset($insurance->id)){{$insurance->stock}}@else{{old('stock')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Electrical fittings:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="electical" name="electical" class="form-control" value="@if(isset($insurance->id)){{$insurance->electical}}@else{{old('electical')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Furniture:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="furniture" name="furniture" class="form-control" value="@if(isset($insurance->id)){{$insurance->furniture}}@else{{old('furniture')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="other" name="other" class="form-control" value="@if(isset($insurance->id)){{$insurance->other}}@else{{old('other')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc"><b>Total: </b></label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="total_sum" name="total_sum" class="form-control" value="@if(isset($insurance->id)){{$insurance->total_sum}}@else{{old('total_sum')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                </div>
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
                url: '{{ route("fetch-data")}}',
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
        // Function to calculate the sum of the type fields
        function calculateSum() {
            // Get the values of the type input fields and parse them as floats
            const building = parseFloat($('#building').val()) || 0;
            const plant_machinery = parseFloat($('#plant_machinery').val()) || 0;
            const stock = parseFloat($('#stock').val()) || 0;
            const electical = parseFloat($('#electical').val()) || 0;
            const furniture = parseFloat($('#furniture').val()) || 0;
            const other = parseFloat($('#other').val()) || 0;

            // Calculate the sum
            const sum = building + plant_machinery + stock + electical + furniture + other;

            // Set the calculated sum to the 'total' input field
            $('#total_sum').val(sum);
        }

        // Attach the event handler to the input fields
        $('#building, #plant_machinery, #stock, #electical, #furniture, #other').on('input', function() {
            // Call the function to calculate the sum whenever the input fields change
            calculateSum();
        });
    });

    $(document).ready(function() {
        function handleInsuranceType(insuranceType) {
            const $additionalFields = $('#additionalFields');
            // Check if the insurance type is "Fire" (case insensitive)
            if (insuranceType.toLowerCase() === 'fire') {
                // Show the additional fields if the insurance type is "Fire"
                $additionalFields.show();
            } else {
                // Hide the additional fields otherwise
                $additionalFields.hide();
            }
        }
        $('#policy_number_id').change(function(e) {
            $('#policy_number_id').val($(this).val());
            var policy = this.value;

            $.ajax({
                url: '{{ route("policy-data")}}',
                type: 'GET',
                data: {
                    policy: policy
                },
                success: function(response) {
                    $('#party_id').val(response.party_id);
                    $('#purchase_id').val(response.purchase_id);
                    $('#insurance_company').val(response.insurance_company);
                    $('#insurance_done_date').val(response.insurance_done_date);
                    $('#insurance_from_date').val(response.insurance_from_date);
                    $('#insurance_to_date').val(response.insurance_to_date);
                    $('#od_type_insurance').val(response.od_type_insurance);
                    $('#premium').val(response.premium);
                    $('#gst').val(response.gst);
                    $('#policy_number').val(response.policy_number);
                    $('#vehicle_number').val(response.vehicle_number);
                    $('#mst_party_id').val(response.mst_party_id);
                    $('#registered_owner').val(response.registered_owner);
                    $('#email').val(response.email);
                    $('#city').val(response.office_city);
                    $('#contact_number').val(response.office_number);
                    $('#address').val(response.office_address);
                    $('#executive').val(response.executive);
                    $('#coverage_detail').val(response.coverage_detail);
                    $('#building').val(response.building);
                    $('#plant_machinery').val(response.plant_machinery);
                    $('#stock').val(response.stock);
                    $('#electical').val(response.electical);
                    $('#furniture').val(response.furniture);
                    $('#other').val(response.other);
                    $('#total_sum').val(response.total_sum);
                    $('#insured_by').val(response.insured_by);
                    $('#insurance_type').val(response.insurance_type);
                    $('#total').val(response.total);
                    $('#sum_insured').val(response.sum_insured);

                    handleInsuranceType(response.insurance_type);
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