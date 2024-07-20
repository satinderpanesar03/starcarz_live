@extends('admin.layouts.header')
@section('title','Edit Health Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($refurbishment->id)) Edit @else Add @endif Health Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.health.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.health.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                @if (!empty($renewal) && $renewal == 1)
                                                <input type="hidden" name="renewal" value="true">
                                                @endif
                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">
                                                    <input type="hidden" value="1" name="mst_executive_id">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_executive_id">Party</label>
                                                        <select name="party_id" id="mst_party_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{$party->id}}" {{ isset($insurance) && $insurance->party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
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
                                                        <label for="contact_number">Executive:</label>
                                                        <select name="executive_id" id="executive_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->executive_id == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance Details</h5>
                                                <div class="row">
                                                    <div class="col-md-5 mt-3">
                                                        <div class="form-group mb-2">
                                                            <label class="mr-2">Member Name:</label>
                                                            <div class="form-group mb-2 d-flex">
                                                                <div class="controls flex-grow-1">
                                                                    <div class="row">
                                                                        <div class="col-sm-10" id="member-names-container">
                                                                            @if ($insurance->memberName)
                                                                            @foreach ($insurance->memberName as $city)
                                                                            <div class="input-group mt-2 member-name-input-group">
                                                                                <input type="text" name="member_names[]" class="form-control" placeholder="Enter Member Name" value="{{ $city->member_name }}" required>
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-outline-danger remove-member" type="button">-</button>
                                                                                </div>
                                                                            </div>
                                                                            @endforeach
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <button id="addCity" class="btn btn-outline-primary" type="button">+</button>
                                                                        </div>
                                                                    </div>
                                                                    <div id="appendCity"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Member Name:</label>
                                                        <input class="form-control" type="text" name="member_name" id="member_name" value="{{$insurance->member_name ?? ''}}" required>
                                                    </div> -->
                                                    <div class="col-md-3 mt-3">
                                                        <label for="start_date">Insurance done date:</label>
                                                        <input class="form-control" type="date" name="insurance_done_date" id="insurance_done_date" value="{{$insurance->insurance_done_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="start_date">Start Date:</label>
                                                        <input class="form-control" type="date" name="start_date" id="start_date" value="{{$insurance->start_date ?? ''}}">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">End Date:</label>
                                                        <input class="form-control" type="date" name="end_date" id="end_date" value="{{$insurance->end_date ?? ''}}">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="policy_number" value="{{$insurance->policy_number ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Sum Assured:</label>
                                                        <input class="form-control" type="number" name="sum_assured" id="sum_assured" value="{{$insurance->sum_assured ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Premium:</label>
                                                        <input class="form-control" type="text" name="premium" id="premium" value="{{$insurance->premium ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Gst:</label>
                                                        <input class="form-control" type="number" name="gst" id="gst" value="{{$insurance->gst ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="gross_premium">Gross Premium:</label>
                                                        <input class="form-control" type="text" name="gross_premium" id="gross_premium" value="{{$insurance->gross_premium ?? ''}}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="policy_image" class="form-label">Insurance Policy</label>
                                                        <input type="file" class="form-control" name="policy_image">
                                                        @if(isset($insurance->policy_image))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $insurance->policy_image) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['health_insurances',$insurance->id,'policy_image'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Company:</label>
                                                        <select name="insurance_company_id" id="insurance_company_id" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_company as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->insurance_company_id == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance Type:</label>
                                                        <select name="sub_type_id" id="insurance_company" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($subTypes as $value => $company)
                                                            <option value="{{$value}}" @if(isset($insurance) && $insurance->sub_type_id == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Hospital Name:</label>
                                                        <input class="form-control" type="text" name="hospital_name" id="hospital_name" value="{{$insurance->hospital_name ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Claim Amount:</label>
                                                        <input class="form-control" type="number" name="claim_amount" id="claim_amount" value="{{$insurance->claim_amount ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Status:</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach (\App\Models\HealthInsurance::status() as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance) && $insurance->status == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
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
            deferRender: true,
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
    });

    $(document).ready(function() {
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
        function calculateTotal() {
            const premium = parseFloat($('#premium').val()) || 0;
            const gst = parseFloat($('#gst').val()) || 0;

            const total = premium + gst;
            $('#gross_premium').val(total);
        }
        $('#premium, #gst').on('input', function() {
            calculateTotal();
        });

        $('#addCity').on('click', function() {
            var newInput = '<div class="row mt-2">' +
                '<div class="col-sm-10">' +
                '<input type="text" name="member_names[]" class="form-control" required data-validation-containsnumber-regex="(\d)+">' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<button class="btn btn-outline-danger removeInput" type="button">-</button>' +
                '</div>' +
                '</div>';
            $('#appendCity').append(newInput);
        });

        $('#appendCity').on('click', '.removeInput', function() {
            $(this).closest('.row').remove();
        });
    });

    $(document).ready(function() {
        $('#start_date').change(function() {
            var fromDate = new Date($(this).val());
            var toDate = new Date(fromDate.setFullYear(fromDate.getFullYear() + 1));
            var formattedToDate = toDate.toISOString().slice(0, 10);
            $('#end_date').val(formattedToDate);
        });
    });
    $(document).ready(function() {
        // Add event listener to handle removal of input field
        $(document).on('click', '.remove-member', function() {
            $(this).closest('.member-name-input-group').remove();
        });
    });
    $(document).ready(function() {
        // Check if an image is already uploaded
        var policyImageUploaded = '{{ isset($insurance) ? "true" : "false" }}';
        // If an image is not already uploaded, add the required attribute
        if (policyImageUploaded === 'false') {
            $('#policy_image').attr('required', 'required');
        }
    });
</script>
@endpush
