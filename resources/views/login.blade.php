<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - AdminX</title>

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
</head>

<body>
    <style>
        body {
            overflow: hidden;
        }

        #splash-screen {
            position: fixed;
            inset: 0;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: background-color 1s ease-in-out, opacity 1s ease-in-out;
        }

        #splash-logo {
            width: 160px;
            opacity: 0;
            transform: scale(1);
            animation: fadeInZoom 1s forwards ease-in-out;
            transition: all 1s ease-in-out;
            position: absolute;

            /* Bikin jadi lingkaran */
            border-radius: 50%;
            background-color: #fff;

            /* Tambahan padding jika logomu kecil di dalam */
            padding: 3px;
            object-fit: contain;

            /* Efek timbul */
            box-shadow:
                0 8px 15px rgba(0, 0, 0, 0.3),
                0 -4px 6px rgba(255, 255, 255, 0.5);
            filter: brightness(1.05) contrast(1.05);
        }

        @keyframes fadeInZoom {
            to {
                opacity: 1;
                transform: scale(1.1);
            }
        }

        /* Saat pindah ke pojok */
        .move-logo {
            transform: scale(0.4) translate(600px, -300px);
        }

        /* Setelah splash berakhir, login form muncul */
        #main-login {
            height: 100vh;
            /* isi seluruh tinggi viewport */
            overflow: hidden;
            /* tidak izinkan scroll dalam elemen */
            display: flex;
            /* opsional: untuk tata letak fleksibel */
            align-items: center;
            /* tengah vertikal */
            justify-content: center;
            /* tengah horizontal */
        }

        #main-login.show {
            opacity: 1;
            transform: translateY(0);
        }

        .otp-input {
            border: none;
            border-radius: 12px;

            background: #f0f0f3;
            /* abu terang */
            color: #212529;

            /* Efek cekung (inset) */
            box-shadow:
                inset 3px 3px 6px rgba(0, 0, 0, 0.1),
                inset -3px -3px 6px rgba(255, 255, 255, 0.7);

            transition: 0.3s ease;
        }
        .name-input {
            border: none;
            border-radius: 8px;

            background: #f0f0f3;
            /* abu terang */
            color: #212529;

            /* Efek cekung (inset) */
            box-shadow:
                inset 3px 3px 6px rgba(0, 0, 0, 0.1),
                inset -3px -3px 6px rgba(255, 255, 255, 0.7);

            transition: 0.3s ease;
        }
        

        .otp-input:focus {
            outline: none;
            background: #fefefe;
            box-shadow:
                inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                inset -2px -2px 5px rgba(255, 255, 255, 0.6);
        }
    </style>




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
                                        <div class="mb-5 text-center text-lg-start">
                                            <h2 class="text-primary f-w-600">Welcome To AdminX!</h2>
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


    <script>
        window.addEventListener('load', () => {
            const splash = document.getElementById('splash-screen');
            const logo = document.getElementById('splash-logo');
            const main = document.getElementById('main-login');

            // Jalankan animasi perpindahan logo
            setTimeout(() => {
                logo.classList.add('move-logo');
            }, 1200);

            // Sembunyikan splash screen dan munculkan login
            setTimeout(() => {
                splash.style.opacity = '0';
                splash.style.pointerEvents = 'none';
                main.classList.add('show');
                document.body.style.overflow = 'auto';
            }, 2200);
        });

        document.addEventListener("DOMContentLoaded", () => {
            const inputs = document.querySelectorAll('.otp-input');
            const hiddenPassword = document.getElementById('password');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    // Hanya angka, pindah otomatis
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updatePassword();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && input.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            function updatePassword() {
                const password = Array.from(inputs).map(i => i.value).join('');
                hiddenPassword.value = password;
            }
        });
    </script>



    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
