@extends('admin.layouts.header')
@section('title', isset($color->id) ? 'Edit Color' :  'Color')
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
                                            <h5 class="pt-2 pb-2">@if(isset($color->id)) Edit @else Add @endif Color</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.color.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center"> <!-- Center the row -->
                                        <div class="col-sm-6">
                                            <form method="post" action="{{route('admin.master.color.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$color->id ?? null}}">
                                                <div class="form-group">
                                                    <input type="text" name="color" class="form-control" placeholder="Color" value="@if(isset($color->id)){{$color->color}}@else{{old('color')}}@endif" required data-validation-required-message="This First Name field is required">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
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