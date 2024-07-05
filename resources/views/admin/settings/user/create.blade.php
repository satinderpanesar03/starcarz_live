@extends('admin.layouts.header')

@section('title', 'Add User')
@section('content')
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="simple-validation">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">@if(isset($user->id)) Edit @else Add @endif User</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.setting.user.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card-header">
                                    <h4 class="card-title"><b><a href="{{route('admin.setting.user.index')}}">All Users</a></b> / @if(isset($color->id)) Edit @else Add @endif User</h4>
                                </div> -->
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <form method="{{ (isset($user->id)) ?'GET':'POST' }}" action="{{route('admin.setting.user.store')}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$user->id ?? null}}">
                                            <input type="hidden" name="passwd" value="{{$user->password ?? null}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="role_id" class="form-label">Role</label>
                                                    <!-- <select name="role_id" id="role_id" class="form-control">
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $id =>$role)
                                                        <option value="{{ $id }}" {{ isset($user->role_id) && $user->role_id == $id ? 'selected' : '' }}>{{ $role }}</option>
                                                        @endforeach
                                                    </select> -->
                                                    <select name="role_id[]" class="form-control mb-1" multiple required>

                                                        @if(isset($roles))
                                                        @foreach($roles as $id => $role)
                                                        <option value="{{ $id }}" {{ isset($user->roles) && in_array($id, explode(',', $user->roles)) ? 'selected' : '' }}>{{ $role }}</option>
                                                        @endforeach

                                                        @else
                                                        <option selected value="">Choose...</option>
                                                        @foreach($roles as $id => $role)
                                                        <option value="{{ $id }}">{{ $role }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="name">Name:</label>
                                                    <input type="text" id="name" name="name" class="form-control" value="@if(isset($user->id)){{$user->name}}@else{{old('name')}}@endif">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="email" value="{{ $user->email ?? old('email') }}" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="gender">Gender:</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="" disabled selected>Select Gender</option>
                                                        @foreach($genderOption as $value => $label)
                                                        <option value="{{ $value }}" {{ isset($user->gender) && $value == $user->gender? 'selected' : '' }}>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="password">Password:</label>
                                                    <input type="password" id="password" name="password" class="form-control">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="contact_number">Contact Number:</label>
                                                    <input type="text" id="contact_number" name="contact_number" class="form-control" value="@if(isset($user->id)){{$user->contact_number}}@else{{old('contact_number')}}@endif">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="password_confirmation">Confirm Password:</label>
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="address">Address:</label>
                                                    <textarea id="address" name="address" class="form-control" rows="2">@if(isset($user->id)) {{ $user->address }}@else{{ old('address') }}@endif</textarea>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">@if(isset($user->id)) Update @else Save @endif</button>
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
        $('select').selectize({
            plugins: ["remove_button"],
        });
    });
</script>
@endpush