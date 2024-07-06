@extends('admin.layouts.header')

@section('title', 'Add New Role')
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
                                            <h5 class="pt-2 pb-2">@if(isset($insurance->id)) Edit @else Add @endif New Role</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.setting.role.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <form method="post" action="{{route('admin.setting.role.new.store')}}">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{$role->id ?? null}}">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <input type="text" name="title" class="form-control" placeholder="Enter Role Name" value="@if(isset($role->id)){{$role->title}}@else{{old('title')}}@endif" required data-validation-required-message="This First Name field is required">
                                                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>

                                        </form>
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
