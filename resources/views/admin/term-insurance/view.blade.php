@extends('admin.layouts.header')
@section('title','View Term Insurance')
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
                                            <h5 class="pt-2 pb-2">View Term Insurance</h5>
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
                                            <form method="post" action="{{route('admin.term.insurance.store')}}" enctype="multipart/form-data">
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

                                                    <div class="col-md-4 mt-2">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" readonly>
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
                                                            @foreach (\App\Models\CarInsurance::odType() as $value => $vehicle)
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
                                                        <label for="premium_payment_period">Premium Payment Period:</label>
                                                        <input class="form-control" type="text" name="premium_payment_period" id="premium_payment_period" value="{{$insurance->premium_payment_period ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="brand" value="{{$insurance->premium ?? ''}}" readonly>
                                                    </div>
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="coverage_upto">Coverage Upto:</label>
                                                        <input class="form-control" type="text" name="coverage_upto" id="coverage_upto" value="{{$insurance->coverage_upto ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="brand" value="{{$insurance->policy_number ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4" readonly>@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
                                                    </div>
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
</script>
@endpush