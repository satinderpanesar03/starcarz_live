@extends('admin.layouts.header')
@section('title', isset($rcTransfer->id) ? 'Edit RC Transfer' : 'Add RC Transfer')
@section('content')

<head>
    <!-- Other head elements -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

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
                                            <h5 class="pt-2 pb-2">@if(isset($rcTransfer->id)) Edit @else Add @endif RC Transfer</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.rc-transfer.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- div -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.rc-transfer.store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="mst_purchase_id" id="purchase_id">

                                                <input type="hidden" name="id" value="{{ $rcTransfer->id ?? null }}">
                                                <div class="row">
                                                    <input type="hidden" name="mst_party_id">
                                                    <div class="col-md-4">
                                                        <label for="mst_party_id">Party</label>
                                                        <select name="party_id" id="mst_party_id" class="form-control">
                                                            <option value="" selected disabled>Choose...</option>
                                                            @foreach ($parties as $party)
                                                            <option value="{{$party->id}}" {{ isset($rcTransfer->id) && $rcTransfer->mst_party_id == $party->id ? ' selected' : '' }}>{{$party->party_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <select name="purchase_id" id="vehicle_number" class="form-control">
                                                            <option value="">Choose...</option>
                                                            @foreach ($vehicles as $vehicle)
                                                            <option value="{{$vehicle->id}}" {{ isset($rcTransfer->id) && $rcTransfer->vehicle_id == $vehicle->id ? ' selected' : '' }}>{{strtoupper($vehicle->reg_number)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="agent_id">Agent:</label>
                                                        <select name="agent_id" id="agent_id" class="form-control" required>
                                                            <option value="" disabled selected>Choose...</option>
                                                            @foreach($agents as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($rcTransfer->agent_id) && $value == $rcTransfer->agent_id? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="transfer_date">Transfer Date:</label>
                                                        <input type="date" id="transfer_date" name="transfer_date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->transfer_date)->format('Y-m-d') : old('transfer_date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="date">Doc Given Date:</label>
                                                        <input type="date" id="date" name="date" class="form-control" value="{{ isset($rcTransfer) ? \Carbon\Carbon::parse($rcTransfer->date)->format('Y-m-d') : old('date') }}">
                                                    </div>
                                                    <div class="col-md-4 mt-2">
                                                        <label for="amount_paid">Amount Paid:</label>
                                                        <input type="text" id="amount_paid" name="amount_paid" class="form-control" value="@if(isset($rcTransfer->id)){{$rcTransfer->amount_paid}}@else{{old('amount_paid')}}@endif">
                                                    </div>
                                                </div>

                                                <button type="submit" id="save_button" class="btn btn-primary mt-3">Save</button>
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
        $('#example').DataTable({
            // data: name,
            deferRender: true,
            // scrollY:        200,
            scrollCollapse: true,
            scroller: true,
            info: false,
            "bPaginate": false
        });
    });

    $(document).ready(function() {
        $('#mst_party_id').change(function(e) {
            $('#mst_party_id').val($(this).val());
            var partyId = this.value;

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
                    $('#purchase_id').val(response.purchase_id);
                    var regDate = new Date(response.reg_date);
                    var insuranceDueDate = new Date(response.insurance_due_date);
                    $('#reg_date').val(regDate.toISOString().split('T')[0]);
                    $('#insurance_due_date').val(insuranceDueDate.toISOString().split('T')[0]);
                    $('#icompany_id').append('<option value="' + response.icompany_id + '">' + response.icompany_id + '</option>');
                    $('#policy_number').val(response.policy_number);

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