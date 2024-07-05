@extends('admin.layouts.header')
@section('title', isset($agent->id) ? 'Edit Agent' : 'Add Agent')
@section('content')
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="input-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">@if(isset($agent->id)) Edit @else Add @endif Agent</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.rto.agent.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <form novalidate method="post" action="{{route('admin.master.rto.agent.store')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$agent->id ?? null}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Agent Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="agent" class="form-control" data-validation-required-message="This field is required" placeholder="Agent Name" value="{{$agent->agent ?? old('agent')}}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label>Email</label>
                                                    <div class="controls">
                                                        <input type="text" name="email" data-validation-match-match="office address" class="form-control" data-validation-required-message="Confirm password must match" placeholder="Enter Email" value="{{$agent->email ?? old('email')}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               
                                                <div class="form-group mb-2">
                                                    <label>Phone Number</label>
                                                    <div class="controls">
                                                        <input type="number" name="phone_number" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Phone Number" value="{{$agent->phone_number ??old('phone_number')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Location</label>
                                                    <div class="controls">
                                                        <input type="text" name="location" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Location" value="{{$agent->location ?? old('location')}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
            </section>
        </div>
    </div>

</div>
@endsection
