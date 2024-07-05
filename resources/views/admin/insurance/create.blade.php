@extends('admin.layouts.header')
@section('title', ($type == false) ? 'Add Insurance' : 'Add General Insurance')
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
                                            @if ($type == false)
                                            <div class="col-12 col-sm-7">
                                                <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif Insurance</h5>
                                            </div>
                                            @else
                                            <div class="col-12 col-sm-7">
                                                <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif General Insurance</h5>
                                            </div>
                                            @endif
                                        </div>
                                        @if ($type == false)
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                        @else
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.insurance.general.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.insurance.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $insurance->id ?? null }}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="firm_name">Firm Name:</label>
                                                        <input type="text" id="firm_name" name="firm_name" class="form-control" value="@if(isset($insurance->id)){{$insurance->firm_name}}@else{{old('firm_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="person_name">Person Name:</label>
                                                        <input type="text" id="person_name" name="person_name" class="form-control" value="@if(isset($insurance->id)){{$insurance->person_name}}@else{{old('person_name')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="whatsapp_number">WhatsApp Number:</label>
                                                        <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control" value="@if(isset($insurance->id)){{$insurance->whatsapp_number}}@else{{old('whatsapp_number')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="office_address">Office Address:</label>
                                                        <input type="text" id="office_address" name="office_address" class="form-control" value="@if(isset($insurance->id)){{$insurance->office_address}}@else{{old('office_address')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="office_city">Office City:</label>
                                                        <input type="text" id="office_city" name="office_city" class="form-control" value="@if(isset($insurance->id)){{$insurance->office_city}}@else{{old('office_city')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="office_number">Office Contact Number:</label>
                                                        <input type="text" id="office_number" name="office_number" class="form-control" value="@if(isset($insurance->id)){{$insurance->office_number}}@else{{old('office_number')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="residence_address">Residence Address:</label>
                                                        <input type="text" id="residence_address" name="residence_address" class="form-control" value="@if(isset($insurance->id)){{$insurance->residence_address}}@else{{old('residence_address')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="residence_city">Residence City:</label>
                                                        <input type="text" id="residence_city" name="residence_city" class="form-control" value="@if(isset($insurance->id)){{$insurance->residence_city}}@else{{old('residence_city')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="residence_number">Residence Contact Number:</label>
                                                        <input type="text" id="residence_number" name="residence_number" class="form-control" value="@if(isset($insurance->id)){{$insurance->residence_number}}@else{{old('residence_number')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="email">Email Address:</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="@if(isset($insurance->id)){{$insurance->email}}@else{{old('email')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="designation">Designation:</label>
                                                        <input type="text" id="designation" name="designation" class="form-control" value="@if(isset($insurance->id)){{$insurance->designation}}@else{{old('designation')}}@endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pan_number">Pan Number:</label>
                                                        <input type="text" id="pan_number" name="pan_number" class="form-control" value="@if(isset($insurance->id)){{$insurance->pan_number}}@else{{old('pan_number')}}@endif">
                                                    </div>
                                                </div>
                                                <hr style="border: #2A3F54 1px solid;">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="executive_id">Sale Executive:</label>
                                                        <select name="executive_id" id="executive_id" class="form-control" required>
                                                            <option value="">Select Executive</option>
                                                            @foreach($excutives as $id => $name)
                                                            <option value="{{ $id }}" {{ isset($selectedExecutiveId) && $id == $selectedExecutiveId ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_id">Insurance Type:</label>
                                                        <select name="insurance_id" id="insurance_type" class="form-control" required>
                                                            <option value="" selected>Select Insurance Type</option>
                                                            @foreach($dropdownOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ ((isset($insurance->insurance_id) && $insurance->insurance_id == $value) || ($type)) ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_type_id">Insurance Sub Type:</label>
                                                        <select name="insurance_type_id" id="insurance_subtype" class="form-control" required>
                                                            <option value="">Select Insurance Type</option>
                                                            @foreach($insuranceTypes as $id => $name)
                                                            <option value="{{ $id }}" @if(isset($insurance->insurance_type_id) && $id == $insurance->insurance_type_id) selected @endif>{{ ucfirst($name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @if($type == True)
                                                    <div class="col-md-4 mt-2">
                                                        <label for="covered_insurance">Insurance Covered:</label>
                                                        <select name="covered_insurance[]" id="covered_insurance" class="form-select mb-1" required multiple>
                                                            <option value="">Select Covered Insurance</option>
                                                            @foreach($coveredInsurance as $insurance)
                                                            <option value="{{ $insurance->id }}">{{ ucfirst($insurance->title) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_date">Insurance Done Date:</label>
                                                        <input type="date" id="insurance_date" name="insurance_date" class="form-control" value="{{ isset($insurance) ? \Carbon\Carbon::parse($insurance->insurance_date)->format('Y-m-d') : old('insurance_date') }}" required>
                                                    </div>

                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_from_date">Insurance From Date:</label>
                                                        <input type="date" id="insurance_from_date" name="insurance_from_date" class="form-control" value="{{ isset($insurance) ? \Carbon\Carbon::parse($insurance->insurance_from_date)->format('Y-m-d') : old('insurance_from_date') }}" required>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insurance_to_date">Insurance To Date:</label>
                                                        <input type="date" id="insurance_to_date" name="insurance_to_date" class="form-control" value="{{ isset($insurance) ? \Carbon\Carbon::parse($insurance->insurance_to_date)->format('Y-m-d') : old('insurance_to_date') }}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="company_id">Insurance Company:</label>
                                                        <select name="company_id" id="company_id" class="form-control" required>
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($company as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($insurance->company_id) && $value == $insurance->company_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="premium">Premium:</label>
                                                        <input type="text" id="premium" name="premium" class="form-control" value="@if(isset($insurance->id)){{$insurance->premium}}@else{{old('premium')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="gst">GST:</label>
                                                        <input type="text" id="gst" name="gst" class="form-control" value="@if(isset($insurance->id)){{$insurance->gst}}@else{{old('gst')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="total">Total:</label>
                                                        <input type="text" id="total" name="total" class="form-control" value="@if(isset($insurance->id)){{$insurance->total}}@else{{old('total')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="sum_assured">Sum Assured:</label>
                                                        <input type="text" id="sum_assured" name="sum_assured" class="form-control" value="@if(isset($insurance->id)){{$insurance->sum_assured}}@else{{old('sum_assured')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="insured_by">Insured By:</label>
                                                        <select name="insured_by" id="insured_by" class="form-control" required>
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($insureddropdownOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($insurance->insured_by) && $value == $insurance->insured_by? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="policy_number">Policy No.:</label>
                                                        <input type="text" id="policy_number" name="policy_number" class="form-control" value="@if(isset($insurance->id)){{$insurance->policy_number}}@else{{old('policy_number')}}@endif">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="broker_id">Broker:</label>
                                                        <select name="broker_id" id="broker_id" class="form-control">
                                                            <option value="" disabled selected>Select Company</option>
                                                            @foreach($broker as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($insurance->broker_id) && $value == $insurance->broker_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="broker_percentage">Broker Percentage:</label>
                                                        <input type="text" id="broker_percentage" name="broker_percentage" class="form-control" value="@if(isset($insurance->id)){{$insurance->broker_percentage}}@else{{old('broker_percentage')}}@endif">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label for="coverge_detail">Coverge Detail:</label>
                                                        <textarea id="coverge_detail" name="coverge_detail" class="form-control" rows="5">@if(isset($insurance->id)) {{ $insurance->coverge_detail }}@else{{ old('coverge_detail') }}@endif</textarea>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">Save</button>
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
<script>
    function isUpdateCase() {
        var insuranceId = $('#insurance_type').val();
        if (insuranceId && insuranceId !== '') {
            return true;
        }

        return false;
    }
    if (!isUpdateCase()) {
        $(document).ready(function() {
            // Trigger the change event on page load
            $('#insurance_type').trigger('change');
        });
    }

    $('#insurance_type').change(function(e) {
        var selectedType = $(this).val();
        if (selectedType) {
            $.ajax({
                url: '{{ route("admin.insurance.getInsuranceSubTypes") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'insurance_type': selectedType
                },
                success: function(response) {
                    $('#insurance_subtype').html(response);
                }
            });
        }
    });
</script>
@endsection

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').selectize({
            plugins: ["remove_button"],
        });
    });
</script>
@endpush