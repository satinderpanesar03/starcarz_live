@extends('admin.layouts.header')
@section('title', isset($sale->id) ? 'Edit Sale' :'Add Sale')
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
                                            <h5 class="pt-2 pb-2">@if(isset($sale->id)) Edit @else Add @endif Sale Enquiry</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.sale.sale.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-header">
                                    <h4 class="card-title"><b><a href="{{route('admin.sale.sale.index')}}">All Sales</a></b> / @if(isset($sale->id)) Edit @else Add @endif Sale Enquiry</h4>
                                </div> -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.sale.sale.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$sale->id ?? null}}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="enquiry_date">Enquiry Date:</label>
                                                        <input type="date" id="enquiry_date" name="enquiry_date" class="form-control" value="{{ isset($sale) ? \Carbon\Carbon::parse($sale->enquiry_date)->format('Y-m-d') : old('enquiry_date') }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="mst_executive_id">Sale Executive:</label>
                                                        <select name="mst_executive_id" id="mst_executive_id" class="form-control">
                                                            <option value="">Select Executive</option>
                                                            @foreach($executives as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->mst_executive_id) && $sale->mst_executive_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-6 mt-2">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($sale->id)){{$sale->firm_name}}@else{{old('firm_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="person_name">Person Name:</label>
                                                        <input type="text" id="person_name" name="person_name" class="form-control" value="@if(isset($sale->id)){{$sale->person_name}}@else{{old('person_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="contact_number">Contact Number:</label>
                                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($sale->id)){{$sale->contact_number}}@else{{old('contact_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="address">Address:</label>
                                                        <input type="text" id="address" name="address" class="form-control" value="@if(isset($sale->id)){{$sale->address}}@else{{old('address')}}@endif">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="city">City:</label>
                                                        <input type="text" id="city" name="city" class="form-control" value="@if(isset($sale->id)){{$sale->city}}@else{{old('city')}}@endif">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label for="email">Email:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($sale->id)){{$sale->email}}@else{{old('email')}}@endif">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="mst_model_id">Model:</label>
                                                        <select name="mst_model_id" id="mst_model_id" class="form-control">
                                                            <option value="">Select Model</option>
                                                            @foreach($models as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->mst_model_id) && $sale->mst_model_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="budget_type">Budget:</label>
                                                        <select name="budget_type" id="budget_type" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($budget as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->budget_type) && $value == $sale->budget_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="fuel_type">Fuel Type:</label>
                                                        <select name="fuel_type" id="fuel_type" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($fuelType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->fuel_type) && $value == $sale->fuel_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="finance_requirement">finance:</label>
                                                        <select name="finance_requirement" id="finance_requirement" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($finance as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->finance_requirement) && $value == $sale->finance_requirement? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="enquiry_type">Enquiry Type:</label>
                                                        <select name="enquiry_type" id="enquiry_type" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($enquiryType as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($sale->enquiry_type) && $value == $sale->enquiry_type? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-5 mt-2">
                                                        <label for="remarks">Remarks:</label>
                                                        <input type="text" id="remarks" name="remarks" class="form-control" value="@if(isset($sale->id)){{$sale->remarks}}@else{{old('remarks')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="followup_date">Followup Date:</label>
                                                        <input type="date" id="followup_date" name="followup_date" class="form-control" value="{{ isset($sale) ? \Carbon\Carbon::parse($sale->followup_date)->format('Y-m-d') : old('followup_date') }}">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-2">Save</button>
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