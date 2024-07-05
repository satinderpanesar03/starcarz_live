@extends('admin.layouts.header')

@section('title', 'Purchase')
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
                                                            <h5 class="pt-2">View Purchase</h5>
                                                        </div>
                                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                            <a href="{{route('admin.purchase.purchase.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                                <i class="fa fa-arrow-left"></i> Back </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Date</th>
                                                                <td>{{ ($purchase->evaluation_date) ? \Carbon\Carbon::parse($purchase->evaluation_date)->format('Y-m-d') : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Executive Name</th>
                                                                <td>{{ $executive->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Customer Name</th>
                                                                <td>{{ ($purchase) ? $purchase->registered_owner : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>{{ ($purchase->email) ? $purchase->email : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Car Model</th>
                                                                <td>{{ ($purchase->carModel) ? $purchase->carModel->model : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Office City</th>
                                                                <td>{{ ($purchase->getStatusName($purchase->status))}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Manufacturing Year</th>
                                                                <td>{{$purchase->manufacturing_year}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Registration Year</th>
                                                                <td>{{ $purchase->registration_year}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Kilometer</th>
                                                                <td>{{ $purchase->kilometer}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Expectation</th>
                                                                <td>{{ $purchase->expectation}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Owners</th>
                                                                <td>{{ $purchase->owners}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Fuel Type</th>
                                                                <td>@foreach($fuelType as $value => $label)
                                                                    @if($value == $purchase->fuel_type)
                                                                      {{$label}}  
                                                                    @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Shape Type</th>
                                                                <td>@foreach($shapeType as $value => $label)
                                                                    @if($value == $purchase->shape_type)
                                                                      {{$label}}  
                                                                    @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Engine Number</th>
                                                                <td>{{ $purchase->engine_number}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Chasis Number</th>
                                                                <td>{{ $purchase->chasis_number}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Service Booklet</th>
                                                                <td>@foreach($serviceBooklet as $value => $label)
                                                                    @if($value == $purchase->service_booklet)
                                                                      {{$label}}  
                                                                    @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Date of purchase</th>
                                                                <td>{{ date('d M, Y',strtotime($purchase->date_of_purchase))}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Other</th>
                                                                <td>{{ $purchase->other  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Willing Insurance</th>
                                                                <td>@foreach($willingType as $value => $label)
                                                                    @if($value == $purchase->willing_insurance)
                                                                      {{$label}}  
                                                                    @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Tyres Condition</th>
                                                                <td>{{ $purchase->tyres_condition  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Parts Changed</th>
                                                                <td>{{ $purchase->parts_changed  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Parts Repaired</th>
                                                                <td>{{ $purchase->parts_repainted  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Service and oil changed</th>
                                                                <td>{{ $purchase->service_and_oil_change  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Service and oil changed Amount</th>
                                                                <td>{{ $purchase->service_and_oil_change_amount  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Compound and dry clean</th>
                                                                <td>{{ $purchase->compound_and_dry_clean  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Compound and dry clean amount</th>
                                                                <td>{{ $purchase->compound_and_dry_clean_amount  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Paint and denting</th>
                                                                <td>{{ $purchase->paint_and_denting  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Paint and denting Amount</th>
                                                                <td>{{ $purchase->paint_and_denting_amount  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Electrical and electronics</th>
                                                                <td>{{ $purchase->electrical_and_electronics  }}</td>
                                                            </tr>   
                                                            
                                                            <tr>
                                                                <th scope="row">Electrical and electronics amount</th>
                                                                <td>{{ $purchase->electrical_and_electronics_amount  }}</td>
                                                            </tr> 
                                                            
                                                            <tr>
                                                                <th scope="row">Engine Compartment</th>
                                                                <td>{{ $purchase->engine_compartment  }}</td>
                                                            </tr> 

                                                            <tr>
                                                                <th scope="row">Engine Compartment Amount</th>
                                                                <td>{{ $purchase->engine_compartment_amount  }}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th scope="row">Accessories</th>
                                                                <td>{{ $purchase->accessories  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Accessories Amount</th>
                                                                <td>{{ $purchase->accessories_amount  }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Expected Price</th>
                                                                <td>{{ $purchase->expected_price  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Valuation</th>
                                                                <td>{{ $purchase->valuation  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Remarks</th>
                                                                <td>{{ $purchase->remarks  }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Status</th>
                                                                <td>@foreach($status as $value => $label)
                                                                    @if($value == $purchase->status )
                                                                      {{$label}}  
                                                                    @endif
                                                                    @endforeach
                                                                </td>
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