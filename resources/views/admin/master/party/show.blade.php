@extends('admin.layouts.header')

@section('title', 'View Party')
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
            <section id="input-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">View Party</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.party.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form novalidate method="post" action="{{route('admin.master.party.store')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$party->id ?? null}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Party Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="party_name" class="form-control" data-validation-readonly-message="This field is readonly" placeholder="Party Name" value="{{$party->party_name ?? old('party_name')}}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label>Office Address</label>
                                                    <div class="controls">
                                                        <input type="text" name="office_address" data-validation-match-match="office address" class="form-control" data-validation-readonly-message="Confirm password must match" placeholder="Enter Office Address" value="{{$party->office_address ?? old('office_address')}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Email</label>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Email" value="{{$party->email ?? old('email')}}" readonly>
                                                    </div>
                                                </div>


                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Office City</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="row col-sm-12" id="appendCity">
                                                            <div class="col-sm-12">
                                                                <div class="controls flex-grow-1">
                                                                    @if ($party->partyCity)
                                                                    @foreach ($party->partyCity as $city)
                                                                    <input type="email" name="office_city[]" class="form-control mt-2" data-validation-readonly-message="Must be a valid email" placeholder="Enter Office City" value="{{$city->city}}" readonly>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!-- <div id="appendCity"></div> -->
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Contact Number</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="row col-12 mr-2" id="appendContactNumber">
                                                            <div class="col-12">
                                                                <div class="controls flex-grow-1">
                                                                    @if ($party->partyContact)
                                                                    @foreach ($party->partyContact as $contact)
                                                                    @if ($contact->type == 2)
                                                                    <input type="text" name="office_number[]" class="form-control mt-2" data-validation-readonly-message="This field is readonly" placeholder="Enter Contact Number" value="{{$contact->number}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Residence Address</label>
                                                    <div class="controls">
                                                        <input type="text" name="residence_address" class="form-control" data-validation-regex-regex="^[-a-zA-Z_\d]+$" data-validation-regex-message="Must Enter Character, Number, Dash or Uderscore" placeholder="Enter Residence Address" value="{{$party->residence_address ?? old('residence_address')}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Pan Card Number</label>
                                                    <div class="controls">
                                                        <input type="string" name="pan_number" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Pan Card Number" value="{{$party->pan_number ??old('pan_number')}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Residence City</label>
                                                    <div class="controls">
                                                        <input type="text" name="residence_city" class="form-control" readonly data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Residence City" value="{{$party->residence_city ?? old('residence_city')}}" readonly>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group mb-2">
                                                    <label>Designation</label>
                                                    <div class="controls">
                                                        <input type="string" name="designation" class="form-control" readonly data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Designation" value="{{$party->designation ?? old('designation')}}" readonly>
                                                    </div>
                                                </div> -->
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">FIRM NAME</label>
                                                    <div class="input-group-append">

                                                    </div>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <div class="row col-sm-12">
                                                                <div class="col-sm-12">
                                                                    @if ($party->partyFirm)
                                                                    @foreach ($party->partyFirm as $firm)
                                                                    
                                                                    <input type="text" name="name[]" class="form-control mt-2" readonly data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Firm Name" value="{{$firm->firm}}" readonly>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div id="appendFirmName"></div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="form-group mb-2">
                                                    <label class="mr-2">WHATSAPP NUMBER</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="row col-sm-12" id="appendWhatsapp">
                                                            <div class="col-sm-12">
                                                                <div class="controls flex-grow-1">
                                                                    @if ($party->partyContact)
                                                                    @foreach($party->partyContact as $contact)
                                                                    @if ($contact->type == 1)
                                                                    <input type="text" name="whatsapp_number[]" class="form-control m-2" readonly data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Whatsapp Number" value="{{$contact->number}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
