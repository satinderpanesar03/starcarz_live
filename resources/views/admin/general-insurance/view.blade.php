@extends('admin.layouts.header')
@section('title','View General Insurance')
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
                                            <h5 class="pt-2 pb-2">View General Insurance</h5>
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
                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">


                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{$party->id}}" {{ isset($insurance->id) && $insurance->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                            @endforeach
                                                        </select>
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
                                                        <label for="mst_executive_id">Executive:</label>
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->mst_executive_id == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Company:</label>
                                                        <select name="insurance_company" id="vehicle_number" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_company as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_type">Select Insurance Type:</label>
                                                        <select name="insurance_type" id="insurance_type" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($insurance_types as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->insurance_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="vehicle_number">Insurance Done By:</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::InsuranceBy() as $value => $item)
                                                            <option @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif value="{{$value}}">{{$item}}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="brand" value="{{$insurance->insurance_done_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="brand" value="{{$insurance->insurance_from_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="brand" value="{{$insurance->insurance_to_date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="brand" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="premium_payment_period">Premium Payment Period:</label>
                                                        <input class="form-control" type="text" name="premium_payment_period" id="premium_payment_period" value="{{$insurance->premium_payment_period ?? ''}}" required>
                                                    </div> -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="brand" value="{{$insurance->gst ?? ''}}" readonly>
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
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="brand" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="policy_image" class="form-label">View Insurance Policy</label>
                                                        <button type="button" class="btn btn-secondary mt-1 view-policy-btn">View</button>
                                                        
                                                    </div>
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
                                                    <hr style="border: #2A3F54 1px solid;">
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
        const $insuranceTypeDropdown = $('#insurance_type');
        const $additionalFields = $('#additionalFields');

        $additionalFields.hide();

        $insuranceTypeDropdown.on('change', function() {
            $('#insurance_type').val($(this).val());
            var selectedInsuranceTypeId = this.value;

            if (selectedInsuranceTypeId) {
                $.ajax({
                    url: '{{ route("insurance-type-status") }}',
                    method: 'GET',
                    data: {
                        id: selectedInsuranceTypeId
                    },
                    success: function(response) {
                        if (response.name === 'Fire' || response.name === 'fire') {
                            $additionalFields.show();
                        } else {
                            $additionalFields.hide();
                        }
                    },
                    error: function() {
                        console.error('Error fetching insurance type status');
                    }
                });
            } else {
                $additionalFields.hide();
            }
        });
        $('#insurance_type').trigger('change');
    });

    $(document).ready(function() {
        function calculateSum() {
            const building = parseFloat($('#building').val()) || 0;
            const plant_machinery = parseFloat($('#plant_machinery').val()) || 0;
            const stock = parseFloat($('#stock').val()) || 0;
            const electical = parseFloat($('#electical').val()) || 0;
            const furniture = parseFloat($('#furniture').val()) || 0;
            const other = parseFloat($('#other').val()) || 0;

            const sum = building + plant_machinery + stock + electical + furniture + other;

            $('#total_sum').val(sum);
        }

        $('#building, #plant_machinery, #stock, #electical, #furniture, #other').on('input', function() {
            calculateSum();
        });
    });
    $(document).ready(function() {
        $('.view-policy-btn').click(function() {
            var imageUrl = "{{ asset('storage/' . $insurance->policy_image) }}";
            window.open(imageUrl, '_blank');
        });
    });
</script>
@endpush