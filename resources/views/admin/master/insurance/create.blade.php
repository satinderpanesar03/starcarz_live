@extends('admin.layouts.header')

@section('title', 'Add Insurance')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif Insurance Company</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.insurance.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <form method="post" action="{{route('admin.master.insurance.store')}}">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{$insurance->id ?? null}}">
                                                <div class="col-md-4">
                                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="@if(isset($insurance->id)){{$insurance->name}}@else{{old('name')}}@endif" required data-validation-required-message="This First Name field is required">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="address" class="form-control" placeholder="Enter Address" value="@if(isset($insurance->id)){{$insurance->address}}@else{{old('address')}}@endif" required data-validation-required-message="This First Name field is required">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="city" class="form-control" placeholder="Enter City" value="@if(isset($insurance->id)){{$insurance->city}}@else{{old('city')}}@endif" required data-validation-required-message="This First Name field is required">
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
            </section>
        </div>
    </div>
</div>
@endsection
