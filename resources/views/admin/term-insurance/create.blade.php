@extends('admin.layouts.header')
@section('title', isset($insurance->id) ? 'Edit Term Insurance' :'Add Term Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif Term Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.term.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.term.insurance.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                @if (!empty($renewal) && $renewal == 1)
                                                <input type="hidden" name="renewal" value="true">
                                                @endif
                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($carLoan->mst_party_id) && $carLoan->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }}

                                                                @if ($party['father_name'])
                                                                    S/O <span style="color: green;">{{ ucfirst($party['father_name']) }}</span>
                                                                @endif

                                                                @if ($party['contacts'])
                                                                ({{ $party['contacts'] }})
                                                                @endif

                                                            </option>
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
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control">
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
                                                        <select name="insurance_company" id="vehicle_number" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_company as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->insurance_company == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="insurance_type">Select Insurance Type:</label>
                                                        <select name="insurance_type" id="insurance_type" class="form-control" required>
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::odType() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->insurance_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="insurance_done_by">Insurance Done By:</label>
                                                        <select name="insurance_done_by" id="insurance_done_by" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach (\App\Models\CarInsurance::InsuranceBy() as $value => $item)
                                                            <option @if(isset($insurance) && $insurance->insurance_done_by == $value) selected @endif value="{{$value}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="brand" value="{{ old('insurance_done_date', $insurance->insurance_done_date ?? '') }}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="insurance_from_date" value="{{old('insurance_from_date',$insurance->insurance_from_date ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="insurance_to_date" value="{{old('insurance_to_date',$insurance->insurance_to_date ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="premium_payment_period">Premium Payment Period:</label>
                                                        <input class="form-control" type="text" name="premium_payment_period" id="premium_payment_period" value="{{old('premium_payment_period',$insurance->premium_payment_period ?? '')}}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="sum_insured">Sum Insured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{old('sum_insured',$insurance->sum_insured ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="premium" value="{{old('premium',$insurance->premium ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="gst" value="{{old('gst',$insurance->gst ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="total">Total:</label>
                                                        <input class="form-control" type="text" name="total" id="total" value="{{$insurance->total ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="coverage_upto">Coverage Upto:</label>
                                                        <input class="form-control" type="text" name="coverage_upto" id="coverage_upto" value="{{old('coverage_upto',$insurance->coverage_upto ?? '')}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="brand" value="{{$insurance->policy_number ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4">@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
                                                    </div>
                                                </div>
                                                @if(!empty($endorsement))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Endorsement Insurance Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="survyour_name">Date:</label>
                                                        <input class="form-control" type="date" name="date" id="date" value="{{$endorsement->date ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="contact_number">Sum Assured:</label>
                                                        <input class="form-control" type="text" name="sum_assured" id="contact_number" value="{{$endorsement->sum_assured ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="dealer">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="dealer" value="{{$endorsement->premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="endorsement_details">Endorsement Detail:</label>
                                                        <textarea id="endorsement_details" name="endorsement_details" class="form-control" rows="4" readonly>@if(isset($endorsement->id)) {{ $endorsement->endorsement_details }}@else{{ old('endorsement_details') }}@endif</textarea>
                                                    </div>
                                                </div>
                                                @endif
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
    $(document).ready(function() {
        function calculateTotal() {
            const premium = parseFloat($('#premium').val()) || 0;
            const gst = parseFloat($('#gst').val()) || 0;

            const total = premium + gst;
            $('#total').val(total);
        }

        $('#premium, #gst').on('input', function() {
            calculateTotal();
        });
    });

    $(document).ready(function() {
        $('#insurance_from_date').change(function() {
            var fromDate = new Date($(this).val());
            var toDate = new Date(fromDate.setFullYear(fromDate.getFullYear() + 1));
            var formattedToDate = toDate.toISOString().slice(0, 10);
            $('#insurance_to_date').val(formattedToDate);
        });
    });
</script>
@endpush
