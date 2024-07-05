@extends('admin.layouts.header')
@section('title', isset($purchase->id) ? 'Edit Purchase' : 'Add Purchase')
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
                                            <h5 class="pt-2 pb-2">@if(isset($purchase->id)) Edit @else Add @endif Purchase Enquiry</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.purchase.purchase.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <h4 class="card-title"><b><a href="{{route('admin.purchase.purchase.index')}}">Purchases</a></b> / @if(isset($purchase->id)) Edit @else Add @endif Purchase Enquiry</h4> -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.purchase.purchase.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="mst_executive_id">Executive:</label>
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control">
                                                            <option value="">Search Executive</option>
                                                            @foreach($executives as $id => $label)
                                                            <option value="{{ $id }}" {{ isset($purchase) && $purchase->mst_executive_id == $id ? 'selected' : '' }}>{{ ucfirst($label) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="evaluation_date">Evaluation Appointment:</label>
                                                        <input type="date" id="evaluation_date" name="evaluation_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->evaluation_date)->format('Y-m-d') : old('evaluation_date') }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($purchase->id)){{$purchase->firm_name}}@else{{old('firm_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_person_name">Person Name:</label>
                                                        <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" value="@if(isset($purchase->id)){{$purchase->contact_person_name}}@else{{old('contact_person_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->contact_number}}@else{{old('contact_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" value="@if(isset($purchase->id)){{$purchase->address}}@else{{old('address')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" value="@if(isset($purchase->id)){{$purchase->city}}@else{{old('city')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($purchase->id)){{$purchase->email}}@else{{old('email')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" value="@if(isset($purchase->id)){{$purchase->registered_owner}}@else{{old('registered_owner')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- <div class="col-md-4">
                                                        <label for="images">Image:</label>
                                                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                                                    </div> -->
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status_id" class="form-control{{ $type ? ' readonly' : '' }}" {{ $type ? 'disabled' : '' }}>
                                                            @if(isset($purchase->status))
                                                            <option value="{{ $purchase->status }}">{{ $purchase->getStatusName($purchase->status) }}</option>
                                                            @endif
                                                            @foreach($status as $value => $label)
                                                            <option value="{{ $value }}">{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="enquiry_date">Enquiry Date:</label>
                                                        <input type="date" id="enquiry_date" name="enquiry_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->enquiry_date)->format('Y-m-d') : old('enquiry_date') }}">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <select name="mst_brand_type_id" id="mst_brand_type_id" class="form-control">
                                                            <option value="">Search Brand</option>
                                                            @foreach($brandTypes as $id => $name)
                                                            <option value="{{ $id }}" {{ isset($purchase->mst_brand_type_id) && $purchase->mst_brand_type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_model_id">Model:</label>
                                                        <select name="mst_model_id" id="mst_model_id" class="form-control">
                                                            <option value="">Search Model</option>
                                                            @foreach($model as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->mst_model_id) && $purchase->mst_model_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($purchase->id)){{$purchase->manufacturing_year}}@else{{old('manufacturing_year')}}@endif">
                                                    </div>


                                                    @if ($type == false)
                                                    <div class="col-md-3">
                                                        <label for="reg_number">Vehicle Number:</label>
                                                        <input type="text" id="reg_number" name="reg_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->reg_number}}@else{{old('reg_number')}}@endif">
                                                    </div>

                                                    @endif
                                                </div>

                                                @if ($type == false)

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if(isset($purchase->id)){{$purchase->registration_year}}@else{{old('registration_year')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" value="@if(isset($purchase->id)){{$purchase->kilometer}}@else{{old('kilometer')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" value="@if(isset($purchase->id)){{$purchase->expectation}}@else{{old('expectation')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <select name="mst_color_id" id="mst_color_id" class="form-control">
                                                            <option value="">Search Color</option>
                                                            @foreach($colors as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->mst_color_id) && $purchase->mst_color_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners" name="owners" class="form-control" value="{{ isset($purchase) ? $purchase->owners : old('owners') }}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <select name="fuel_type" id="fuel_type" class="form-control">
                                                            <option value="" disabled selected>Select Fuel Type</option>
                                                            @foreach($fuelType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->fuel_type) && $value == $purchase->fuel_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <select name="shape_type" id="shape_type" class="form-control">
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($shapeType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->shape_type) && $value == $purchase->shape_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="engine_number">Engine Number:</label>
                                                        <input type="text" id="engine_number" name="engine_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_number}}@else{{old('engine_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="chasis_number">Chasis Number:</label>
                                                        <input type="text" id="chasis_number" name="chasis_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->chasis_number}}@else{{old('chasis_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="service_booklet">Service Booklet:</label>
                                                        <select name="service_booklet" id="service_booklet" class="form-control">
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($serviceBooklet as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->service_booklet) && $value == $purchase->service_booklet? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->date_of_purchase)->format('Y-m-d') : old('date_of_purchase') }}" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="enquiry_type">Enquiry Type:</label>
                                                        <select name="enquiry_type" id="enquiry_type" class="form-control">
                                                            <option value="" disabled selected>Select Enquiry Type</option>
                                                            @foreach($enquiryType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->enquiry_type) && $value == $purchase->enquiry_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3" id="other">
                                                        <label for="other">Other:</label>
                                                        <input type="text" id="other" name="other" class="form-control" value="@if(isset($purchase->id)){{$purchase->other}}@else{{old('other')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="willing_insurance">Will to give insurance:</label>
                                                        <select name="willing_insurance" id="willing_insurance" class="form-control">
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($willingType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->willing_insurance) && $value == $purchase->willing_insurance? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="tyres_condition">Tyres Condition:</label>
                                                        <input type="text" id="tyres_condition" name="tyres_condition" class="form-control" value="@if(isset($purchase->id)){{$purchase->tyres_condition}}@else{{old('tyres_condition')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="parts_changed">Parts Changed:</label>
                                                        <input type="text" id="parts_changed" name="parts_changed" class="form-control" value="@if(isset($purchase->id)){{$purchase->parts_changed}}@else{{old('parts_changed')}}@endif">
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="parts_repainted">Parts Repainted:</label>
                                                        <input type="text" id="parts_repainted" name="parts_repainted" class="form-control" value="@if(isset($purchase->id)){{$purchase->parts_repainted}}@else{{old('parts_repainted')}}@endif">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">


                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="refurnushment_checkbox">
                                                    <label style="font-size: 1em;" class="form-check-label" for="flexCheckDefault">
                                                        Refurbnishment Needed
                                                    </label>
                                                </div>
                                                <div id="refurbnishement_div" style="display:none;">
                                                    <div class="row">
                                                        <h6 style="margin-left: 40%;">Description</h6>
                                                        <h6 style="margin-left: 35%;">Amount</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="service_and_oil_change">Service And Oil Change:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="service_and_oil_change" name="service_and_oil_change" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change}}@else{{old('service_and_oil_change')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="service_and_oil_change_amount_1" name="service_and_oil_change_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change_amount}}@else{{old('service_and_oil_change_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Compound And Dry Clean:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="compound_and_dry_clean" name="compound_and_dry_clean" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean}}@else{{old('compound_and_dry_clean')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="compound_and_dry_clean_amount" name="compound_and_dry_clean_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean_amount}}@else{{old('compound_and_dry_clean_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Paint And Denting:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="paint_and_denting" name="paint_and_denting" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting}}@else{{old('paint_and_denting')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="paint_and_denting_amount" name="paint_and_denting_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting_amount}}@else{{old('paint_and_denting_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Electrical And Electronics:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="electrical_and_electronics" name="electrical_and_electronics" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics}}@else{{old('electrical_and_electronics')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="electrical_and_electronics_amount" name="electrical_and_electronics_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics_amount}}@else{{old('electrical_and_electronics_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Engine Compartment:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="engine_compartment" name="engine_compartment" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment}}@else{{old('engine_compartment')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="engine_compartment_amount" name="engine_compartment_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment_amount}}@else{{old('engine_compartment_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Accessories:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="accessories" name="accessories" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories}}@else{{old('accessories')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="accessories_amount" name="accessories_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories_amount}}@else{{old('accessories_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="others_desc" name="others_desc" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_desc}}@else{{old('others_desc')}}@endif">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="others_amount" name="others_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_amount}}@else{{old('others_amount')}}@endif" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label for="others_desc" style="margin-left: 89%;"><b>Total: </b></label>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="total_amount" name="total" class="form-control" value="@if(isset($purchase->id)){{$purchase->total}}@else{{old('total')}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                @if(isset($purchase->reg_date) || isset($purchase->insurance_due_date) || isset($purchase->icompany_id) || isset($purchase->policy_number))
                                                <h5>Insurance</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->reg_date)->format('Y-m-d') : old('reg_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="company_id" id="icompany_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->icompany_id) && $value == $purchase->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy" class="form-control" value="@if(isset($purchase->id)){{$purchase->policy_number}}@else{{old('policy_number')}}@endif">
                                                    </div>
                                                </div>
                                                @endif
                                                <div id="insuranceFields">
                                                    <h5>Insurance</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="reg_date">Registration Date:</label>
                                                            <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->reg_date)->format('Y-m-d') : old('reg_date') }}">
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                            <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            <label for="icompany_id">Insurance Company:</label>
                                                            <select name="icompany_id" id="icompany_id" class="form-control">
                                                                <option value="" disabled selected>Choose...</option>
                                                                @foreach($company as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($purchase->icompany_id) && $value == $purchase->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mt-2">
                                                            <label for="policy_number">Policy No.:</label>
                                                            <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->policy_number}}@else{{old('policy_number')}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($purchase->expected_price))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Quotation details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="amount_input">Amount:</label>
                                                    <input type="text" name="expected_price" class="form-control" value="@if(isset($purchase->id)){{$purchase->expected_price}}@else{{old('expected_price')}}@endif">
                                                </div>
                                                @endif

                                                @if(!empty($purchase->followup_date))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Followup details </h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="quoted_date_input">Follow Date:</label>
                                                        <input type="date" name="followup_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->followup_date)->format('Y-m-d') : old('followup_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="follow_remarks">Remarks:</label>
                                                        <input type="text" name="follow_remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->follow_remarks}}@else{{old('follow_remarks')}}@endif">
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($purchase->remarks))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Closed details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="remarks_input">Remarks:</label>
                                                    <input type="text" name="remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->remarks}}@else{{old('remarks')}}@endif">
                                                </div>
                                                @endif

                                                <div id="remarks_input_1">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Closed details </h5>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="remarks_input">Remarks:</label>
                                                        <input type="text" id="remarks_input" name="remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->remarks}}@else{{old('remarks')}}@endif">
                                                    </div>
                                                </div>
                                                <div id="amount_input_1">
                                                    <hr style="border: #2A3F54 1px solid;">
                                                    <h5>Quotation details </h5>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="amount_input">Amount:</label>
                                                        <input type="text" id="amount_input" name="expected_price" class="form-control" value="@if(isset($purchase->id)){{$purchase->expected_price}}@else{{old('expected_price')}}@endif">
                                                    </div>
                                                </div>
                                                <input type="hidden" id="followup_date_input" name="followup_date" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->followup_date)->format('Y-m-d') : old('followup_date') }}">
                                                <input type="hidden" id="followup_remark" name="follow_remarks" value="@if(isset($purchase->id)){{$purchase->follow_remarks}}@else{{old('follow_remarks')}}@endif">

                                                <button type="submit" id="save_button" class="btn btn-primary mt-3">@if(isset($purchase->id)) Update @else Save @endif</button>
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
                            <input type="text" placeholder="Whatsapp Number" name="whatsapp_number" class="form-control" required>
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
                            <input type="text" placeholder="Office Number" name="office_number" class="form-control" required>
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

<div class="modal fade text-left" id="addfollowup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33"><b>Follow Up Date</b></label>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="followup_date">Follow Up Date</label>
                    <input type="date" id="followup_date" class="form-control" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="remarks_input">Remarks:</label>
                    <input type="text" id="remarks_modal" class="form-control" value="@if(isset($purchase->id)){{$purchase->remarks}}@else{{old('remarks')}}@endif">
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                <button type="button" class="btn btn-primary" id="saveFollowUpDate">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#other').hide();
        $('#enquiry_type').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '7') {
                $('#other').show();
            } else {
                $('#other').hide();
            }
        });
    });
    $(document).ready(() => {
        $('select').not('#mst_model_id').selectize();
    });
    $(document).ready(function() {
        // Initially hide the remarks field
        $('#remarks_input').hide();
        $('#quoted_date_input').hide();
        $('#remarks_input_1').hide();
        $('#quoted_date_input_1').hide();
        $('#amount_input').hide();
        $('#amount_input_1').hide();
        $('#insuranceFields').hide();
        $('#status_id').change(function() {
            var selectedOption = $(this).val();

            // Determine the name of the status based on the selected option
            var name = '';
            if (selectedOption === '5') {
                name = "Closed";
                $('#remarks_input').show();
                $('#remarks_input_1').show(); // Show remarks field if status is Evaluated
            } else {
                $('#remarks_input').hide();
                $('#remarks_input_1').hide(); // Hide remarks field for other statuses
            }

            if (selectedOption === '3') {
                name = "Evaluated";
                $('#amount_input').show();
                $('#amount_input_1').show(); // Show Quoted Date field if status is Quoted
            } else {
                $('#amount_input').hide();
                $('#amount_input_1').hide(); // Hide Quoted Date field for other statuses
            }
            if (selectedOption === '2') {
                $('#insuranceFields').show();
            } else {
                $('#insuranceFields').hide();
            }

            // Check if the Quoted Date field should be shown
            // if (selectedOption === '4') {
            //     $('#quoted_date_input').show();
            //     $('#quoted_date_input_1').show(); // Show Quoted Date field if status is Quoted
            // } else {
            //     $('#quoted_date_input').hide();
            //     $('#quoted_date_input_1').hide(); // Hide Quoted Date field for other statuses
            // }

        });
    });

    $(document).ready(function() {
        $('#save_button').click(function() {
            var selectedOption = $('#status_id').val();
            var name = '';

            // Determine the name of the status based on the selected option
            if (selectedOption === '4') {
                name = "Follow Up";
            } else if (selectedOption === '5') {
                name = "Closed";
            } else if (selectedOption === '3') {
                name = "Quoted";
            }

            // Validate the remarks field
            if ((selectedOption === '5') && $('#remarks_input').val().trim() === '') {
                alert('Remarks field is required for ' + name + ' status.');
                $('#remarks_input').focus(); // Focus on the remarks input field to bring attention to it
                return false; // Prevent form submission
            } else if ((selectedOption === '3') && $('#amount_input').val().trim() === '') {
                alert('Amount field is required for ' + name + ' status.');
                $('#amount_input').focus();
                return false;
            } else {
                // Proceed with form submission
                return true;
            }
        });
    });

    $(document).ready(function() {
        $('#refurnushment_checkbox').click(function() {
            $('#refurbnishement_div').toggle();
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
                    console.log('Response:', response);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#contact_number').val(response.contact_number);
                    $('#address').val(response.office_address);
                    $('#city').val(response.office_city);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.modal_submit').click(function(e) {
            e.preventDefault(); // Prevent the default form submission behavior
            var formData = $('#updateForm').serialize();
            console.log(formData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Send the AJAX request to save the party data
            $.ajax({
                url: '/save-party-data', // Updated URL
                type: 'POST', // Sending a POST request
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                    // Display a success message to the user
                    alert('Party data saved successfully');
                    location.reload(); // Reload the page
                    // Clear the modal inputs
                    $('#addParty input').val('');
                    // Close the modal
                    $('#addParty').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.error(xhr.responseText); // Log the response text
                    alert('Error: ' + xhr.responseText); // Display the error response
                }
            });
        });
    });

    $(document).ready(function() {
        calculateTotal();
    });

    function calculateTotal() {
        // Get values from input fields
        console.log('calculateTotal() function called');
        var othersAmount = parseFloat(document.getElementById('others_amount').value) || 0;
        var accessoriesAmount = parseFloat(document.getElementById('accessories_amount').value) || 0;
        var engineCompartmentAmount = parseFloat(document.getElementById('engine_compartment_amount').value) || 0;
        var serviceOilAmount = parseFloat(document.getElementById('service_and_oil_change_amount_1').value) || 0;
        var compoundAmount = parseFloat(document.getElementById('compound_and_dry_clean_amount').value) || 0;
        var paintAmount = parseFloat(document.getElementById('paint_and_denting_amount').value) || 0;
        var electricalAmount = parseFloat(document.getElementById('electrical_and_electronics_amount').value) || 0;

        // Calculate total
        var total = othersAmount + accessoriesAmount + engineCompartmentAmount + serviceOilAmount + compoundAmount + paintAmount + electricalAmount;
        console.log('Total:', total);
        // Display total
        document.getElementById('total_amount').value = total.toFixed(2);
    }

    $(document).ready(function() {
        $('#status_id').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '4') {
                $('#addfollowup').modal('show');
            }
            var savedFollowUpDate = $('#followup_date_input').val();
            if (savedFollowUpDate) {
                $('#followup_date').val(savedFollowUpDate);
            }
        });
        $('#saveFollowUpDate').click(function() {
            // Get the follow-up date from the modal input field
            var followUpDate = $('#followup_date').val();
            var remarks = $('#remarks_modal').val();
            if (!followUpDate) {
                alert("Follow Up Date is required.");
            } else {
                $('#followup_date_input').val(followUpDate);
                $('#followup_remark').val(remarks);
                $('#addfollowup').modal('hide');
            }
        });
    });

    $(document).ready(function() {
        $('#mst_brand_type_id').change(function(e) {
            var selectedType = $(this).val();
            if (selectedType) {
                $.ajax({
                    url: '/get-models',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'brand_type': selectedType,
                        'selected_subtype': $('#mst_model_id').val()
                    },
                    success: function(response) {
                        $('#mst_model_id').html(response);
                    },
                });
            } else {
                $('#mst_model_id').html('<option selected disabled>Choose...</option>');
            }
        });
        $('#mst_brand_type_id').trigger('change');
    });
</script>
@endpush