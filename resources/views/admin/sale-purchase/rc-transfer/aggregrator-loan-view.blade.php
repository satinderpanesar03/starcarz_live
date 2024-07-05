@extends('admin.layouts.header')
@section('title', 'View RC Transfer')
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
                                            <h5 class="pt-2 pb-2">View RC Transfer</h5>
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
                                            <form method="post" action="{{route('admin.loan.aggregrator-loan.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $aggregratorLoan->id ?? null }}">
                                                <div class="row">
                                                    <input type="hidden" value="1" name="party_id">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->firm_name}}@else{{old('firm_name')}}@endif" readonly>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="person_name">Name:</label>
                                                        <input type="text" id="person_name" name="person_name" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->person_name}}@else{{old('person_name')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Phone:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->contact_number}}@else{{old('contact_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->address}}@else{{old('address')}}@endif" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-4 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->city}}@else{{old('city')}}@endif">
                                                    </div> -->
                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->email}}@else{{old('email')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Loan And Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <span class="text">Purchase/Refinance</span>
                                                        <select class="form-control" name="type" id="type" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            <option value="1" {{ isset($aggregratorLoan) && $aggregratorLoan->type == '1' ? 'selected' : '' }}>Purchase</option>
                                                            <option value="2" {{ isset($aggregratorLoan) && $aggregratorLoan->type == '2' ? 'selected' : '' }}>Refinance</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="vehicle_number">Car:</label>
                                                        <input class="form-control" type="text" name="vehicle_number" id="vehicle_number" value="@if(isset($aggregratorLoan)) {{$aggregratorLoan->vehicle_number}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="model">Model:</label>
                                                        <input class="form-control" type="text" name="model" id="model" value="@if(isset($aggregratorLoan)) {{$aggregratorLoan->model}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="year">Year:</label>
                                                        <input type="text" id="year" name="year" class="form-control" value="@if(isset($aggregratorLoan)) {{$aggregratorLoan->year}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="bank_id">Bank:</label>
                                                        <select name="bank_id" id="bank_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($banks as $id => $dealer)
                                                            <option value="{{$id}}" {{ isset($aggregratorLoan->id) && $aggregratorLoan->bank_id == $id ? ' selected' : '' }}>{{strtoupper($dealer)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_number">Loan Number:</label>
                                                        <input type="text" id="loan_number" name="loan_number" class="form-control" value="@if(isset($aggregratorLoan)) {{$aggregratorLoan->loan_number}} @endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_amount">Loan Amount:</label>
                                                        <input type="text" id="loan_amount" name="loan_amount" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->loan_amount}}@else{{old('loan_amount')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Ploicy Number:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->policy_number}}@else{{old('policy_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="executive">Executive Name & Number:</label>
                                                        <select name="executive" id="executive" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($executives as $value => $party)
                                                            <option value="{{$value}}" {{ isset($aggregratorLoan->id) && $aggregratorLoan->executive == $value ? ' selected' : '' }}>{{$party}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_company">Ins Company Name & Address:</label>
                                                        <select name="insurance_company" id="insurance_company" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($insurance as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($aggregratorLoan->insurance_company) && $aggregratorLoan->insurance_company == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_valid_date">Insurance Valid Up To:</label>
                                                        <input type="date" id="insurance_valid_date" name="insurance_valid_date" class="form-control" value="{{ isset($aggregratorLoan) ? \Carbon\Carbon::parse($aggregratorLoan->insurance_valid_date)->format('Y-m-d') : old('insurance_valid_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="idv">IDV:</label>
                                                        <input type="text" id="idv" name="idv" class="form-control" value="@if(isset($aggregratorLoan->id)){{$aggregratorLoan->idv}}@else{{old('idv')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>RC Transfer Details</h5>
                                                <input type="hidden" name="rc_id" value="{{ $rcTransfer->id ?? null }}">
                                                <input type="hidden" name="rc_transfer" value="true">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="agent_id">Agent:</label>
                                                        <select name="agent_id" id="agent_id" class="form-control" disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($agents as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->agent_id) && $value == $rcTransfer->agent_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="transfer_date">Transfer Date:</label>
                                                        <input type="date" id="transfer_date" name="transfer_date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->transfer_date)->format('Y-m-d') : old('transfer_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="date">Doc Given Date:</label>
                                                        <input type="date" id="date" name="date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->date)->format('Y-m-d') : old('date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="amount_paid">Amount Paid:</label>
                                                        <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="@if(isset($rcTransfer->id)){{$rcTransfer->amount_paid}}@else{{old('amount_paid')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Select Status:</label>
                                                        <select name="status" id="status" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach($statusType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->status) && $rcTransfer->status == $value ? 'selected' : '' }}>{{ $label }}</option>
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
</script>
@endpush