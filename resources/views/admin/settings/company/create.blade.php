@extends('admin.layouts.header')

@section('title', isset($company->id) ? 'Edit Company' : 'Add Company')
@section('content')
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="simple-validation">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">@if(isset($company->id)) Edit @else Add @endif Company</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.dashboard.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <form method="post" action="{{route('admin.setting.company.store')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$company->id ?? null}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="name">Name:</label>
                                                    <input type="text" id="name" name="name" class="form-control" value="@if(isset($company->id)){{$company->name}}@else{{old('name')}}@endif">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phone_number">Phone No.:</label>
                                                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="@if(isset($company->id)){{$company->phone_number}}@else{{old('phone_number')}}@endif">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="gst_number">GST No.:</label>
                                                    <input type="text" id="gst_number" name="gst_number" class="form-control" value="@if(isset($company->id)){{$company->gst_number}}@else{{old('gst_number')}}@endif">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="email" value="{{ $company->email ?? old('email') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="website" class="form-label">Website</label>
                                                    <input type="text" class="form-control" name="website" value="{{ $company->website ?? old('website') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="logo" class="form-label">Logo</label>
                                                    <input type="file" class="form-control" name="logo">
                                                </div>
                                                @if(isset($company->logo))
                                                <div class="mt-4">
                                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" style="max-width: 150px; height: auto;">
                                                </div>
                                                @endif
                                            </div>
                                            <hr style="border: #2A3F54 1px solid;">
                                            <h5>Address</h5>
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    <label for="address">Address:</label>
                                                    <input type="text" class="form-control" name="address" value="{{ $company->address ?? old('address') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="state">State:</label>
                                                    <input type="text" class="form-control" name="state" value="{{ $company->state ?? old('state') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="city">City:</label>
                                                    <input type="text" id="city" name="city" class="form-control" value="@if(isset($company->id)){{$company->city}}@else{{old('city')}}@endif">
                                                </div>
                                            </div>
                                            <hr style="border: #2A3F54 1px solid;">
                                            <h5>Bank Information</h5>
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <label for="bank_name">Bank Name:</label>
                                                    <input type="text" class="form-control" name="bank_name" value="{{ $company->bank_name ?? old('bank_name') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="account_name">Account Name:</label>
                                                    <input type="text" class="form-control" name="account_name" value="{{ $company->account_name ?? old('account_name') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="ifsc_code">IFSC Code:</label>
                                                    <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" value="@if(isset($company->id)){{$company->ifsc_code}}@else{{old('ifsc_code')}}@endif">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="account_number">Account No.:</label>
                                                    <input type="text" id="account_number" name="account_number" class="form-control" value="@if(isset($company->id)){{$company->account_number}}@else{{old('account_number')}}@endif">
                                                </div>
                                            </div>
                                            <hr style="border: #2A3F54 1px solid;">
                                            <h5>Terms & Conditions</h5>
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    <label for="term_condition">Terms & Conditions:</label>
                                                    <textarea class="form-control" id="term_condition" name="term_condition" required>@if(isset($company->id)) {{ $company->term_condition }}@else{{ old('term_condition') }}@endif</textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">@if(isset($company->id)) Update @else Save @endif</button>
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
    $(document).ready(function() {
        // Initialize CKEditor on the textarea with the id 'terms_and_conditions'
        CKEDITOR.replace('term_condition');
    });
</script>
@endpush