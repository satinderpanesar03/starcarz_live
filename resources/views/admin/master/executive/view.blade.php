@extends('admin.layouts.header')

@section('title', 'View Executive')
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
                                            <h5 class="pt-2 pb-2">View Executive</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.executive.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center"> <!-- Center the row -->
                                            <div class="col-sm-6">
                                                <form
                                                    method="post"
                                                    action="{{route('admin.master.executive.store')}}"
                                                >
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$executive->id ?? null}}">
                                                    <div class="form-group">
                                                        <input type="text" name="name" class="form-control" placeholder="Source by" value="@if(isset($executive->id)){{$executive->name}}@else{{old('type')}}@endif" required data-validation-required-message="This First Name field is required" readonly>
                                                    </div>
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
