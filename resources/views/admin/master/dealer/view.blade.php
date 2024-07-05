@extends('admin.layouts.header')

@section('title', 'View Dealer')
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
                                            <h5 class="pt-2 pb-2">View Dealer</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.dealer.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center"> <!-- Center the row -->
                                        <div class="col-sm-12">
                                            <form>
                                                @csrf
                                                <input type="hidden" name="id" value="{{$dealer->id ?? null}}">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2">
                                                                <label>Name</label>
                                                                <div class="controls">
                                                                    <input type="text" name="name" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Name" value="{{$dealer->name ?? old('name')}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label>Dealer City</label>
                                                                <div class="controls">
                                                                    <input type="text" name="city" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Dealer City" value="{{$dealer->city ?? old('whatsapp_number')}}" readonly>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="form-group mb-2">
                                                                <label>Status</label>
                                                                <div class="controls">
                                                                    <input type="text" name="status" data-validation-match-match="office address" class="form-control" data-validation-required-message="Confirm password must match" placeholder="Enter Dealer" value="{{$dealer->status ?? old('status')}}" readonly>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2">
                                                                <label>Address</label>
                                                                <div class="controls">
                                                                    <input type="text" name="address" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Name" value="{{$dealer->address ?? old('address')}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label>Phone</label>
                                                                <div class="controls">
                                                                    <input type="text" name="phone" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Phone" value="{{$dealer->phone ?? old('phone')}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
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