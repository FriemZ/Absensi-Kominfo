<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIV</title>

    <!-- CSS dan fonts dari folder assets -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animation/animate.min.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/weather/weather-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/weather/weather-icons-wind.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/flag-icons-master/flag-icon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/tabler-icons/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/prism/prism.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/simplebar/simplebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('assetsz/css/new_login.css') }}" />
</head>

<body>
    <div id="splash-screen">
        <img id="splash-logo" src="{{ asset('assets/images/logo/logo_awal.png') }}" alt="Logo Awal">
    </div>

    <div id="main-login" class="app-wrapper d-block">
        <main class="w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-xl-8 d-none d-lg-block p-0">
                        <div class="image-contentbox">
                            <img src="{{ asset('assets/images/login/01.png') }}" class="img-fluid" alt="Login Image" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4 p-0 bg-white">
                        <div class="form-container">
                            <form method="POST" action="{{ route('login') }}" class="app-form">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <img src="assetsz/image/index/logo.png" class="img-fluid logo-raised"
                                            alt="logo" style="width: 110px; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                                        <div class="mb-5 text-center text-lg-start">
                                            <h2 class="text-primary f-w-600">Welcome To SIV!</h2>
                                            <p>Sign in with your username or name and password</p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label for="login" class="form-label">Username or Name</label>
                                            <input type="text" name="login" id="login"
                                                value="{{ old('login') }}"
                                                class="name-input form-control @error('login') is-invalid @enderror"
                                                placeholder="Enter your username or name" required autofocus>
                                            @error('login')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-5">
                                            <label class="form-label">Password</label>
                                            <div class="d-flex gap-2 justify-content-between">

                                                @for ($i = 1; $i <= 6; $i++)
                                                    <input type="password"
                                                        class="form-control text-center otp-input @if ($i === 1) @error('password') is-invalid @enderror @endif"
                                                        maxlength="1" inputmode="text"
                                                        style="width: 48px; height: 48px; font-size: 1.5rem;"
                                                        autocomplete="off" required>
                                                @endfor
                                            </div>

                                            <!-- Hidden field untuk dikirim ke backend -->
                                            <input type="hidden" name="password" id="password" value="">

                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                        </div>
                                    </div>


                                </div>
                            </form>


                            {{-- @if ($errors->any())
                                <div class="mt-3 alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <script src="{{ asset('assetsz/js/new_login.js') }}"></script>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
