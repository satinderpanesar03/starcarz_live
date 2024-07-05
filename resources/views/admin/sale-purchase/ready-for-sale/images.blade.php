@extends('admin.layouts.header')
@section('title','Add Images')
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
                                            <h5 class="pt-2 pb-2 font-weight-bold">Add Images</h5>
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
                                            <form method="post" action="{{route('admin.purchase.purchase.ready-sale-add-image-store')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="purchase_id" value="{{ $id }}">
                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Front Image:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="file" id="front" name="front">
                                                        </div>
                                                    </div>
                                                    @if(isset($image->front))
                                                    <div class="col-sm-2 ml-5">
                                                       <img width="50%" src="{{}}" alt="">
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Side Image:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="file" id="side" name="side">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-sm-2 ml-5">
                                                       <img width="50%" src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg" alt="">
                                                    </div> -->
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Back Image:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="file" id="back" name="back">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-sm-2 ml-5">
                                                       <img width="50%" src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg" alt="">
                                                    </div> -->
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Interior Image:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="file" id="interior" name="interior">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-sm-2 ml-5">
                                                       <img width="50%" src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg" alt="">
                                                    </div> -->
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                        <label for="rc" class="col-sm-5 col-form-label font-weight-bold">Tyre Image:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="file" id="tyre" name="tyre">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-sm-2 ml-5">
                                                       <img width="50%" src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg" alt="">
                                                    </div> -->
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