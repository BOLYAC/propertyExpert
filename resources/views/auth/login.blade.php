<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
    <title>Hashim Group CRM | Login</title>
    <!-- Google font-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/iofrm-theme19.css') }}">
</head>
<body>
<div class="form-body without-side">
    <div class="website-logo">
        <a href="{{ route('home') }}">
            <div class="logo">
                <img class="logo-size" src="{{ asset('assets/login/images/logo-light.svg') }}" alt="">
            </div>
        </a>
    </div>
    <div class="row">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="{{ asset('assets/login/images/graphic3.svg') }}" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3 style="text-align:center;">{{ __('Welcome!') }}</h3>
                    <p style="text-align:center;">{{ __('Please fill the fields below to access the CRM.') }}</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="text" name="email"
                                   placeholder="{{ __('E-mail Address') }}" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                   name="password" placeholder="{{ __('Password') }}" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                            @enderror
                        </div>
                        <div>
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}><label
                                for="remember">{{ __('Remember Me!') }}</label>
                        </div>
                        <div class="form-button">
                            <button id="submit" type="submit" class="ibtn">{{ __('Login') }}</button>
                        </div>
                    </form>
                    <h6 style="text-align:center;"><br/>{{ __('If you are facing any difficulty please contact your') }}
                        <a
                            href="https://wa.me/+905522926875">{{ __('system provider.') }}</a></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/login/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/login/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/login/js/main.js') }}"></script>
</body>
</html>
