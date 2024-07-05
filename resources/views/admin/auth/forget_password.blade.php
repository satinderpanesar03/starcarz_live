@extends('admin.auth.app')

@section('title', 'Forget Password')
@section('auth')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{asset('admin_auth/images/img-01.png')}}" alt="IMG">
                </div>

                <form
                    method="post"
                    action="{{route('admin.forget.password.link')}}"
                    class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title">
						Forget Password
					</span>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                    </div>


                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Send Verification Link
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
