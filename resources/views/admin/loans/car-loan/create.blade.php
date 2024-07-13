@extends('admin.layouts.header')
@section('title', isset($carLoan->id) ? 'Edit Car Loan' : 'Add Car Loan')
@section('content')

    <head>
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
                                    <div class="card-header"
                                        style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                        <div class="row">
                                            <div class="col-12 col-sm-7">
                                                <h5 class="pt-2 pb-2">
                                                    @if (isset($carLoan->id))
                                                        Edit
                                                    @else
                                                        Add
                                                    @endif Car Loan
                                                </h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <a href="{{ route('admin.loan.car-loan.index') }}"
                                                    class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-arrow-left"></i> Back </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form method="post" action="{{ route('admin.loan.car-loan.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $carLoan->id ?? null }}">
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="mst_party_id">Party</label>
                                                            <select name="mst_party_id" id="mst_party_id"
                                                                class="form-control"{{ !$type ? 'disabled' : '' }}>
                                                                <option value="">Search By Name/Number</option>
                                                                @foreach ($parties as $party)
                                                                    <option value="{{ $party['id'] }}"
                                                                        {{ isset($carLoan->mst_party_id) && $carLoan->mst_party_id == $party['id'] ? 'selected' : '' }}>
                                                                        {{ $party['name'] }}

                                                                        @if ($party['father_name'])
                                                                            S/O <b
                                                                                style="color: green;">{{ ucfirst($party['father_name']) }}</b>
                                                                        @endif

                                                                        @if ($party['contacts'])
                                                                            ({{ $party['contacts'] }})
                                                                        @endif

                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($type)
                                                                <div data-toggle="modal" data-target="#addParty"
                                                                    class="input-group-append">
                                                                    <button class="btn btn-outline-primary btn-field-height"
                                                                        type="button">+</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="dob_date">Date of Birth:</label>
                                                            <input type="date" id="dob_date" name="dob_date"
                                                                class="form-control"
                                                                value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->dob_date)->format('Y-m-d') : old('dob_date') }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="email">Email:</label>
                                                            <input type="text" id="email" name="email"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="contact_number">Contact Number:</label>
                                                            <input type="text" id="contact_number" name="contact_number"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="address">Address:</label>
                                                            <input type="text" id="address" name="address"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="city">City:</label>
                                                            <input type="text" id="city" name="city"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="status">Status:</label>
                                                            <select name="status" id="status"
                                                                class="form-control{{ $type ? ' readonly' : '' }}"
                                                                {{ $type ? 'disabled' : '' }}>
                                                                <!-- <option selected disabled="">Choose...</option> -->
                                                                @foreach ($status as $id => $label)
                                                                    <option value="{{ $id }}"
                                                                        @if (isset($carLoan) && $carLoan->status == $id) selected @endif>
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if (isset($carLoan) && !empty($carLoan->approved_date))
                                                        <hr style="border: #2A3F54 1px solid;">
                                                        <h5>Approve Status Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-4 mt-3">
                                                                <label for="tenure">Tenure:</label>
                                                                <input type="text" id="tenure" name="tenure"
                                                                    class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->tenure }}@else{{ old('tenure') }} @endif"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-3" id="approvedDateField">
                                                                <label for="approved_date">Approve Date:</label>
                                                                <input type="date" id="approved_date"
                                                                    name="approved_date" class="form-control"
                                                                    value="{{ $carLoan->approved_date ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4 mt-3" id="approvedAmountField">
                                                                <label for="approved_amount">Approved Amount:</label>
                                                                <input class="form-control" type="text"
                                                                    name="approved_amount" id="approved_amount"
                                                                    value="{{ $carLoan->approved_amount ?? '' }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div id="approveFields"
                                                        style="display: @if (isset($carLoan) && $carLoan->status == 2) block @else none @endif;">
                                                        <div class="row">
                                                            <div class="col-md-4 mt-3">
                                                                <label for="tenure">Tenure:</label>
                                                                <input type="text" id="tenure" name="tenure"
                                                                    class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->tenure }}@else{{ old('tenure') }} @endif"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-3">
                                                                <label for="approved_date">Approve Date:</label>
                                                                <input type="date" id="approved_date"
                                                                    name="approved_date" class="form-control"
                                                                    value="{{ $carLoan->approved_date ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4 mt-3">
                                                                <label for="approved_amount">Approved Amount:</label>
                                                                <input class="form-control" type="text"
                                                                    name="approved_amount" id="approved_amount"
                                                                    value="{{ $carLoan->approved_amount ?? ($carLoan->loan_amount ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="disbursedFields"
                                                        style="display: @if (isset($carLoan) && $carLoan->status == 4) block @else none @endif;">
                                                        <hr style="border: #2A3F54 1px solid;">
                                                        <h5>Disburse Status Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-4 mt-2">
                                                                <label for="approved_amount">Approved Amount:</label>
                                                                <input class="form-control" type="text"
                                                                    value="{{ $carLoan->approved_amount ?? '' }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="tenure">Tenure:</label>
                                                                <input type="text" id="tenure" class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->tenure }}@else{{ old('tenure') }} @endif"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="roi">IRR/ROI:</label>
                                                                <input class="form-control" type="number" name="roi"
                                                                    id="roi" step=".01"
                                                                    value="{{ $carLoan->roi ?? '' }}">
                                                            </div>
                                                            <!-- <div class="col-md-4 mt-2">
                                                                <label for="disbursed_amount">Disbursed Amount:</label>
                                                                <input class="form-control" type="text" name="disbursed_amount" id="disbursed_amount" value="{{ $carLoan->disbursed_amount ?? '' }}">
                                                            </div> -->
                                                            <div class="col-md-4 mt-2">
                                                                <label for="disbursed_date">Disbursed Date:</label>
                                                                <input type="date" id="disbursed_date"
                                                                    name="disbursed_date" class="form-control"
                                                                    value="{{ isset($carLoan) ? $carLoan->disbursed_date : old('disbursed_date') }}"">
                                                            </div>
                                                            <div class=" col-md-4 mt-2">
                                                                <label for="emi_amount">EMI Amount:</label>
                                                                <input type="text" id="emi_amount" name="emi_amount"
                                                                    class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->emi_amount }}@else{{ old('emi_amount') }} @endif">
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="emi_advance">EMI Advance:</label>
                                                                <input type="text" id="emi_advance" name="emi_advance"
                                                                    class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->emi_advance }}@else{{ old('emi_advance') }} @endif">
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="emi_start_date">EMI Start Date:</label>
                                                                <input type="date" id="emi_start_date"
                                                                    name="emi_start_date" class="form-control"
                                                                    value="{{ isset($carLoan) ? $carLoan->emi_start_date : old('emi_start_date') }}"">
                                                            </div>
                                                            <div class=" col-md-4 mt-2">
                                                                <label for="emi_end_date">EMI End Date:</label>
                                                                <input type="date" id="emi_end_date"
                                                                    name="emi_end_date" class="form-control"
                                                                    value="{{ $carLoan->emi_end_date ?? '' }}" readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="loan_number">Loan Number:</label>
                                                                <input type="text" id="loan_number" name="loan_number"
                                                                    class="form-control"
                                                                    value="@if (isset($carLoan->id)) {{ $carLoan->loan_number }}@else{{ old('loan_number') }} @endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Loan And Vehicle Details</h5>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="login_date">Login Date:</label>
                                                            <input type="date" id="login_date" name="login_date"
                                                                class="form-control"
                                                                value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->login_date)->format('Y-m-d') : old('login_date') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="mst_model_id">Select Model</label>
                                                            <select name="mst_model_id" id="mst_model_id"
                                                                class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach ($models as $id => $model)
                                                                    <option value="{{ $id }}"
                                                                        {{ isset($carLoan->id) && $carLoan->mst_model_id == $id ? ' selected' : '' }}>
                                                                        {{ strtoupper($model) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- <div class="col-md-4">
                                                            <label for="mst_dealer_id">Select Dealer</label>
                                                            <select name="mst_dealer_id" id="mst_dealer_id" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach ($dealers as $id => $dealer)
    <option value="{{ $id }}" {{ isset($carLoan->id) && $carLoan->mst_dealer_id == $id ? ' selected' : '' }}>{{ strtoupper($dealer) }}</option>
    @endforeach
                                                            </select>
                                                        </div> -->
                                                        <div class="col-md-4">
                                                            <label for="vehicle_number">Vehicle Number:</label>
                                                            <input class="form-control" type="text"
                                                                name="vehicle_number" id="vehicle_number"
                                                                value="@if (isset($carLoan)) {{ $carLoan->vehicle_number }} @endif">
                                                        </div>
                                                        <!-- <div class="col-md-3">
                                                            <label for="mst_brand_type_id">Brand:</label>
                                                            <input class="form-control" type="text" name="brand" id="brand" value="@if (isset($carLoan)) {{ $carLoan->brand }} @endif" required>
                                                        </div> -->
                                                        <div class="col-md-4 mt-2">
                                                            <label for="manufacturing_year">Manufacturing Year:</label>
                                                            <input type="text" id="manufacturing_year"
                                                                name="manufacturing_year" class="form-control"
                                                                value="@if (isset($carLoan)) {{ $carLoan->manufacturing_year }} @endif">
                                                        </div>
                                                        <!-- <div class="col-md-4 mt-2">
                                                            <label for="registration_year">Registration Number:</label>
                                                            <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->registration_year }} @endif">
                                                        </div> -->
                                                        <!-- <div class="col-md-3 mt-3">
                                                            <label for="kilometer">Kilometer:</label>
                                                            <input type="text" id="kilometer" name="kilometer" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->kilometer }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="expectation">Expectation:</label>
                                                            <input type="text" id="expectation" name="expectation" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->expectation }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="date_of_purchase">Date Of Purchase:</label>
                                                            <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" value="{{ $carLoan->date_of_purchase ?? '' }}">
                                                        </div>

                                                        <div class="col-md-3 mt-3">
                                                            <label for="owners">Owners:</label>
                                                            <input type="text" id="owners" name="owners" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->owners }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="fuel_type">Fuel Type:</label>
                                                            <input type="text" id="fuel_type" name="fuel_type" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->fuel_type }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="shape_type">Shape Type:</label>
                                                            <input type="text" id="shape_type" name="shape_type" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->shape_type }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="engine_number">Engine Number:</label>
                                                            <input type="text" id="engine_number" name="engine_number" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->engine_number }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="chasis_number">Chasis Number:</label>
                                                            <input type="text" id="chasis_number" name="chassis_number" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->chassis_number }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="service_booklet">Service Booklet:</label>
                                                            <input type="text" id="service_booklet" name="service_booklet" class="form-control" value="@if (isset($carLoan)) {{ $carLoan->service_booklet }} @endif" required>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="mst_color_id">Color:</label>
                                                            <input class="form-control" type="text" name="color" id="color" value="@if (isset($carLoan)) {{ $carLoan->color }} @endif" required>
                                                        </div> -->
                                                        <div class="col-md-4 mt-2">
                                                            <label for="loan_amount">Loan Amount:</label>
                                                            <input type="text" id="loan_amount" name="loan_amount"
                                                                class="form-control"
                                                                value="@if (isset($carLoan->id)) {{ $carLoan->loan_amount }}@else{{ old('loan_amount') }} @endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="tenure">Tenure:</label>
                                                            <input type="text" id="tenure_loan" name="tenure"
                                                                class="form-control"
                                                                value="@if (isset($carLoan->id)) {{ $carLoan->tenure }}@else{{ old('tenure') }} @endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="executive">Executive:</label>
                                                            <select name="executive" id="executive" class="form-control"
                                                                required>
                                                                <option value="" selected disabled>Choose...</option>
                                                                @foreach ($executives as $value => $party)
                                                                    <option value="{{ $value }}"
                                                                        {{ isset($carLoan->id) && $carLoan->executive == $value ? ' selected' : '' }}>
                                                                        {{ $party }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="co_applicant">Co Applicant:</label>
                                                            <input type="text" id="co_applicant" name="co_applicant"
                                                                class="form-control"
                                                                value="@if (isset($carLoan->id)) {{ $carLoan->co_applicant }}@else{{ old('co_applicant') }} @endif">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="bank_id">Select Bank</label>
                                                            <select name="bank_id" id="bank_id" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach ($banks as $id => $dealer)
                                                                    <option value="{{ $id }}"
                                                                        {{ isset($carLoan->id) && $carLoan->bank_id == $id ? ' selected' : '' }}>
                                                                        {{ strtoupper($dealer) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 mt-2">
                                                            <span class="text">PURCHASE / REFINANCE</span>
                                                            <select class="form-control" name="loan_type" id="loan_type">
                                                                <option value="" selected disabled>Choose...</option>
                                                                <option value="1"
                                                                    {{ isset($carLoan) && $carLoan->loan_type == '1' ? 'selected' : '' }}>
                                                                    Purchase</option>
                                                                <option value="2"
                                                                    {{ isset($carLoan) && $carLoan->loan_type == '2' ? 'selected' : '' }}>
                                                                    Refinance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 mt-2">
                                                            <span class="text">USED / NEW</span>
                                                            <select class="form-control" name="car_type" id="car_type">
                                                                <option value="" selected disabled>Choose...</option>
                                                                <option value="1"
                                                                    {{ isset($carLoan) && $carLoan->car_type == '1' ? 'selected' : '' }}>
                                                                    Used</option>
                                                                <option value="2"
                                                                    {{ isset($carLoan) && $carLoan->car_type == '2' ? 'selected' : '' }}>
                                                                    New</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Insurance</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="policy_number_id">Policy Number</label>
                                                            <select name="policy_id" id="policy_number_id"
                                                                class="form-control">
                                                                <option value="" selected disabled>Choose...</option>
                                                                @foreach ($policyNumbers as $id => $policy)
                                                                    <option value="{{ $id }}"
                                                                        {{ isset($carLoan->id) && $carLoan->policy_id == $id ? ' selected' : '' }}>
                                                                        {{ $policy }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="insurance_company">Insurance Company:</label>
                                                            <select name="insurance_company" id="insurance_company"
                                                                class="form-control" disabled>
                                                                <option value="">Choose...</option>
                                                                @foreach ($insurance as $value => $label)
                                                                    <option value="{{ $value }}"
                                                                        {{ isset($carLoan->insurance_company) && $carLoan->insurance_company == $value ? 'selected' : '' }}>
                                                                        {{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="insurance_done_date">Insurance Done Date:</label>
                                                            <input type="date" id="insurance_done_date"
                                                                name="insurance_done_date" class="form-control"
                                                                value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_done_date)->format('Y-m-d') : old('insurance_done_date') }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="insurance_from_date">Insurance From Date:</label>
                                                            <input type="date" id="insurance_from_date"
                                                                name="insurance_from_date" class="form-control"
                                                                value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_from_date)->format('Y-m-d') : old('insurance_from_date') }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="insurance_to_date">Insurance To Date:</label>
                                                            <input type="date" id="insurance_to_date"
                                                                name="insurance_to_date" class="form-control"
                                                                value="{{ isset($carLoan) ? \Carbon\Carbon::parse($carLoan->insurance_to_date)->format('Y-m-d') : old('insurance_to_date') }}"
                                                                readonly>
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
    <div class="modal fade text-left" id="addParty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
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
                                <label for="party_name">Party Name</label>
                                <input type="text" id="party_name" placeholder="Party Name" name="party_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="father_name">Father Name</label>
                                <input type="text" id="father_name" placeholder="Father Name" name="father_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="whatsapp_number">Whatsapp Number</label>
                                <input type="number" id="whatsapp_number" placeholder="Whatsapp Number" name="whatsapp_number" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="office_address">Office Address</label>
                                <input type="text" id="office_address" placeholder="Office Address" name="office_address" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="email">Email</label>
                                <input type="email" id="email" placeholder="Email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="residence_city">Residence City</label>
                                <input type="text" id="residence_city" placeholder="Residence City" name="residence_city" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="office_number">Office Number</label>
                                <input type="text" id="office_number" placeholder="Office Number" name="office_number" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="office_city">Office City</label>
                                <input type="text" id="office_city" placeholder="Office City" name="office_city" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="residence_address">Residence Address</label>
                                <input type="text" id="residence_address" placeholder="Residence Address" name="residence_address" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="pan_number">Pan Number</label>
                                <input type="text" id="pan_number" placeholder="Pan Number" name="pan_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="firm_name">Firm Name</label>
                                <input type="text" id="firm_name" placeholder="Firm Name" name="firm_name" class="form-control" required>
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

            var $selectizeLoanType = $('#loan_type').selectize();
            var selectizeLoanTypeControl = $selectizeLoanType[0].selectize;

            var $selectizeCarType = $('#car_type').selectize();
            var selectizeCarTypeControl = $selectizeCarType[0].selectize;

            var $selectizeBank = $('#bank_id').selectize();
            var selectizeBankControl = $selectizeBank[0].selectize;

            var $selectizeExecutive = $('#executive').selectize();
            var selectizeExecutiveControl = $selectizeExecutive[0].selectize;

            var $selectizeModel = $('#mst_model_id').selectize();
            var selectizeModelControl = $selectizeModel[0].selectize;
            $('#status').change(function() {
                var status = $(this).val();
                $("#approved_date").attr('required', false);
                $("#mst_model_id").attr('required', false);
                $("#approved_amount").attr('required', false);
                $("#vehicle_number").attr('required', false);
                $("#insurance_done_date").attr('required', false);
                $("#insurance_from_date").attr('required', false);
                $("#insurance_to_date").attr('required', false);

                if (status == 4) {
                    selectizeLoanTypeControl.disable();
                    selectizeCarTypeControl.disable();
                    selectizeBankControl.disable();
                    selectizeExecutiveControl.disable();
                    selectizeModelControl.disable();
                    $('#dob_date').prop('readonly', true);
                    $('#login_date').prop('readonly', true);
                    $('#vehicle_number').prop('readonly', true);
                    $('#manufacturing_year').prop('readonly', true);
                    $('#registration_year').prop('readonly', true);
                    $('#loan_amount').prop('readonly', true);
                    $('#tenure_loan').prop('readonly', true);
                    $('#co_applicant').prop('readonly', true);
                    $('#disbursedFields').show();
                    // $('#roi').prop('readonly', true);
                    $('#disbursed_date').prop('required', true);
                    $('#emi_amount').prop('required', true);
                    $('#emi_advance').prop('required', true);
                    $('#emi_start_date').prop('required', true);
                    $('#emi_end_date').prop('required', true);
                    $('#loan_number').prop('required', true);
                } else {
                    selectizeLoanTypeControl.enable();
                    selectizeCarTypeControl.enable();
                    selectizeBankControl.enable();
                    selectizeExecutiveControl.enable();
                    selectizeModelControl.enable();
                    $('#dob_date').prop('readonly', false);
                    $('#login_date').prop('readonly', false);
                    $('#vehicle_number').prop('readonly', false);
                    $('#manufacturing_year').prop('readonly', false);
                    $('#registration_year').prop('readonly', false);
                    $('#loan_amount').prop('readonly', false);
                    $('#tenure_loan').prop('readonly', false);
                    $('#co_applicant').prop('readonly', false);
                    $('#disbursedFields').hide();
                }

                if (status == 2) {
                    $('#approveFields').show();
                    $("#approved_date").attr('required', true);
                    $("#mst_model_id").attr('required', true);
                    $("#approved_amount").attr('required', true);
                    $("#vehicle_number").attr('required', true);
                    $("#insurance_done_date").attr('required', true);
                    $("#insurance_from_date").attr('required', true);
                    $("#insurance_to_date").attr('required', true);

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
                    var endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + tenure);
                    endDate.setDate(endDate.getDate() - 1);
                    // Format the end date
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
                    url: '{{ route('fetch-insurance-data') }}',
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
        $(document).ready(function() {
            $('.modal_submit').click(function(e) {
                e.preventDefault();
                var formData = $('#updateForm').serialize();
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
                        var errorMessage = 'Error: ';

                        try {
                            var response = JSON.parse(xhr.responseText);
                            console.log(response);
                            if (response.errors) {
                                for (var key in response.errors) {
                                    errorMessage += response.errors[key][0] + '<br>';
                                }
                            }
                        } catch (e) {
                            errorMessage += 'Unknown error occurred.';
                        }
                        toastr.error(errorMessage);
                    }
                });
            });
        });
    </script>
@endpush
