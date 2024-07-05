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
                                                            <input type="hidden" name="mst_party_id">
                                                            <div class="col-md-4">
                                                                <label for="mst_party_id">Party</label>
                                                                <select name="party_id" id="mst_party_id" class="form-control" disabled>
                                                                    <option value="" selected disabled>Choose...</option>
                                                                    @foreach ($parties as $party)
                                                                    <option value="{{$party->id}}" {{ isset($rcTransfer->id) && $rcTransfer->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="vehicle_number">Vehicle Number</label>
                                                                <select name="purchase_id" id="vehicle_number" class="form-control" disabled>
                                                                    <option value="">Choose...</option>
                                                                    @foreach ($vehicles as $vehicle)
                                                                    <option value="{{$vehicle->id}}" {{ isset($rcTransfer->id) && $rcTransfer->vehicle_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                        </div>

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