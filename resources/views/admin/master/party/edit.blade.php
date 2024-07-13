@extends('admin.layouts.header')

@section('title', 'Edit Party')
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
                                        <h5 class="pt-2 pb-2">@if(isset($party->id)) Edit @else Add @endif Party</h5>
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
                                                        <input type="text" name="party_name" class="form-control" data-validation-required-message="This field is required" placeholder="Party Name" value="{{$party->party_name ?? old('party_name')}}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label>Office Address</label>
                                                    <div class="controls">
                                                        <input type="text" name="office_address" data-validation-match-match="office address" class="form-control" data-validation-required-message="Confirm password must match" placeholder="Enter Office Address" value="{{$party->office_address ?? old('office_address')}}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Email</label>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control" data-validation-regex-regex="^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" data-validation-regex-message="Must be a valid url" placeholder="Enter Email" value="{{$party->email ?? old('email')}}" required>
                                                    </div>
                                                </div>


                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Office City</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    @if ($party->partyCity->isEmpty())
                                                                    <!-- If no cities exist, show a single input field -->
                                                                    <input type="text" name="office_city[]" class="form-control mt-2" data-validation-required-message="Must be a valid email" placeholder="Enter Office City" required>
                                                                    @else
                                                                    <!-- If cities exist, loop through existing cities -->
                                                                    @foreach ($party->partyCity as $city)
                                                                    <input type="text" name="office_city[]" class="form-control mt-2" data-validation-required-message="Must be a valid email" placeholder="Enter Office City" value="{{ $city->city }}" required>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-2 mt-2">
                                                                    <!-- Plus button to add more cities -->
                                                                    <button id="addCity" class="btn btn-outline-primary" type="button">+</button>
                                                                </div>
                                                            </div>
                                                            <!-- Append additional cities here if needed -->
                                                            <div id="appendCity"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label class="mr-2">Contact Number</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    @if ($party->partyContact->isEmpty())
                                                                    <!-- If no firm names exist, show a single input field -->
                                                                    <input type="text" name="office_number[]" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Contact Number">
                                                                    @else
                                                                    @foreach ($party->partyContact as $contact)
                                                                    @if ($contact->type == 2)
                                                                    <input type="text" name="office_number[]" class="form-control" data-validation-required-message="This field is required" placeholder="Enter Contact Number" value="{{$contact->number}}" required>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>

                                                                <div class="col-2">
                                                                    <button id="addContactNumber" class="btn btn-outline-primary" type="button">+</button>
                                                                </div>
                                                            </div>
                                                            <div id="appendContactNumber"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">WHATSAPP NUMBER</label>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <div class="row">
                                                                <div class="col-sm-10">
                                                                    @if ($party->partyContact->isEmpty())
                                                                    <!-- If no firm names exist, show a single input field -->
                                                                    <input type="text" name="whatsapp_number[]" class="form-control mt-2" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Whatsapp Number">
                                                                    @else
                                                                    @foreach($party->partyContact as $contact)
                                                                    @if ($contact->type == 1)
                                                                    <input type="text" name="whatsapp_number[]" class="form-control m-2" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Whatsapp Number" value="{{$contact->number}}" required>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-2 mt-2">
                                                                    <button id="addWhatsappNumber" class="btn btn-outline-primary" type="button">+</button>
                                                                </div>
                                                            </div>
                                                            <div id="appendWhatsapp"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Father Name</label>
                                                    <div class="controls">
                                                        <input type="text" name="father_name" class="form-control" data-validation-regex-regex="^[-a-zA-Z_\d]+$" data-validation-regex-message="Must Enter Character, Number, Dash or Uderscore" placeholder="Enter Father Name" value="{{$party->father_name ?? old('father_name')}}" required>
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
                                                <div class="form-group mb-2">
                                                    <label>Residence City</label>
                                                    <div class="controls">
                                                        <input type="text" name="residence_city" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Residence City" value="{{$party->residence_city ?? old('residence_city')}}" required>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group mb-2">
                                                    <label>Designation</label>
                                                    <div class="controls">
                                                        <input type="string" name="designation" class="form-control" required data-validation-containsnumber-regex="^[a-zA-Z]+$" data-validation-containsnumber-message="The alpha field may only contain alphabetic characters." placeholder="Enter Designation" value="{{$party->designation ?? old('designation')}}" required>
                                                    </div>
                                                </div> -->
                                                <div class="form-group mb-2">
                                                    <label class="mr-2">FIRM NAME</label>
                                                    <div class="input-group-append"></div>
                                                    <div class="form-group mb-2 d-flex">
                                                        <div class="controls flex-grow-1">
                                                            <div class="row col-sm-12">
                                                                <div class="col-sm-10">
                                                                    @if ($party->partyFirm->isEmpty())
                                                                    <!-- If no firm names exist, show a single input field -->
                                                                    <input type="text" name="name[]" class="form-control mt-2" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Firm Name" required>
                                                                    @else
                                                                    <!-- If firm names exist, loop through existing firm names -->
                                                                    @foreach ($party->partyFirm as $firm)
                                                                    <input type="text" name="name[]" class="form-control mt-2" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Firm Name" value="{{ $firm->firm }}" required>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-2 mt-2">
                                                                    <!-- Plus button to add more firm names -->
                                                                    <button id="addFirmname" class="btn btn-outline-primary" type="button">+</button>
                                                                </div>
                                                            </div>
                                                            <!-- Append additional firm names here if needed -->
                                                            <div id="appendFirmName"></div>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#addFirmname').on('click', function() {
            var newInput = '<div class="row mt-2">' +
                '<div class="col-sm-10">' +
                '<input type="text" name="name[]" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Firm Name">' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<button class="btn btn-outline-danger removeFirmname" type="button">-</button>' +
                '</div>' +
                '</div>';
            $('#appendFirmName').append(newInput);
        });

        // Event delegation for dynamically added remove buttons
        $('#appendFirmName').on('click', '.removeFirmname', function() {
            $(this).closest('.row').remove();
        });


        // Add new input field for WhatsApp number
        $('#addWhatsappNumber').on('click', function() {
            var newInput = '<div class="row mt-2">' +
                '<div class="col-sm-10">' +
                '<input type="text" name="whatsapp_number[]" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter WhatsApp Number">' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<button class="btn btn-outline-danger removeInput" type="button">-</button>' +
                '</div>' +
                '</div>';
            $('#appendWhatsapp').append(newInput);
        });

        // Remove input field
        $('#appendWhatsapp').on('click', '.removeWhatsappNumber', function() {
            $(this).closest('.row').remove();
        });

        // Add new input field for contact number
        $('#addContactNumber').on('click', function() {
            var newInput = '<div class="row mt-2">' +
                '<div class="col-sm-10">' +
                '<input type="text" name="office_number[]" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Contact Number">' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<button class="btn btn-outline-danger removeInput" type="button">-</button>' +
                '</div>' +
                '</div>';
            $('#appendContactNumber').append(newInput);
        });

        // Remove input field
        $('#appendContactNumber').on('click', '.removeInput', function() {
            $(this).closest('.row').remove();
        });

        // Add new input field for office city
        $('#addCity').on('click', function() {
            var newInput = '<div class="row mt-2">' +
                '<div class="col-sm-10">' +
                '<input type="text" name="office_city[]" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The numeric field may only contain numeric characters." placeholder="Enter Office City">' +
                '</div>' +
                '<div class="col-sm-2">' +
                '<button class="btn btn-outline-danger removeInput" type="button">-</button>' +
                '</div>' +
                '</div>';
            $('#appendCity').append(newInput);
        });

        // Remove input field
        $('#appendCity').on('click', '.removeInput', function() {
            $(this).closest('.row').remove();
        });





    });
</script>

@endpush
