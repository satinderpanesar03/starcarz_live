@extends('admin.layouts.header')

@section('title', 'Mortage Loan')
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
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                @if (isset($mortageLoan) && !empty($mortageLoan->approved_amount))
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
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <div class="row">
                                                        <!-- <div class="col-md-4 mt-2">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" value="{{ $mortageLoan->approved_amount ?? '' }}" readonly>
                                                        </div> -->
                                                        <div class="col-md-4 mt-2">
                                                            <label for="tenure">Margin:</label>
                                                            <input class="form-control" type="text" name="disbursed[0][margin]" id="roi" value="{{ $mortageLoan->margin ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="roi">IRR/ROI:</label>
                                                            <input class="form-control" type="text" name="disbursed[0][roi]" id="roi" value="{{ $mortageLoan->roi ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_amount">Disbursement Amount:</label>
                                                            <input class="form-control" type="text" name="disbursed[0][disbursed_amount]" id="disbursed_amount" value="{{ $mortageLoan->disbursed_amount ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_date">Disbursement Date:</label>
                                                            <input type="date" id="disbursed_date" name="disbursed[0][disbursed_date]" class="form-control" value="{{ isset($mortageLoan) ? $mortageLoan->disbursed_date : old('disbursed_date') }}"">
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_amount">EMI Ammount:</label>
                                                            <input type="text" id="emi_amount" name="disbursed[0][emi_amount]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->emi_amount}}@else{{old('emi_amount')}}@endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="emi_advance">EMI Advance:</label>
                                                            <input type="text" id="emi_advance" name="disbursed[0][emi_advance]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->emi_advance}}@else{{old('emi_advance')}}@endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="emi_start_date">EMI Start Date:</label>
                                                            <input type="date" id="emi_start_date" name="disbursed[0][emi_start_date]" class="form-control" value="{{ isset($mortageLoan) ? $mortageLoan->emi_start_date : old('emi_start_date') }}"">
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_end_date">EMI End Date:</label>
                                                            <input type="date" id="emi_end_date" name="disbursed[0][emi_end_date]" class="form-control" value="{{ $mortageLoan->emi_end_date ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="loan_number">Loan Number:</label>
                                                            <input type="text" id="loan_number" name="disbursed[0][loan_number]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->loan_number}}@else{{old('loan_number')}}@endif">
                                                        </div>
                                                    </div>
                                                    <button type="button" id="addDisbursedSection" class="btn btn-sm btn-primary mt-3">+</button>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Save</button>
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
        $('#emi_start_date, #tenure').change(function() {
            var startDate = new Date($('#emi_start_date').val());
            var tenure = parseInt($('#tenure').val());

            if (!isNaN(tenure) && startDate) {
                var endDate = new Date(startDate.setFullYear(startDate.getFullYear() + tenure));
                var formattedEndDate = endDate.toISOString().slice(0, 10);
                $('#emi_end_date').val(formattedEndDate);
            }
        });
    });

    $(document).ready(function() {
        // Add section
        var sectionCounter = 0;
        $('#addDisbursedSection').click(function() {
            sectionCounter++;
            var sectionHtml = `
        <div class="disbursed-section">
            <hr style="border: #2A3F54 1px solid;">
            <div class="row">
                <div class="col-md-4 mt-2">
                 <label for="tenure">Tenure:</label>
                <select name="disbursed[${sectionCounter}][tenure]" id="tenure" class="form-control">
                <option value="">Choose...</option>
                        @foreach($tenures as $value => $label)
                        <option value="{{ $value }}" {{ isset($mortageLoan->tenure) && $mortageLoan->tenure == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <label for="roi">IRR/ROI:</label>
                    <input class="form-control" type="text" name="disbursed[${sectionCounter}][roi]" id="roi" value="{{ $mortageLoan->roi ?? '' }}">
                </div>
                <div class="col-md-4 mt-2">
                    <label for="disbursed_amount">Disbursement Amount:</label>
                    <input class="form-control" type="text" name="disbursed[${sectionCounter}][disbursed_amount]" id="disbursed_amount" value="{{ $mortageLoan->disbursed_amount ?? '' }}">
                </div>
                <div class="col-md-4 mt-2">
                    <label for="disbursed_date">Disbursement Date:</label>
                    <input type="date" id="disbursed_date" name="disbursed[${sectionCounter}][disbursed_date]" class="form-control" value="{{ isset($mortageLoan) ? $mortageLoan->disbursed_date : old('disbursed_date') }}"">
                </div>
                <div class=" col-md-4 mt-2">
                    <label for="emi_amount">EMI Ammount:</label>
                    <input type="text" id="emi_amount" name="disbursed[${sectionCounter}][emi_amount]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->emi_amount}}@else{{old('emi_amount')}}@endif">
                </div>
                <div class="col-md-4 mt-2">
                    <label for="emi_advance">EMI Advance:</label>
                    <input type="text" id="emi_advance" name="disbursed[${sectionCounter}][emi_advance]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->emi_advance}}@else{{old('emi_advance')}}@endif">
                </div>
                <div class="col-md-4 mt-2">
                    <label for="emi_start_date">EMI Start Date:</label>
                           <input type="date" id="emi_start_date" name="disbursed[${sectionCounter}][emi_start_date]" class="form-control" value="{{ isset($mortageLoan) ? $mortageLoan->emi_start_date : old('emi_start_date') }}"">
                       </div>
                       <div class=" col-md-4 mt-2">
                           <label for="emi_end_date">EMI End Date:</label>
                           <input type="date" id="emi_end_date" name="disbursed[${sectionCounter}][emi_end_date]" class="form-control" value="{{ $mortageLoan->emi_end_date ?? '' }}">
                       </div>
                    <div class="col-md-4 mt-2">
                    <label for="loan_number">Loan Number:</label>
                    <input type="text" id="loan_number" name="disbursed[${sectionCounter}][loan_number]" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->loan_number}}@else{{old('loan_number')}}@endif">
                </div>

                <div class="col-md-2 mt-2">
                    <button type="button" class="btn btn-danger btn-sm remove-section">-</button>
                </div>
            </div>
        </div>`;
            $('#disbursedFields').append(sectionHtml);
        });

        // Remove section
        $(document).on('click', '.remove-section', function() {
            $(this).closest('.disbursed-section').remove();
        });
    });
</script>
@endpush
