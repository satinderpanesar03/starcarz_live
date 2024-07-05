@extends('admin.layouts.header')

@section('title', 'RC Transfer')
@section('content')
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <!--Extended Table starts-->
            <section id="positioning">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                            <div class="row">
                                                <div class="col-12 col-sm-7">
                                                    <h5 class="pt-2">View RC Transfer</h5>
                                                </div>
                                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                    <a href="{{route('admin.rc-transfer.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                        <i class="fa fa-arrow-left"></i> Back </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <form method="post" action="{{route('admin.rc-transfer.store')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $rcTransfer->id ?? null }}">
                                                        <input type="hidden" name="purchase_id" id="purchase_id">
                                                        <div class="row">
                                                            <input type="hidden" value="1" name="party_id">
                                                            <div class="col-md-4 mt-2">
                                                                <label for="party_id">Party</label>
                                                                <select name="party_id" id="mst_party_id" class="form-control" disabled>
                                                                    <option value="" selected disabled>Choose...</option>
                                                                    @foreach ($parties as $party)
                                                                    <option value="{{$party->id}}" {{ isset($rcTransfer->id) && $rcTransfer->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="registered_owner">Registered Owner:</label>
                                                                <input type="text" id="registered_owner" name="registered_owner" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="email">Email:</label>
                                                                <input type="text" id="email" name="email" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 mt-2">
                                                                <label for="contact_number">Contact Number:</label>
                                                                <input type="text" id="contact_number" name="contact_number" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="address">Address:</label>
                                                                <input type="text" id="address" name="address" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="city">City:</label>
                                                                <input type="text" id="city" name="city" class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <hr style="border: #2A3F54 1px solid;">
                                                        <h5>Vehicle Details</h5>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div>
                                                                    <label for="vehicle_number">Vehicle Number</label>
                                                                    <select name="vehicle_id" id="vehicle_number" class="form-control" disabled>
                                                                        <option value="">Choose...</option>
                                                                        @foreach ($vehicles as $vehicle)
                                                                        <option value="{{$vehicle->id}}" {{ isset($rcTransfer->id) && $rcTransfer->vehicle_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="mst_brand_type_id">Brand:</label>
                                                                <input class="form-control" type="text" name="brand" id="brand" readonly>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="mst_color_id">Color:</label>
                                                                <input class="form-control" type="text" name="color" id="color" readonly>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="manufacturing_year">Manufacturing Year:</label>
                                                                <input type="text" id="manufacturing_year" name="manufacturing_year" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 mt-3">
                                                                <label for="registration_year">Registration Year:</label>
                                                                <input type="text" id="registration_year" name="registration_year" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="kilometer">Kilometer:</label>
                                                                <input type="text" id="kilometer" name="kilometer" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="expectation">Expectation:</label>
                                                                <input type="text" id="expectation" name="expectation" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="date_of_purchase">Date Of Purchase:</label>
                                                                <input type="date" id="date_of_purchase" name="date_of_purchase" class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3 mt-3">
                                                                <label for="owners">Owners:</label>
                                                                <input type="text" id="owners" name="owners" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="fuel_type">Fuel Type:</label>
                                                                <input type="text" id="fuel_type" name="fuel_type" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="shape_type">Shape Type:</label>
                                                                <input type="text" id="shape_type" name="shape_type" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="engine_number">Engine Number:</label>
                                                                <input type="text" id="engine_number" name="engine_number" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="chasis_number">Chasis Number:</label>
                                                                <input type="text" id="chasis_number" name="chasis_number" class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <label for="service_booklet">Service Booklet:</label>
                                                                <input type="text" id="service_booklet" name="service_booklet" class="form-control" readonly>
                                                            </div>

                                                        </div>
                                                        <hr style="border: #2A3F54 1px solid;">
                                                        <div class="row">
                                                            <div class="col-md-4 mt-2">
                                                                <label for="agent_id">Agent:</label>
                                                                <select name="agent_id" id="agent_id" class="form-control" required disabled>
                                                                    <option value="" disabled selected>Choose...</option>
                                                                    @foreach($agents as $value => $label)
                                                                    <option value="{{ $value }}" {{ isset($rcTransfer->agent_id) && $value == $rcTransfer->agent_id? 'selected' : '' }}>{{ $label }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <label for="transfer_date">Transfer Date:</label>
                                                                <input type="date" id="transfer_date" name="transfer_date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->transfer_date)->format('Y-m-d') : old('transfer_date') }}" readonly>
                                                            </div>
                                                        </div>
                                                        <!-- <button type="submit" id="save_button" class="btn btn-primary mt-3">Save</button> -->
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#mst_party_id').change(function(e) {
            $('#mst_party_id').val($(this).val());
            var partyId = this.value;

            $('#demand_party_id').val(partyId);

            $.ajax({
                url: '/fetch-data',
                type: 'GET',
                data: {
                    party_id: partyId
                },
                success: function(response) {
                    console.log(response);
                    $('#registered_owner').val(response.party_name);
                    $('#email').val(response.email);
                    $('#contact_number').val(response.office_number);
                    $('#address').val(response.office_address);
                    $('#city').val(response.residence_city);
                    $('#contact_number').val(response.contact_number);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#mst_party_id').trigger('change');


        $('#vehicle_number').change(function(e) {
            $('#vehicle_number').val($(this).val());
            var vehicle = this.value;

            $.ajax({
                url: '/fetch-vehicles',
                type: 'GET',
                data: {
                    vehicle: vehicle
                },
                success: function(response) {
                    $('#brand').val(response.brand);
                    $('#color').val(response.color);
                    $('#manufacturing_year').val(response.manufacturing_year);
                    $('#registration_year').val(response.registration_year);
                    $('#kilometer').val(response.kilometer);
                    $('#expectation').val(response.expectation);
                    $('#owners').val(response.owners);
                    $('#fuel_type').val(response.fuel_type);
                    $('#shape_type').val(response.shape_type);
                    $('#engine_number').val(response.engine_number);
                    $('#chasis_number').val(response.chasis_number);
                    $('#service_booklet').val(response.service_booklet);
                    $('#date_of_purchase').val(response.date_of_purchase);
                    $('#vehicle_id').val(response.purchase_id);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number').trigger('change');
    });
</script>
@endpush