<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/logo-light-icon.png')}}">
    <title>Gaming Inventory - Inscription</title>
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
</head>
<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
             style="background:url({{asset('assets/images/big/auth-bg.jpg')}}) no-repeat center center;">
            <div class="auth-box">
                <div class="logo">
                    <span class="db">
                        <img src="{{asset('assets/images/logo-light-icon.png')}}" 
                            alt="logo" 
                            style="width: 45px; height: auto;" />
                    </span>
                    <h5 class="font-medium m-b-20">Create an Account</h5>
                </div>

                <div class="row">
                    <div class="col-12">

                        {{-- Messages d'erreur globaux --}}
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form class="form-horizontal m-t-20"
                              action="{{ route('register') }}"
                              method="POST">
                            @csrf

                            {{-- Nom --}}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ti-user"></i>
                                    </span>
                                </div>
                                <input type="text"
                                       name="name"
                                       class="form-control form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name') }}"
                                       placeholder="Full Name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ti-email"></i>
                                    </span>
                                </div>
                                <input type="email"
                                       name="email"
                                       class="form-control form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email') }}"
                                       placeholder="Email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mot de passe --}}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ti-pencil"></i>
                                    </span>
                                </div>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="Password (min 8 chars)"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirmation mot de passe --}}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ti-pencil"></i>
                                    </span>
                                </div>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control form-control-lg"
                                       placeholder="Confirm Password"
                                       required>
                            </div>

                            {{-- Bouton --}}
                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-info" type="submit">
                                        Register
                                    </button>
                                </div>
                            </div>

                            {{-- Lien vers login --}}
                            <div class="text-center">
                                <p class="text-muted">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-info">Sign In</a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script>
        $(".preloader").fadeOut();
    </script>
</body>
</html>