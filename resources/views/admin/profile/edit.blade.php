@extends('admin.layouts.header')

@section('title', 'Edit Profile')
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
                            <div class="card-header">
                            <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">Edit Profile</h5>
                                        </div>
                                        <!-- <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.sale.sale.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div> -->
                                    </div>
                                </div>
                                <h4 class="card-title"><b></b></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <form method="post" action="{{route('admin.profile.store')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$article->id ?? null}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="email">Email:</label>
                                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="profile_image">Profile Image</label>
                                                    <input type="file" id="profile_image" name="profile_image" class="form-control">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password" name="password" class="form-control">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                </div>

                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">Update</button>
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