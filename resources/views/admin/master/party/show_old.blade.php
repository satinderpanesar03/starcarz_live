@extends('admin.layouts.header')

@section('title', 'Party')
@section('content')
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <!--Extended Table starts-->
            <section id="positioning">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-7">
                                                            <h5 class="pt-2">View Party</h5>
                                                        </div>
                                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                            <a href="{{route('admin.master.party.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                                <i class="fa fa-arrow-left"></i> Back </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Party Name</th>
                                                                <td>{{$party->party_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Firm Name</th>
                                                                @foreach ($party->partyFirm as $firm)
                                                                <td>{{$firm->firm}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Whatsapp Number</th>
                                                                @foreach ($party->partyContact as $firm)
                                                                @if($firm->type == 1)
                                                                <td>{{$firm->number}}</td>
                                                                @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Contact Number</th>
                                                                @foreach ($party->partyContact as $firm)
                                                                @if($firm->type == 2)
                                                                <td>{{$firm->number}}</td>
                                                                @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>{{$party->email}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Office Address</th>
                                                                <td>{{$party->office_address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Office City</th>
                                                                @foreach ($party->partyCity as $city)
                                                                <td>{{$city->city}}</td>
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Residence Address</th>
                                                                <td>{{$party->residence_address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Residence City</th>
                                                                <td>{{$party->residence_city}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Pan Number</th>
                                                                <td>{{$party->pan_number}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Designation</th>
                                                                <td>{{$party->designation}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
@endsection