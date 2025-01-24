<!doctype html>
<html lang="en">

<head>
  @include('admin.auth.head')
</head>

<body class="body_color">
<!--================Login Form Area =================-->
<!-- Begin page -->

    <section class="ic_main_form_area">
        <div class="container">
            @include('flash::message')
            <div class="row align-items-center">
                <div class="col-lg-7 d-none d-lg-block">
                    
                </div>
                <div class="col-lg-5 col-md-7 m-auto ml-lg-auto">
                    <div class="ic_main_form_inner">
                        <div class="form_box">
                            <div class="col-lg-12">
                                @if(config('site_logo'))
                                <img class="ic-login-img img-fluid" src="{{ config('site_logo') }}" alt="logo">
                                @else
                                <img class="img-fluid ic-login-img" src="{{ config('site_logo') ?? static_asset('admin/images/logo.png') }}" alt="imgs">
                                @endif

                                <h2>{{__('custom.login')}}</h2>
                                <p>{{ config('login_message_system') ?? __('custom.login_message') }}</p>
                            </div>

                            @if(session()->has('loginFail'))
                            <p class="alert alert-danger text-center">
                                {{ session()->get('loginFail') }}
                            </p>
                            @endif


                            <form class="row login_form justify-content-center" action="{{ url('/admin/login') }}" method="post" id="loginForm" novalidate="novalidate">

                                @csrf

                                <div class="form-group col-lg-12">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="anish@example.com">
                                    <i class="fa fa-user"></i>
                                </div>
                                @if ($errors->has('email'))
                                <p class="ic-error-massage">{{ $errors->first('email') }}</p>
                                @endif
                                <div class="form-group col-lg-12">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>

                                </div>
                                @if ($errors->has('password'))
                                <p class="ic-error-massage">{{ $errors->first('password') }}</p>
                                @endif
                                <div class="form-group col-lg-12">
                                    <button type="submit" value="submit" class="btn submit_btn form-control">{{
                                        __('custom.login') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="text-center login-form-footer">© {{ date('Y') }} {{
                            __('custom.all_right_reserved') }} | {{ __('custom.copper_crumb') }} </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--================End Login Form Area =================-->

@include('admin.auth.script')

</body>

</html>
