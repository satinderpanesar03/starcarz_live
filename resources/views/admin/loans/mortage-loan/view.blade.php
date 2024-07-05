@extends('admin.layouts.header')

@section('title', 'View Mortage Loan')
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
                                        <h5 class="pt-2 pb-2">View Mortage Loan</h5>
                                    </div>
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="#" class="btn btn-sm btn-primary px-3 py-1" onclick="window.history.back();">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form>
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $mortageLoan->id ?? null }}">

                                                <input type="hidden" name="mst_party_flag" id="mst_party_flag" value="">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="mst_party_id" id="mst_party_id" class="form-control" disabled>
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{$party->id}}" {{ isset($mortageLoan->id) && $mortageLoan->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
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
                                                        <select name="executive" id="executive" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($executives as $id => $label)
                                                            <option value="{{$id}}" @if(isset($mortageLoan) && $mortageLoan->executive == $id) selected @endif>{{$label}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($status as $id => $label)
                                                            <option value="{{$id}}" @if(isset($mortageLoan) && $mortageLoan->status == $id) selected @endif>{{$label}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="mst_brand_type_id">Select Loan Type:</label>
                                                        <select name="loan_type" id="vehicle_number" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($loanType as $value => $company)
                                                            <option value="{{$value}}" @if(isset($mortageLoan) && $mortageLoan->loan_type == $value) selected @endif>{{$company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="insurance_type">Select Insurance Type:</label>
                                                        <select name="insurance_type" id="insurance_type" class="form-control" disabled>
                                                            <option selected disabled="">Choose...</option>
                                                            @foreach ($insurance_types as $value => $vehicle)
                                                            <option value="{{$value}}" {{ isset($mortageLoan->id) && $mortageLoan->insurance_type == $value ? ' selected' : '' }}>{{strtoupper($vehicle)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="login_date">Login Date:</label>
                                                        <input type="date" id="login_date" name="login_date" class="form-control" value="{{ isset($mortageLoan) ? \Carbon\Carbon::parse($mortageLoan->login_date)->format('Y-m-d') : old('login_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_amount">Loan Amount:</label>
                                                        <input type="text" id="loan_amount" name="loan_amount" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->loan_amount}}@else{{old('loan_amount')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="tenure">Tenure:</label>
                                                        <input type="text" id="tenure" name="tenure" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->tenure}}@else{{old('tenure')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="bank_id">Select Bank</label>
                                                        <select name="bank_id" id="bank_id" class="form-control" disabled>
                                                            <option value="">Choose...</option>
                                                            @foreach ($banks as $id => $dealer)
                                                            <option value="{{$id}}" {{ isset($mortageLoan->id) && $mortageLoan->bank_id == $id ? ' selected' : '' }}>{{strtoupper($dealer)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status_date">Status Date:</label>
                                                        <input type="date" id="status_date" name="status_date" class="form-control" value="{{ isset($mortageLoan) ? \Carbon\Carbon::parse($mortageLoan->status_date)->format('Y-m-d') : old('status_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="pending_documents">Pending Documents:</label>
                                                        <input type="text" id="pending_documents" name="pending_documents" class="form-control" value="@if(isset($mortageLoan->id)){{$mortageLoan->pending_documents}}@else{{old('pending_documents')}}@endif" readonly>
                                                    </div>
                                                    @if ($mortageLoan->sanction_letter)
                                                    <div class="col-md-3 mt-2">
                                                        <label for="sanction_letter" class="form-label">View Sanction Letter</label>
                                                        <button type="button" class="btn btn-secondary mt-1 view-policy-btn">View</button>
                                                    </div>
                                                    @endif
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                @if (isset($mortageLoan) && !empty($mortageLoan->approved_amount))
                                                <div class="row">
                                                    <div class="col-md-4 mt-3" id="approvedDateField">
                                                        <label for="approved_date">Approve Date:</label>
                                                        <input type="date" id="approved_date" name="approved_date" class="form-control" value="{{ $mortageLoan->approved_date ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3" id="approvedAmountField">
                                                        <label for="approved_amount">Approved Amount:</label>
                                                        <input class="form-control" type="text" name="approved_amount" id="approved_amount" value="{{ $mortageLoan->approved_amount ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                @endif
                                                @foreach($disbursedDetails as $index => $disbursedDetail)
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <input type="hidden" name="disbursed[{{ $index }}][id]" value="{{ $disbursedDetail->id }}">
                                                    <!-- <div class="col-md-4 mt-2">
                                                            <label for="approved_amount">Approved Amount:</label>
                                                            <input class="form-control" type="text" value="{{ $mortageLoan->approved_amount ?? '' }}" readonly>
                                                        </div> -->
                                                    <div class="col-md-4 mt-2">
                                                        <label for="margin">Margin:</label>
                                                        <input class="form-control" type="text" name="disbursed[{{ $index }}][margin]" id="margin" value="{{ $disbursedDetail->margin ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="loan_number">Loan Number:</label>
                                                        <input type="text" id="loan_number" name="disbursed[{{ $index }}][loan_number]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->loan_number}}@else{{old('loan_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="disbursed_amount">Disbursement Amount:</label>
                                                        <input class="form-control" type="text" name="disbursed[{{ $index }}][disbursed_amount]" id="disbursed_amount" value="{{ $disbursedDetail->disbursed_amount ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="disbursed_date">Disbursement Date:</label>
                                                        <input type="date" id="disbursed_date" name="disbursed[{{ $index }}][disbursed_date]" class="form-control" value="{{ isset($disbursedDetail) ? $disbursedDetail->disbursed_date : old('disbursed_date') }}" readonly>
                                                    </div>
                                                    <div class=" col-md-4 mt-2">
                                                        <label for="loan_amount">Loan Amount:</label>
                                                        <input type="text" id="loan_amount" name="disbursed[{{ $index }}][loan_amount]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->loan_amount}}@else{{old('emi_amount')}}@endif" readonly>
                                                    </div>
                                                    <div class=" col-md-4 mt-2">
                                                        <label for="emi_amount">EMI Amount:</label>
                                                        <input type="text" id="emi_amount" name="disbursed[{{ $index }}][emi_amount]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->emi_amount}}@else{{old('emi_amount')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="emi_start_date">EMI Start Date:</label>
                                                        <input type="date" id="emi_start_date_{{ $index }}" name="disbursed[{{ $index }}][emi_start_date]" class="form-control" value="{{ isset($disbursedDetail) ? $disbursedDetail->emi_start_date : old('emi_start_date') }}" readonly>
                                                    </div>
                                                    <div class=" col-md-4 mt-2">
                                                        <label for="emi_end_date">EMI End Date:</label>
                                                        <input type="date" id="emi_end_date_{{ $index }}" name="disbursed[{{ $index }}][emi_end_date]" class="form-control" value="{{ $disbursedDetail->emi_end_date ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="roi">Base Rate:</label>
                                                        <input class="form-control" type="text" name="disbursed[{{ $index }}][roi]" id="roi" value="{{ $disbursedDetail->roi ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="effective">Effective:</label>
                                                        <input class="form-control" type="text" name="disbursed[{{ $index }}][effective]" id="roi" value="{{ $disbursedDetail->effective ?? '' }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="property_mortage">Property Mortage:</label>
                                                        <textarea id="property_mortage" name="disbursed[{{ $index }}][property_mortage]" class="form-control" rows="4" readonly>@if(isset($disbursedDetail)) {{ $disbursedDetail->property_mortage }}@else{{ old('property_mortage') }}@endif</textarea>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="property_price">Property Price:</label>
                                                        <input class="form-control" type="text" name="disbursed[{{ $index }}][property_price]" id="property_price" value="{{ $disbursedDetail->property_price ?? '' }}" readonly>
                                                    </div>
                                                    <!-- <div class="col-md-4 mt-2">
                                                            <label for="emi_advance">EMI Advance:</label>
                                                            <input type="text" id="emi_advance" name="disbursed[{{ $index }}][emi_advance]" class="form-control" value="@if(isset($disbursedDetail)){{$disbursedDetail->emi_advance}}@else{{old('emi_advance')}}@endif">
                                                        </div> -->

                                                </div>
                                                @endforeach
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
        $('.view-policy-btn').click(function() {
            var imageUrl = "{{ asset('storage/' . $mortageLoan->sanction_letter) }}";
            window.open(imageUrl, '_blank');
        });
    });
</script>
@endpush