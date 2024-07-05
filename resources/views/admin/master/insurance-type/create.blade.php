@extends('admin.layouts.header')
@section('title', isset($insurance->id) ? 'Edit Insurance Type' : 'Add Insurance Type')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif Insurance Type</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.insurance-type.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-6">
                                            <form method="post" action="{{route('admin.master.insurance-type.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$insurance->id ?? null}}">
                                                <div class="form-group row">
                                                    <label for="insurance_id" class="col-md-3 col-form-label">Insurance:</label>
                                                    <div class="col-md-9">
                                                        <select name="insurance_id" id="insurance_id" class="form-control" required>
                                                            <option value="">Choose...</option>
                                                            @foreach($dropdownOptions as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($insurance) && $insurance->insurance_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-3 col-form-label">Name:</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Insurance Type" value="@if(isset($insurance->id)){{$insurance->name}}@else{{old('name')}}@endif" required>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="status" name="status" value="1" {{ isset($insurance) && $insurance->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label font-weight-bold" for="status">On</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="status" name="status" value="0" {{ isset($insurance) && $insurance->status == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label font-weight-bold" for="status">Off</label>
                                                    </div>
                                                </div> -->
                                                <div class="form-group row">
                                                    <div class="col-md-9 offset-md-3">
                                                        <button type="submit" class="btn btn-primary">Save</button>
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
</script>
@endpush