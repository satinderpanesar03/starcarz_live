@extends('admin.auth.app')

@section('title', 'Change Password')
@section('auth')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{asset('admin_auth/images/img-01.png')}}" alt="IMG">
                </div>

                <form
                    method="post"
                    action="{{route('admin.reset.password.submit')}}"
                    class="login100-form validate-form">
                    @csrf
                    <input type="hidden" name="link" value="{{$link}}">
                    <span class="login100-form-title">
						Change Password
					</span>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-key" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="password" name="confirm_password" placeholder="Confirm Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-key" aria-hidden="true"></i>
						</span>
                    </div>


                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Confirm Password
                        </button>
                    </div>

                    <div class="text-center p-t-12">
						<span class="txt1">
							Click here to
						</span>
                        <a class="txt2" href="{{route('admin.login')}}">
                            login
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
