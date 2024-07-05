@extends('admin.layouts.header')
@section('title', isset($rcTransfer->id) ? 'Edit RC Transfer' : 'Add RC Transfer')
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
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">@if(isset($rcTransfer->id)) Edit @else Add @endif RC Transfer Car Loan</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.rc-transfer.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.loan.car-loan.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $carLoan->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control" disabled>
                                                            <option value="">Search By Name/Number</option>
                                                            @foreach($parties as $party)
                                                            <option value="{{ $party['id'] }}" {{ isset($carLoan->mst_party_id) && $carLoan->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                {{ $party['name'] }} ({{ $party['contacts'] }})
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="dob_date">Date of Birth:</label>
                                                        <input type="date" id="dob_date" name="dob_date" class="form-control" value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->dob_date)->format('Y-m-d') : old('dob_date') }}" readonly>
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
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status" class="form-control" disabled>
                                                            <!-- <option selected disabled="">Choose...</option> -->
                                                            @foreach ($status as $id => $label)
                                                            <option value="{{$id}}" @if(isset($carLoan) && $carLoan->status == $id) selected @endif>{{$label}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <hr style="border: #2A3F54 1px solid;">
                                                <h5>Loan And Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="login_date">Login Date:</label>
                                                        <input type="date" id="login_date" name="login_date" class="form-control" value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->login_date)->format('Y-m-d') : old('login_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="mst_model_id">Select Model</label>
                                                        <select name="mst_model_id" id="mst_model_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($models as $id => $model)
                                                            <option value="{{$id}}" {{ isset($carLoan->id) && $carLoan->mst_model_id == $id ? ' selected' : '' }}>{{strtoupper($model)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($carLoan)) {{$carLoan->manufacturing_year}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="registration_year">Registration Number:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if(isset($carLoan)) {{$carLoan->registration_year}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_amount">Loan Amount:</label>
                                                        <input type="text" id="loan_amount" name="loan_amount" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->loan_amount}}@else{{old('loan_amount')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="tenure">Tenure:</label>
                                                        <input type="text" id="tenure" name="tenure" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->tenure}}@else{{old('tenure')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="executive">Executive:</label>
                                                        <select name="executive" id="executive" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($carLoan->id) && $carLoan->executive == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="co_applicant">Co Applicant:</label>
                                                        <input type="text" id="co_applicant" name="co_applicant" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->co_applicant}}@else{{old('co_applicant')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="bank_id">Select Bank</label>
                                                        <select name="bank_id" id="bank_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($banks as $id => $dealer)
                                                            <option value="{{$id}}" {{ isset($carLoan->id) && $carLoan->bank_id == $id ? ' selected' : '' }}>{{strtoupper($dealer)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="vehicle_number">Vehicle Number:</label>
                                                        <input class="form-control" type="text" name="vehicle_number" id="vehicle_number" value="@if(isset($carLoan)) {{$carLoan->vehicle_number}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number_id">Policy Number</label>
                                                        <select name="policy_id" id="policy_number_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($policyNumbers as $id => $policy)
                                                            <option value="{{$id}}" {{ isset($carLoan->id) && $carLoan->policy_id == $id ? ' selected' : '' }}>{{$policy}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_company">Insurance Company:</label>
                                                        <select name="insurance_company" id="insurance_company" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($insurance as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($carLoan->insurance_company) && $carLoan->insurance_company == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_done_date">Insurance Done Date:</label>
                                                        <input type="date" id="insurance_done_date" name="insurance_done_date" class="form-control" value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_done_date)->format('Y-m-d') : old('insurance_done_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_from_date">Insurance From Date:</label>
                                                        <input type="date" id="insurance_from_date" name="insurance_from_date" class="form-control" value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_from_date)->format('Y-m-d') : old('insurance_from_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_to_date">Insurance To Date:</label>
                                                        <input type="date" id="insurance_to_date" name="insurance_to_date" class="form-control" value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_to_date)->format('Y-m-d') : old('insurance_to_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <!-- <hr style="border: #2A3F54 1px solid;">
                                                @if (isset($carLoan) && !empty($carLoan->approved_amount))
                                                <div class="row">
                                                    <div class="col-md-4 mt-3" id="approvedDateField">
                                                        <label for="approved_date">Approve Date:</label>
                                                        <input type="date" id="approved_date" name="approved_date" class="form-control" value="{{ $carLoan->approved_date ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3" id="approvedAmountField">
                                                        <label for="approved_amount">Approved Amount:</label>
                                                        <input class="form-control" type="text" name="approved_amount" id="approved_amount" value="{{ $carLoan->approved_amount ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                @endif -->
                                                <div id="approveFields" style="display: @if(isset($carLoan) && $carLoan->status == 2) block @else none @endif;">
                                                    <div class="row">
                                                        <div class="col-md-4 mt-3">
                                                            <label for="approved_date">Approve Date:</label>
                                                            <input type="date" id="approved_date" name="approved_date" class="form-control" value="{{ $carLoan->approved_date ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-3">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" name="approved_amount" id="approved_amount" value="{{ $carLoan->approved_amount ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div id="disbursedFields" style="display: @if(isset($carLoan) && $carLoan->status == 4) block @else none @endif;">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" value="{{ $carLoan->approved_amount ?? '' }}" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="tenure">Tenure:</label>
                                                            <input type="text" id="tenure" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->tenure}}@else{{old('tenure')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="roi">IRR/ROI:</label>
                                                            <input class="form-control" type="text" name="roi" id="roi" value="{{ $carLoan->roi ?? '' }}" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_amount">Disbursed Amount:</label>
                                                            <input class="form-control" type="text" name="disbursed_amount" id="disbursed_amount" value="{{ $carLoan->disbursed_amount ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="disbursed_date">Disbursed Date:</label>
                                                            <input type="date" id="disbursed_date" name="disbursed_date" class="form-control" value="{{ isset($carLoan) ? $carLoan->disbursed_date : old('disbursed_date') }}" readonly>
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_amount">EMI Amount:</label>
                                                            <input type="text" id="emi_amount" name="emi_amount" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->emi_amount}}@else{{old('emi_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="emi_advance">EMI Advance:</label>
                                                            <input type="text" id="emi_advance" name="emi_advance" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->emi_advance}}@else{{old('emi_advance')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="emi_start_date">EMI Start Date:</label>
                                                            <input type="date" id="emi_start_date" name="emi_start_date" class="form-control" value="{{ isset($carLoan) ? $carLoan->emi_start_date : old('emi_start_date') }}" readonly>
                                                        </div>
                                                        <div class=" col-md-4 mt-2">
                                                            <label for="emi_end_date">EMI End Date:</label>
                                                            <input type="date" id="emi_end_date" name="emi_end_date" class="form-control" value="{{ $carLoan->emi_end_date ?? '' }}" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="loan_number">Loan Number:</label>
                                                            <input type="text" id="loan_number" name="loan_number" class="form-control" value="@if(isset($carLoan->id)){{$carLoan->loan_number}}@else{{old('loan_number')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>RC Transfer Details</h5>
                                                <input type="hidden" name="rc_id" value="{{ $rcTransfer->id ?? null }}">
                                                <input type="hidden" name="rc_transfer" value="true">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="agent_id">Agent:</label>
                                                        <select name="agent_id" id="agent_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($agents as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->agent_id) && $value == $rcTransfer->agent_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="transfer_date">Transfer Date:</label>
                                                        <input type="date" id="transfer_date" name="transfer_date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->transfer_date)->format('Y-m-d') : old('transfer_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="date">Doc Given Date:</label>
                                                        <input type="date" id="date" name="date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->date)->format('Y-m-d') : old('date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="amount_paid">Amount Paid:</label>
                                                        <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="@if(isset($rcTransfer->id)){{$rcTransfer->amount_paid}}@else{{old('amount_paid')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Select Status:</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach($statusType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->status) && $rcTransfer->status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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
        $('select').selectize();
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
        $('#policy_number_id').change(function(e) {
            $('#policy_number_id').val($(this).val());
            var policy = this.value;

            $.ajax({
                url: '{{ route("fetch-insurance-data")}}',
                type: 'GET',
                data: {
                    policy: policy
                },
                success: function(response) {
                    // $('#insurance_company').val(response.insurance_company);
                    $('#insurance_done_date').val(response.insurance_done_date);
                    $('#insurance_from_date').val(response.insurance_from_date);
                    $('#insurance_to_date').val(response.insurance_to_date);
                    var selectize = $('#insurance_company')[0].selectize;
                    selectize.addOption({
                        value: response.icompany_id,
                        text: response.icompany_id
                    });
                    selectize.refreshOptions(false);
                    selectize.setValue(response.insurance_company);
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
