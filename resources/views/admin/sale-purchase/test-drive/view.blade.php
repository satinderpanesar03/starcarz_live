@extends('admin.layouts.header')

@section('title', 'View Drive')
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
                                                    <h5 class="pt-2">View Test Drive</h5>
                                                </div>
                                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                    <a href="#" class="btn btn-sm btn-primary px-3 py-1" onclick="window.history.back();">
                                                        <i class="fa fa-arrow-left"></i> Back
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <form method="post" action="{{route('admin.sale.sale.store')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row justify-content-center">
                                                            <input type="hidden" value="1" name="party_id">
                                                            <input type="hidden" name="mst_party_id">
                                                            <div class="col-md-4">
                                                                <label for="mst_party_id">Party</label>
                                                                <select name="party_id" id="mst_party_id" class="form-control" disabled>
                                                                    <option value="" selected disabled>Choose...</option>
                                                                    @foreach ($parties as $party)
                                                                    <option value="{{$party->id}}" {{ isset($testDrive->id) && $testDrive->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="vehicle_number">Vehicle Number</label>
                                                                <input type="text" id="drive_date" name="drive_date" class="form-control" value="{{ isset($car_number) ? $car_number : old('drive_date') }}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row justify-content-center">
                                                            <div class="col-md-4 mt-2">
                                                                <label for="drive_date">Transfer Date:</label>
                                                                <input type="date" id="drive_date" name="drive_date" class="form-control" value="{{ isset($testDrive) ? \Carbon\Carbon::parse($testDrive->drive_date)->format('Y-m-d') : old('drive_date') }}" readonly>
                                                            </div>
                                                            <div class="col-md-4 mt-2">
                                                                <img src="{{ asset('storage/' . $testDrive->image) }}" alt="Image" style="max-width: 150px; height: auto;">
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

        $('#mode').change(function(e) {
            $('#mode').val($(this).val());
            var mode = this.value;

            if (mode) {
                $.ajax({
                    url: '/fetch-status',
                    type: 'GET',
                    data: {
                        mode: mode
                    },
                    success: function(data) {
                        console.log(data);
                        $('#vehicle_number').html('<option value="">Select Vehicle</option>');
                        $.each(data, function(key, value) {
                            $('#vehicle_number').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#vehicle_number').html('<option value="">Select Vehicle</option>');
            }

        });


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

        $('#vehicle_number_s').change(function(e) {
            $('#vehicle_number_s').val($(this).val());
            var vehicle = this.value;

            $.ajax({
                url: '/fetch-vehicles',
                type: 'GET',
                data: {
                    vehicle: vehicle
                },
                success: function(response) {
                    $('#brand_s').val(response.brand);
                    $('#color_s').val(response.color);
                    $('#manufacturing_year_s').val(response.manufacturing_year);
                    $('#registration_year_s').val(response.registration_year);
                    $('#kilometer_s').val(response.kilometer);
                    $('#expectation_s').val(response.expectation);
                    $('#owners_s').val(response.owners);
                    $('#fuel_type_s').val(response.fuel_type);
                    $('#shape_type_s').val(response.shape_type);
                    $('#engine_number_s').val(response.engine_number);
                    $('#chasis_number_s').val(response.chasis_number);
                    $('#service_booklet_s').val(response.service_booklet);
                    $('#date_of_purchase_s').val(response.date_of_purchase);
                    $('#suggestion_vehicle_id').val(response.purchase_id);


                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        });
        $('#vehicle_number_s').trigger('change');

    });
</script>
@endpush