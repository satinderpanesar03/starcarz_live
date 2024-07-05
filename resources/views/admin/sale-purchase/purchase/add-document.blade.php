@extends('admin.layouts.header')
@section('title','Documents')
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
                                            <h5 class="pt-2 pb-2 font-weight-bold">Documents</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.purchase.purchase.orders')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.purchase.purchase.storeDocument')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $purchase->id ?? null }}">
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">RC:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="rc_pending" name="rc" value="Pending" {{ isset($pendingDocument) && $pendingDocument->rc == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="rc_pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="rc_received" name="rc" value="Received" {{ isset($pendingDocument) && $pendingDocument->rc == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="rc_received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="rc_na" name="rc" value="NA" {{ isset($pendingDocument) && $pendingDocument->rc == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="rc_na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Insurance:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="insurance" value="Pending" {{ isset($pendingDocument) && $pendingDocument->insurance == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="insurance" value="Received" {{ isset($pendingDocument) && $pendingDocument->insurance == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="insurance" value="NA" {{ isset($pendingDocument) && $pendingDocument->insurance == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Delivery Documents:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="delivery_document" value="Pending" {{ isset($pendingDocument) && $pendingDocument->delivery_document == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="delivery_document" value="Received" {{ isset($pendingDocument) && $pendingDocument->delivery_document == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="delivery_document" value="NA" {{ isset($pendingDocument) && $pendingDocument->delivery_document == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">2nd Key:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="key" value="Pending" {{ isset($pendingDocument) && $pendingDocument->key == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="key" value="Received" {{ isset($pendingDocument) && $pendingDocument->key == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="key" value="NA" {{ isset($pendingDocument) && $pendingDocument->key == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Pan Card:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="pancard" value="Pending" {{ isset($pendingDocument) && $pendingDocument->pancard == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="pancard" value="Received" {{ isset($pendingDocument) && $pendingDocument->pancard == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="pancard" value="NA" {{ isset($pendingDocument) && $pendingDocument->pancard == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Aadhar Card:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="aadharcard" value="Pending" {{ isset($pendingDocument) && $pendingDocument->aadharcard == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="aadharcard" value="Received" {{ isset($pendingDocument) && $pendingDocument->aadharcard == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="aadharcard" value="NA" {{ isset($pendingDocument) && $pendingDocument->aadharcard == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Photographs:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="photograph" value="Pending" {{ isset($pendingDocument) && $pendingDocument->photograph == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="photograph" value="Received" {{ isset($pendingDocument) && $pendingDocument->photograph == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="photograph" value="NA" {{ isset($pendingDocument) && $pendingDocument->photograph == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Transfer Set:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="pending" name="transfer_set" value="Pending" {{ isset($pendingDocument) && $pendingDocument->transfer_set == 'Pending' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="pending">Pending</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="received" name="transfer_set" value="Received" {{ isset($pendingDocument) && $pendingDocument->transfer_set == 'Received' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="received">Received</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="na" name="transfer_set" value="NA" {{ isset($pendingDocument) && $pendingDocument->transfer_set == 'NA' ? 'checked' : '' }}>
                                                            <label class="form-check-label font-weight-bold" for="na">NA</label>
                                                        </div>
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