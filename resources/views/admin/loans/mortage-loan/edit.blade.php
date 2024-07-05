@extends('admin.layouts.header')
@section('title', 'Edit Mortage Loan')
@section('content')
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="simple-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                <div class="row">
                                    <div class="col-12 col-sm-7">
                                        <h5 class="pt-2 pb-2">@if(isset($mortageLoan->id)) Edit @else Add @endif Mortage Loan</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{route('admin.loan.mortage-loan.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                            <i class="fa fa-arrow-left"></i> Back </a>
                                    </div>
                                </div>
                                <!-- <h4 class="card-title"><b><a href="{{route('admin.loan.mortage-loan.index')}}">Mortage Loan</a></b> / @if(isset($mortageLoan->id)) Edit @else Add @endif Mortage Loan</h4> -->
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.loan.mortage-loan.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $mortageLoan->id ?? null }}">

                                                <input type="hidden" name="mst_party_flag" id="mst_party_flag" value="">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control">
                                                            <option value="">Search By Name/Number</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($mortageLoan->mst_party_id) && $mortageLoan->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }} ({{ $party['contacts'] }})
                                                            </option>
                                                            @endforeach
                                                        </select>
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
                                                        <label for="executive">Executive:</label>
                                                        <select name="executive" id="executive" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($mortageLoan->id) && $mortageLoan->executive == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status" class="form-control{{ $type ? ' readonly' : '' }}" {{ $type ? 'disabled' : '' }}>
                                                            <!-- <option selected disabled="">Choose...</option> -->
                                                            @foreach ($status as $id => $label)
                                                            <option value="{{$id}}" @if(isset($mortageLoan) && $mortageLoan->status == $id) selected @endif>{{$label}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if (isset($mortageLoan) && !empty($mortageLoan->approved_amount))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Approve Status Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3" id="approvedDateField">
                                                        <label for="approved_date">Approve Date:</label>
                                                        <input type="date" id="approved_date" name="approved_date" class="form-control" value="{{ $mortageLoan->approved_date ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4 mt-3" id="approvedAmountField">
                                                        <label for="approved_amount">Approved Amount:</label>
                                                        <input class="form-control" type="text" name="approved_amount" id="approved_amount" value="{{ $mortageLoan->approved_amount ?? '' }}">
                                                    </div>
                                                </div>
                                                @endif
                                                <div id="approveFields" style="display: @if(isset($mortageLoan) && $mortageLoan->status == 2) block @else none @endif;">
                                                    <div class="row">
                                                        <div class="col-md-4 mt-3">
                                                            <label for="approved_date">Approve Date:</label>
                                                            <input type="date" id="approved_date" name="approved_date" class="form-control" value="{{ $mortageLoan->approved_date ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-3">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" name="approved_amount" id="approved_amount" value="{{ $mortageLoan->approved_amount ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="disbursedFields" class="disbursed-section" style="display: @if(isset($mortageLoan) && $mortageLoan->status == 4) block @else none @endif;">
                                                    @foreach($disbursedDetails as $index => $disbursedDetail)
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Disburse Status Details</h5>
                                                    <div class="row">
                                                        <input type="hidden" name="disbursed[{{ $index }}][id]" value="{{ $disbursedDetail->id }}">
                                                        <!-- <div class="col-md-4 mt-2">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" value="{{ $mortageLoan->approved_amount ?? '' }}" readonly>
                                                        </div> -->
                                                        <div class="col-md-4 mt-2">
                                                            <label for="loan_number">Loan Number:</label>
                                                            <input type="text" id="loan_number" name="disbursed[{{ $index }}][loan_number]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->loan_number}}@else{{old('loan_number')}}@endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_amount">Disbursement Amount:</label>
                                                            <input class="form-control" type="text" name="disbursed[{{ $index }}][disbursed_amount]" id="disbursed_amount_{{ $index }}" value="{{ $disbursedDetail->disbursed_amount ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_date">Disbursement Date:</label>
                                                            <input type="date" id="disbursed_date" name="disbursed[{{ $index }}][disbursed_date]" class="form-control" value="{{ isset($disbursedDetail) ? $disbursedDetail->disbursed_date : old('disbursed_date') }}"">
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="loan_amount">Loan Amount:</label>
                                                            <input type="text" id="loan_amount_{{ $index }}" name="disbursed[{{ $index }}][loan_amount]" class="form-control" value="@if(isset($mortageLoan)){{$mortageLoan->approved_amount}}@else{{old('approved_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_amount">EMI Amount:</label>
                                                            <input type="text" id="emi_amount" name="disbursed[{{ $index }}][emi_amount]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->emi_amount}}@else{{old('emi_amount')}}@endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="emi_start_date">EMI Start Date:</label>
                                                            <input type="date" id="emi_start_date_{{ $index }}" name="disbursed[{{ $index }}][emi_start_date]" class="form-control" value="{{ isset($disbursedDetail) ? $disbursedDetail->emi_start_date : old('emi_start_date') }}"" >
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_end_date">EMI End Date:</label>
                                                            <input type="date" id="emi_end_date_{{ $index }}" name="disbursed[{{ $index }}][emi_end_date]" class="form-control" value="{{ $disbursedDetail->emi_end_date ?? '' }}" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="roi">Base Rate:</label>
                                                            <input class="form-control" type="text" name="disbursed[{{ $index }}][roi]" id="roi_{{ $index }}" value="{{ $disbursedDetail->roi ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="margin">Margin:</label>
                                                            <input class="form-control" type="text" name="disbursed[{{ $index }}][margin]" id="margin_{{ $index }}" value="{{ $disbursedDetail->margin ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="effective">Effective:</label>
                                                            <input class="form-control" type="text" name="disbursed[{{ $index }}][effective]" id="effective_{{ $index }}" value="{{ $disbursedDetail->effective ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="property_mortage">Property Mortage:</label>
                                                            <textarea id="property_mortage" name="disbursed[{{ $index }}][property_mortage]" class="form-control" rows="4">@if(isset($disbursedDetail)) {{ $disbursedDetail->property_mortage }}@else{{ old('property_mortage') }}@endif</textarea>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="property_price">Property Price:</label>
                                                            <input class="form-control" type="text" name="disbursed[{{ $index }}][property_price]" id="property_price" value="{{ $disbursedDetail->property_price ?? '' }}">
                                                        </div>
                                                        <!-- <div class="col-md-4 mt-2">
                                                            <label for="emi_advance">EMI Advance:</label>
                                                            <input type="text" id="emi_advance" name="disbursed[{{ $index }}][emi_advance]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->emi_advance}}@else{{old('emi_advance')}}@endif">
                                                        </div> -->
                                                    </div>
                                                    @endforeach
                                                    <button type="button" id="addDisbursedSection" class="btn btn-sm btn-primary mt-3">+</button>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="loan_type">Select Loan Type:</label>
                                                        <select name="loan_type" id="loan_type" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($loanType as $value => $company)
                                                            <option value="{{$value}}" {{ isset($mortageLoan->id) && $mortageLoan->loan_type == $value ? ' selected' : '' }}>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="insurance_type">Select Subtype:</label>
                                                        <select name="insurance_type" id="subtype" class="form-control">
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_types as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($mortageLoan->id) && $mortageLoan->insurance_type == $value ? ' selected' : '' }}>{{($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="login_date">Login Date:</label>
                                                        <input type="date" id="login_date" name="login_date" class="form-control" value="{{ isset($mortageLoan) ? \Carbon\Carbon::parse($mortageLoan->login_date)->format('Y-m-d') : old('login_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_amount">Loan Amount:</label>
                                                        <input type="text" id="loan_amount" name="loan_amount" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->loan_amount}}@else{{old('loan_amount')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="tenure">Tenure:</label>
                                                        <input type="text" id="tenure" name="tenure" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->tenure}}@else{{old('tenure')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="bank_id">Select Bank</label>
                                                        <select name="bank_id" id="bank_id" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($banks as $id => $dealer)
                                                            <option value="{{$id}}" {{ isset($mortageLoan->id) && $mortageLoan->bank_id == $id ? ' selected' : '' }}>{{strtoupper($dealer)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status_date">Status Date:</label>
                                                        <input type="date" id="status_date" name="status_date" class="form-control" value="{{ isset($mortageLoan) ? \Carbon\Carbon::parse($mortageLoan->status_date)->format('Y-m-d') : old('status_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pending_documents">Pending Documents:</label>
                                                        <input type="text" id="pending_documents" name="pending_documents" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->pending_documents}}@else{{old('pending_documents')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="sanction_letter" class="form-label">Sanction Letter</label>
                                                        <input type="file" class="form-control" name="sanction_letter">
                                                        @if ($mortageLoan->sanction_letter)
                                                        <button type="button" class="btn btn-secondary mt-2 view-policy-btn">View</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <button type="submit" class="btn btn-primary mt-3" id="submitForm">Save</button>
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
        $('#status').selectize();
        $('#executive').selectize();
        $('#loan_type').selectize();
        $('#mst_party_id').selectize();
        $('#bank_id').selectize();
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
        function calculateTotal() {
            const premium = parseFloat($('#margin').val()) || 0;
            const gst = parseFloat($('#mclr').val()) || 0;

            const total = premium + gst;
            $('#effective_rate').val(total);
        }

        $('#margin, #mclr').on('input', function() {
            calculateTotal();
        });
    });

    $(document).ready(function() {
        $('#status').change(function() {
            var status = $(this).val();
            if (status == 4) {
                $('#disbursedFields').show();
            } else {
                $('#disbursedFields').hide();
            }

            if (status == 2) {
                $('#approveFields').show();
            } else {
                $('#approveFields').hide();
            }

            if (status != 2) {
                $('#approvedDateField').show();
                $('#approvedAmountField').show();
            } else {
                $('#approvedDateField').hide();
                $('#approvedAmountField').hide();
            }
        });

        $('#status').trigger('change');
    });

    $(document).ready(function() {
        $('#loan_type').change(function(e) {
            var selectedType = $(this).val();
            if (selectedType) {
                $.ajax({
                    url: '/get-subtypes',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'loan_type': selectedType,
                        'selected_subtype': $('#subtype').val()
                    },
                    success: function(response) {
                        $('#subtype').html(response);
                    },
                });
            } else {
                $('#subtype').html('<option selected disabled>Choose...</option>');
            }
        });
        $('#loan_type').trigger('change');
    });
    $(document).ready(function() {
        $(document).on('change', '[id^=emi_start_date_]', function() {
            var index = $(this).attr('id').split('_')[3];
            var startDate = new Date($(this).val());
            var tenure = parseInt($('#tenure').val());

            if (!isNaN(tenure) && startDate) {
                var endDate = new Date(startDate);
                endDate.setMonth(startDate.getMonth() + tenure);
                endDate.setDate(endDate.getDate() - 1); // Subtract one day
                var formattedEndDate = endDate.toISOString().slice(0, 10);
                $('#emi_end_date_' + index).val(formattedEndDate);
            }
        });
    });


    $(document).ready(function() {
        $(document).on('change', '[id^=roi_], [id^=margin_]', function() {
            var sectionIndex = $(this).attr('id').split('_')[1];
            var baseRate = parseFloat($('#roi_' + sectionIndex).val()) || 0;
            var margin = parseFloat($('#margin_' + sectionIndex).val()) || 0;
            var effectiveRate = baseRate + margin;
            $('#effective_' + sectionIndex).val(effectiveRate);
        });
    });

    $(document).ready(function() {
        $(document).on('input', '[id^=disbursed_amount_]', function() {
            var sectionIndex = $(this).attr('id').split('_')[2];
            var disbursedAmount = parseFloat($('#disbursed_amount_' + sectionIndex).val());
            var loanAmount = parseFloat($('#loan_amount_' + sectionIndex).val()) || 0;

            if (disbursedAmount > loanAmount) {
                $(this).val(loanAmount);
                toastr.error('Disbursement amount cannot exceed the loan amount.');
            }
        });
    });

    $(document).ready(function() {
        var sectionCounter = $('.disbursed-section').length;
        $('#addDisbursedSection').click(function() {
            sectionCounter++;
            var sectionHtml = `
            <div class="disbursed-section">
                <hr style="border: #2A3F54 1px solid;">
                <h5>Disburse Status Details</h5>
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="loan_number">Loan Number:</label>
                        <input type="text" id="loan_number" name="disbursed[${sectionCounter}][loan_number]" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="disbursed_amount">Disbursement Amount:</label>
                        <input class="form-control" type="text" name="disbursed[${sectionCounter}][disbursed_amount]" id="disbursed_amount_${sectionCounter}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="disbursed_date">Disbursement Date:</label>
                        <input type="date" id="disbursed_date" name="disbursed[${sectionCounter}][disbursed_date]" class="form-control">
                    </div>
                    <div class=" col-md-4 mt-2">
                        <label for="loan_amount">Loan Amount:</label>
                        <input type="text" id="loan_amount_${sectionCounter}" name="disbursed[${sectionCounter}][loan_amount]" class="form-control" value="@if(isset($mortageLoan)){{$mortageLoan->approved_amount}}@else{{old('approved_amount')}}@endif" readonly>
                    </div>
                    <div class=" col-md-4 mt-2">
                        <label for="emi_amount">EMI Amount:</label>
                        <input type="text" id="emi_amount" name="disbursed[${sectionCounter}][emi_amount]" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="emi_start_date">EMI Start Date:</label>
                        <input type="date" id="emi_start_date_${sectionCounter}" name="disbursed[${sectionCounter}][emi_start_date]" class="form-control">
                    </div>
                    <div class=" col-md-4 mt-2">
                        <label for="emi_end_date">EMI End Date:</label>
                        <input type="date" id="emi_end_date_${sectionCounter}" name="disbursed[${sectionCounter}][emi_end_date]" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="roi">Base Rate:</label>
                        <input class="form-control" type="text" name="disbursed[${sectionCounter}][roi]" id="roi_${sectionCounter}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="margin">Margin:</label>
                        <input class="form-control" type="text" name="disbursed[${sectionCounter}][margin]" id="margin_${sectionCounter}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="effective">Effective:</label>
                        <input class="form-control" type="text" name="disbursed[${sectionCounter}][effective]" id="effective_${sectionCounter}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="property_mortage">Property Mortage:</label>
                        <textarea id="property_mortage" name="disbursed[${sectionCounter}][property_mortage]" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="property_price">Property Price:</label>
                        <input class="form-control" type="text" name="disbursed[${sectionCounter}][property_price]" id="property_price">
                    </div>

                    <div class="col-md-2 mt-2">
                        <button type="button" class="btn btn-danger btn-sm remove-section">-</button>
                    </div>
                </div>
            </div>`;
            $('#disbursedFields').append(sectionHtml);
        });

        $(document).on('click', '.remove-section', function() {
            $(this).closest('.disbursed-section').remove();
        });
    });
    $(document).ready(function() {
        $('.view-policy-btn').click(function() {
            var imageUrl = "{{ asset('storage/' . $mortageLoan->sanction_letter) }}";
            window.open(imageUrl, '_blank');
        });
    });
</script>
@endpush