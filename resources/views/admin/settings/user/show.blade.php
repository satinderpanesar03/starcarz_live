@extends('admin.layouts.header')

@section('title', 'User')
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
                                                            <h5 class="pt-2">View User</h5>
                                                        </div>
                                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                            <a href="{{route('admin.setting.user.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                                <i class="fa fa-arrow-left"></i> Back </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Name</th>
                                                                <td>{{ ($user->name) ? $user->name : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>{{ ($user->email) ? $user->email : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Contact</th>
                                                                <td>{{ ($user->contact_number) ? $user->contact_number : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Role</th>
                                                                <td>{{ ($user->role->title) ? $user->role->title : '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Address</th>
                                                                <td>{{ ($user->address) ? $user->address : '' }}</td>
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