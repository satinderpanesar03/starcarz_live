@extends('admin.layouts.header')
@section('title','View purchase')
@section('content')
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="content-header"></div>
                </div>
            </div>
            <section id="simple-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                <div class="row">
                                    <div class="col-12 col-sm-7">
                                        <h5 class="pt-2 pb-2">View Purchase Enquiry</h5>
                                    </div>
                                    @if ($type)
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="{{route('admin.purchase.purchase.follow-up')}}" class="btn btn-sm btn-primary px-3 py-1">
                                            <i class="fa fa-arrow-left"></i> Back </a>
                                    </div>
                                    @else
                                    <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                        <a href="#" class="btn btn-sm btn-primary px-3 py-1" onclick="window.history.back();">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.purchase.purchase.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $purchase->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="mst_executive_id">Executive:</label>
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control" disabled>
                                                            <option value="">Search Executive</option>
                                                            @foreach($executives as $id => $label)
                                                            <option value="{{ $id }}" {{ isset($purchase->mst_executive_id) && $purchase->mst_executive_id == $id ? 'selected' : '' }}>
                                                                {{ ucfirst($label) }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="evaluation_date">Evaluation Appointment:</label>
                                                        <input type="date" id="evaluation_date" name="evaluation_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->evaluation_date)->format('Y-m-d') : old('evaluation_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($purchase->id)){{$purchase->firm_name}}@else{{old('firm_name')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_person_name">Person Name:</label>
                                                        <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" value="@if(isset($purchase->id)){{$purchase->contact_person_name}}@else{{old('contact_person_name')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->contact_number}}@else{{old('contact_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" value="@if(isset($purchase->id)){{$purchase->address}}@else{{old('address')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" value="@if(isset($purchase->id)){{$purchase->city}}@else{{old('city')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($purchase->id)){{$purchase->email}}@else{{old('email')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="registered_owner">Registered Owner:</label>
                                                        <input type="text" id="registered_owner" name="registered_owner" class="form-control" value="@if(isset($purchase->id)){{$purchase->registered_owner}}@else{{old('registered_owner')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="status">Status:</label>
                                                        <select disabled name="status" id="status" class="form-control{{ $type ? ' readonly' : '' }}" {{ $type ? 'disabled' : '' }}>
                                                            @foreach($status as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->status) && $value == $purchase->status? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="enquiry_date">Enquiry Date:</label>
                                                        <input type="date" id="enquiry_date" name="enquiry_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->enquiry_date)->format('Y-m-d') : old('enquiry_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Vehicle Details</h5>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="mst_brand_type_id">Brand:</label>
                                                        <select disabled name="mst_brand_type_id" id="mst_brand_type_id" class="form-control">
                                                            <option value="">Select Option</option>
                                                            @foreach($brandTypes as $id => $name)
                                                            <option value="{{ $id }}" {{ isset($purchase->mst_brand_type_id) && $purchase->mst_brand_type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="mst_model_id">Model:</label>
                                                        <select disabled name="mst_model_id" id="mst_model_id" class="form-control">
                                                            <option value="">Select Dealer</option>
                                                            @foreach($model as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->mst_model_id) && $purchase->mst_model_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="manufacturing_year">Manufacturing Year:</label>
                                                        <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" value="@if(isset($purchase->id)){{$purchase->manufacturing_year}}@else{{old('manufacturing_year')}}@endif" readonly>
                                                    </div>
                                                    @if ($type == false)
                                                    <div class="col-md-3">
                                                        <label for="reg_number">Vehicle Number:</label>
                                                        <input type="text" id="reg_number" name="reg_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->reg_number}}@else{{old('reg_number')}}@endif" readonly>
                                                    </div>

                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="registration_year">Registration Year:</label>
                                                        <input type="text" id="registration_year" name="registration_year" class="form-control" value="@if(isset($purchase->id)){{$purchase->registration_year}}@else{{old('registration_year')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="kilometer">Kilometer:</label>
                                                        <input type="text" id="kilometer" name="kilometer" class="form-control" value="@if(isset($purchase->id)){{$purchase->kilometer}}@else{{old('kilometer')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="expectation">Expectation:</label>
                                                        <input type="text" id="expectation" name="expectation" class="form-control" value="@if(isset($purchase->id)){{$purchase->expectation}}@else{{old('expectation')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="mst_color_id">Color:</label>
                                                        <select disabled name="mst_color_id" id="mst_color_id" class="form-control">
                                                            <option value="">Select Dealer</option>
                                                            @foreach($colors as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->mst_color_id) && $purchase->mst_color_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="owners">Owners:</label>
                                                        <input type="text" id="owners" name="owners" class="form-control" value="{{ isset($purchase) ? $purchase->owners : old('owners') }}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <select disabled name="fuel_type" id="fuel_type" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($fuelType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->fuel_type) && $value == $purchase->fuel_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="shape_type">Shape Type:</label>
                                                        <select disabled name="shape_type" id="shape_type" class="form-control">
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($shapeType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->shape_type) && $value == $purchase->shape_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="engine_number">Engine Number:</label>
                                                        <input type="text" id="engine_number" name="engine_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_number}}@else{{old('engine_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="chasis_number">Chasis Number:</label>
                                                        <input type="text" id="chasis_number" name="chasis_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->chasis_number}}@else{{old('chasis_number')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="service_booklet">Service Booklet:</label>
                                                        <select disabled name="service_booklet" id="service_booklet" class="form-control">
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($serviceBooklet as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->service_booklet) && $value == $purchase->service_booklet? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_of_purchase">Date Of Purchase:</label>
                                                        <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->date_of_purchase)->format('Y-m-d') : old('date_of_purchase') }}" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="enquiry_type">Enquiry Type:</label>
                                                        <select disabled name="enquiry_type" id="enquiry_type" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($enquiryType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->enquiry_type) && $value == $purchase->enquiry_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3" id="other">
                                                        <label for="other">Other:</label>
                                                        <input type="text" id="other" name="other" class="form-control" value="@if(isset($purchase->id)){{$purchase->other}}@else{{old('other')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-3">
                                                        <label for="willing_insurance">Will to give insurance:</label>
                                                        <select disabled name="willing_insurance" id="willing_insurance" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($willingType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->willing_insurance) && $value == $purchase->willing_insurance? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="tyres_condition">Tyres Condition:</label>
                                                        <input type="text" id="tyres_condition" name="tyres_condition" class="form-control" value="@if(isset($purchase->id)){{$purchase->tyres_condition}}@else{{old('tyres_condition')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="parts_changed">Parts Changed:</label>
                                                        <input type="text" id="parts_changed" name="parts_changed" class="form-control" value="@if(isset($purchase->id)){{$purchase->parts_changed}}@else{{old('parts_changed')}}@endif" readonly>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="parts_repainted">Parts Repainted:</label>
                                                        <input type="text" id="parts_repainted" name="parts_repainted" class="form-control" value="@if(isset($purchase->id)){{$purchase->parts_repainted}}@else{{old('parts_repainted')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Refurbnishment Details</h5>
                                                <div id="refurbnishement_div">
                                                    <div class="row">
                                                        <h6 style="margin-left: 40%;">Description</h6>
                                                        <h6 style="margin-left: 35%;">Amount</h6>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 mt-2">
                                                            <label for="service_and_oil_change">Service And Oil Change:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="service_and_oil_change" name="service_and_oil_change" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change}}@else{{old('service_and_oil_change')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="service_and_oil_change_amount" name="service_and_oil_change_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->service_and_oil_change_amount}}@else{{old('service_and_oil_change_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="compound_and_dry_clean">Compound And Dry Clean:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="compound_and_dry_clean" name="compound_and_dry_clean" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean}}@else{{old('compound_and_dry_clean')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="compound_and_dry_clean_amount" name="compound_and_dry_clean_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->compound_and_dry_clean_amount}}@else{{old('compound_and_dry_clean_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="paint_and_denting">Paint And Denting:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="paint_and_denting" name="paint_and_denting" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting}}@else{{old('paint_and_denting')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="paint_and_denting_amount" name="paint_and_denting_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->paint_and_denting_amount}}@else{{old('paint_and_denting_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="electrical_and_electronics">Electrical And Electronics:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="electrical_and_electronics" name="electrical_and_electronics" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics}}@else{{old('electrical_and_electronics')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="electrical_and_electronics_amount" name="electrical_and_electronics_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->electrical_and_electronics_amount}}@else{{old('electrical_and_electronics_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="engine_compartment">Engine Compartment:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="engine_compartment" name="engine_compartment" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment}}@else{{old('engine_compartment')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="engine_compartment_amount" name="engine_compartment_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->engine_compartment_amount}}@else{{old('engine_compartment_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="accessories">Accessories:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="accessories" name="accessories" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories}}@else{{old('accessories')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="accessories_amount" name="accessories_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->accessories_amount}}@else{{old('accessories_amount')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <label for="others_desc">Others:</label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" id="others_desc" name="others_desc" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_desc}}@else{{old('others_desc')}}@endif" readonly>
                                                        </div>
                                                        <div class="col-md-3 mt-2">
                                                            <input type="text" id="others_amount" name="others_amount" class="form-control" value="@if(isset($purchase->id)){{$purchase->others_amount}}@else{{old('others_amount')}}@endif" readonly>
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
                                                @if(isset($purchase->reg_date) || isset($purchase->insurance_due_date) || isset($purchase->icompany_id) || isset($purchase->policy_number))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Insurance</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="reg_date">Registration Date:</label>
                                                        <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->reg_date)->format('Y-m-d') : old('reg_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_due_date">Insurance Expiry Date:</label>
                                                        <input type="date" id="insurance_due_date" name="insurance_due_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->insurance_due_date)->format('Y-m-d') : old('insurance_due_date') }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="icompany_id">Insurance Company:</label>
                                                        <select name="icompany_id" id="icompany_id" class="form-control" required disabled>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->icompany_id) && $value == $purchase->icompany_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($purchase->id)){{$purchase->policy_number}}@else{{old('policy_number')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($purchase->expected_price))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Quotation details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="amount_input">Amount:</label>
                                                    <input type="text" name="expected_price" class="form-control" value="@if(isset($purchase->id)){{$purchase->expected_price}}@else{{old('expected_price')}}@endif" readonly>
                                                </div>
                                                @endif

                                                @if(!empty($purchase->followup_date))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Followup details </h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-3">
                                                        <label for="quoted_date_input">Follow Date:</label>
                                                        <input type="date" name="followup_date" class="form-control" value="{{ isset($purchase) ? \Carbon\Carbon::parse($purchase->followup_date)->format('Y-m-d') : old('followup_date') }}" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="follow_remarks">Remarks:</label>
                                                        <input type="text" name="follow_remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->follow_remarks}}@else{{old('follow_remarks')}}@endif" readonly>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($purchase->remarks))
                                                <hr style="border: #2A3F54 1px solid;">
                                                <h5>Closed details </h5>
                                                <div class="col-md-4 mt-3">
                                                    <label for="remarks_input">Remarks:</label>
                                                    <input type="text" name="remarks" class="form-control" value="@if(isset($purchase->id)){{$purchase->remarks}}@else{{old('remarks')}}@endif" readonly>
                                                </div>
                                                @endif
                                                <!-- <hr style="border: #2A3F54 1px solid;">
                                                <h5>Document Type</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="registration_cerificate">Registration Cerificate:</label>
                                                        <select name="registration_cerificate" id="registration_cerificate" class="form-control" disabled>
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($rcType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->registration_cerificate) && $value == $purchase->registration_cerificate? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="hypothecation">Hypothecation:</label>
                                                        <select name="hypothecation" id="registration_cerificate" class="form-control" disabled>
                                                            <option value="" disabled selected>Select Option</option>
                                                            @foreach($hypothecationType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($purchase->hypothecation) && $value == $purchase->hypothecation? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div> -->
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

    $(document).ready(function() {
        $('#refurnushment_checkbox').click(function() {
            $('#refurbnishement_div').toggle();
        });
    });
</script>
@endpush
