@extends('admin.layouts.header')

@section('title', 'Add Party')
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
                            <div class="card-header">
                                <h4 class="card-title"><b><a href="{{route('admin.master.party.index')}}">All Parties</a></b> / @if(isset($party->id)) Edit @else Add @endif New Party</h4>
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
                                                        <input type="text" name="party_name" class="form-control" data-validation-required-message="This field is required" placeholder="Party Name" value="{{$party->party_name ?? old('party_name')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">WHATSAPP NUMBER</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <input type="text" name="whatsapp_number[]" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Whatsapp Number" value="<?php
                                                            if($party){
                                                                foreach($party->partyContact as $contact){
                                                                    if($contact->type == 1){
                                                                        echo $contact->number;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                                ?>" required>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button data-toggle="modal" data-target="#addWhatsappNumber" class="btn btn-outline-primary" type="button">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Office  </label>
                                                    <div class="controls">
                                                        <input type="text" name="office_address" data-validation-match-match="office address" class="form-control" data-validation-required-message="Confirm password must match" placeholder="Enter Office Address" value="{{$party->office_address ?? old('office_address')}}"  required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Email</label>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Email" value="{{$party->email ?? old('email')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Residence City</label>
                                                    <div class="controls">
                                                        <input type="text" name="residence_city" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Residence City" value="{{$party->residence_city ?? old('residence_city')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Designation</label>
                                                    <div class="controls">
                                                        <input type="string" name="designation" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Designation" value="{{$party->designation ?? old('designation')}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">FIRM NAME</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <input type="text" name="name[]" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Firm Name" value="<?php
                                                            if($party){
                                                                foreach($party->partyFirm as $party){
                                                                    echo $party->firm;
                                                                    break;
                                                                }
                                                            }
                                                                ?>" required>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button data-toggle="modal" data-target="#addFirmname"  class="btn btn-outline-primary" type="button">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Contact Number</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <input type="text" name="office_number[]" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Office Contact Number" value="<?php
                                                            if($party){
                                                                foreach($party->partyContact as $contact){
                                                                    if($contact->type == 2){
                                                                        echo $contact->number;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            ?>"  required>
                                                        </div>
                                                        <div data-toggle="modal" data-target="#addContactNumber" class="input-group-append">
                                                            <button class="btn btn-outline-primary" type="button">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Office City</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <input type="email" name="office_city[]" class="form-control" data-validation-required-message="Must be a valid email" placeholder="Enter Office City" value="{{$party->partyCity[0]->city ?? old('city')}}"  required>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button data-toggle="modal" data-target="#addCity" class="btn btn-outline-primary" type="button">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Residence Address</label>
                                                    <div class="controls">
                                                        <input type="text" name="residence_address" class="form-control" data-validation-regex-regex="^[-a-zA-Z_\d]+$" data-validation-regex-message="Must Enter Character, Number, Dash or Uderscore" placeholder="Enter Residence Address" value="{{$party->residence_address ?? old('residence_address')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Pan Card Number</label>
                                                    <div class="controls">
                                                        <input type="string" name="pan_number" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Pan Card Number" value="{{$party->pan_number ??old('pan_number')}}" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>
<!-- whatsapp Modal -->
<div class="modal fade text-left" id="addWhatsappNumber" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Add Whatsapp Number</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="number" placeholder="Whatsapp Number" class="form-control" name="whatsapp_number[]" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                                    <input data-dismiss="modal" class="btn btn-primary" value="Save">
                                </div>
                        </div>
                    </div>
                </div>
<!-- whatsapp Modal -->
<!-- firm name Modal -->
<div class="modal fade text-left" id="addFirmname" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Add Another Firm Name</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" placeholder="Firm Name" name="name[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                                    <input data-dismiss="modal" class="btn btn-primary" value="Save">
                                </div>
                        </div>
                    </div>
                </div>
<!-- firm name Modal -->

<!-- contact -->
<div class="modal fade text-left" id="addContactNumber" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Add Another Contact Number</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" placeholder="Contact Number" class="form-control" name="office_number[]" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                                    <input data-dismiss="modal" class="btn btn-primary" value="Save">
                                </div>
                        </div>
                    </div>
                </div>
<!-- contact -->

<!-- city -->
<div class="modal fade text-left" id="addCity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Add Another City</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" placeholder="City" name="office_city[]" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="Close">
                                    <input data-dismiss="modal" class="btn btn-primary" value="Save">
                                </div>
                        </div>
                    </div>
                </div>
<!-- city -->
</form>
@endsection