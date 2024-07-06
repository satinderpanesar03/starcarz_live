@extends('admin.layouts.header')
@section('title', isset($insurance->id) ? 'Edit General Insurance' :'Add General Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif General Insurance</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.general.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.general.insurance.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                @if (!empty($renewal) && $renewal == 1)
                                                <input type="hidden" name="renewal" value="true">
                                                @endif
                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control">
                                                            <option value="">Search By Name/Number</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($insurance->party_id) && $insurance->party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }} ({{ $party['contacts'] }})
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div data-toggle="modal" data-target="#addParty" class="input-group-append">
                                                            <button class="btn btn-outline-primary btn-field-height" type="button">+</button>
                                                        </div>
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
                                                        <select name="insurance_type" id="insurance_type" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($insurance_types as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($insurance->id) && $insurance->insurance_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="vehicle_number">Insurance Done By:</label>
                                                        <select name="vehicle_number" id="vehicle_number" class="form-control">
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
                                                        <input class="form-control" type="date" name="insurance_done_date" id="brand" value="{{$insurance->insurance_done_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance From date:</label>
                                                        <input class="form-control" type="date" name="insurance_from_date" id="insurance_from_date" value="{{$insurance->insurance_from_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Insurance To date:</label>
                                                        <input class="form-control" type="date" name="insurance_to_date" id="insurance_to_date" value="{{$insurance->insurance_to_date ?? ''}}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_brand_type_id">Policy Number:</label>
                                                        <input class="form-control" type="text" name="policy_number" id="brand" value="{{$insurance->policy_number ?? ''}}" required>
                                                    </div>
                                                    <!-- <div class="col-md-3 mt-3">
                                                        <label for="premium_payment_period">Premium Payment Period:</label>
                                                        <input class="form-control" type="text" name="premium_payment_period" id="premium_payment_period" value="{{$insurance->premium_payment_period ?? ''}}" required>
                                                    </div> -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="sum_insured">Sum Insured:</label>
                                                        <input class="form-control" type="text" name="sum_insured" id="sum_insured" value="{{$insurance->sum_insured ?? ''}}" required>
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
                                                        <label for="total">Total:</label>
                                                        <input class="form-control" type="text" name="total" id="total" value="{{$insurance->total ?? ''}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="policy_image" class="form-label">Insurance Policy</label>
                                                        <input type="file" class="form-control" name="policy_image" @if(!isset($insurance)) required @endif>
                                                        @if(isset($insurance->policy_image))
                                                        <div class="mt-1">
                                                            <span><a href="{{ asset('storage/' . $insurance->policy_image) }}" target="_blank" class="btn btn-sm">View</a></span>
                                                            <span><a href="{{route('admin.remove.uploaded.image',['general_insurances',$insurance->id,'policy_image'])}}" class="btn btn-sm danger">Remove</a></span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="coverage_detail">Coverge Detail:</label>
                                                        <textarea id="coverage_detail" name="coverage_detail" class="form-control" rows="4">@if(isset($insurance->id)) {{ $insurance->coverage_detail }}@else{{ old('coverage_detail') }}@endif</textarea>
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
                                                            <input type="text" id="building" name="building" class="form-control" value="@if(isset($insurance->id)){{$insurance->building}}@else{{old('building')}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Plant and machinery:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="plant_machinery" name="plant_machinery" class="form-control" value="@if(isset($insurance->id)){{$insurance->plant_machinery}}@else{{old('plant_machinery')}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Stock:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="stock" name="stock" class="form-control" value="@if(isset($insurance->id)){{$insurance->stock}}@else{{old('stock')}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Electrical fittings:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="electical" name="electical" class="form-control" value="@if(isset($insurance->id)){{$insurance->electical}}@else{{old('electical')}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Furniture:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="furniture" name="furniture" class="form-control" value="@if(isset($insurance->id)){{$insurance->furniture}}@else{{old('furniture')}}@endif">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="other" name="other" class="form-control" value="@if(isset($insurance->id)){{$insurance->other}}@else{{old('other')}}@endif">
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
                                                    @if(!empty($endorsement))
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
                            <!-- <label for="party_name">Party Name</label>  -->
                            <input type="text" placeholder="Party Name" name="party_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="firm_name">Firm Name</label> -->
                            <input type="text" placeholder="Firm Name" name="firm_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <input type="number" placeholder="Whatsapp Number" name="whatsapp_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <!-- <label for="office_address">Office Address</label> -->
                            <input type="text" placeholder="Office Address" name="office_address" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <!-- <label for="email">Email</label> -->
                            <input type="text" placeholder="Email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <!-- <label for="residence_city">Residence City</label> -->
                            <input type="text" placeholder="Residence City" name="residence_city" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <!-- <label for="office_number">Office Number</label> -->
                            <input type="number" placeholder="Office Number" name="office_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <!-- <label for="office_city">Office City</label> -->
                            <input type="text" placeholder="Office City" name="office_city" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <!-- <label for="residence_address">Residence Address</label> -->
                            <input type="text" placeholder="Residence Address" name="residence_address" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <!-- <label for="pan_number">Pan Number</label> -->
                            <input type="text" placeholder="Pan Number" name="pan_number" class="form-control" required>
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
        // Get the insurance type dropdown and the additional fields container
        const $insuranceTypeDropdown = $('#insurance_type');
        const $additionalFields = $('#additionalFields');

        // Initially hide the additional fields
        $additionalFields.hide();

        // Event handler for the dropdown change event
        $insuranceTypeDropdown.on('change', function() {
            // Get the selected insurance type ID
            $('#insurance_type').val($(this).val());
            var selectedInsuranceTypeId = this.value;

            if (selectedInsuranceTypeId) {
                // Make an AJAX request to fetch the status of the selected insurance type
                $.ajax({
                    url: '{{ route("insurance-type-status") }}',
                    method: 'GET',
                    data: {
                        id: selectedInsuranceTypeId
                    },
                    success: function(response) {
                        // If the status is 1, show the additional fields; otherwise, hide them
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
                // If no option is selected, hide the additional fields
                $additionalFields.hide();
            }
        });
        $('#insurance_type').trigger('change');
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
            $('#sum_insured').val(sum);
        }

        // Attach the event handler to the input fields
        $('#building, #plant_machinery, #stock, #electical, #furniture, #other').on('input', function() {
            // Call the function to calculate the sum whenever the input fields change
            calculateSum();
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
            var toDate = new Date(fromDate);
            toDate.setFullYear(fromDate.getFullYear() + 1);
            toDate.setDate(toDate.getDate() - 1);
            var formattedToDate = toDate.toISOString().slice(0, 10);
            $('#insurance_to_date').val(formattedToDate);
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
