<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template">
    <meta name="keywords"
        content="admin template, ra-admin admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="la-themes">
    <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">
    <title> PEMDA SUMENEP - SIV</title>
    @include('template.style')
</head>

<body>

    <div class="app-wrapper">
        <div class="loader-wrapper">
            <div class="app-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        @include('template.layout.navbar')

        <div class="app-content">
            @include('template.layout.header')

            <main>
                <div class="container-fluid">
                    @yield('content')
                </div>


            </main>

        </div>

        <div class="go-top">
            <span class="progress-value">
                <i class="ti ti-arrow-up"></i>
            </span>
        </div>
        <!-- Modal Ubah Password -->
        <div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('ubah-password') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" name="old_password" id="old_password" class="form-control"
                                        required>
                                    <div class="input-group-text">
                                        <input type="checkbox" class="form-check-input mt-0"
                                            onclick="old_password.type = this.checked ? 'text' : 'password'">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        required minlength="6">
                                    <div class="input-group-text">
                                        <input type="checkbox" class="form-check-input mt-0"
                                            onclick="new_password.type = this.checked ? 'text' : 'password'">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password
                                    Baru</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation" class="form-control" required>
                                    <div class="input-group-text">
                                        <input type="checkbox" class="form-check-input mt-0"
                                            onclick="new_password_confirmation.type = this.checked ? 'text' : 'password'">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary">
                                <i class="ti ti-refresh"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">
                                <i class="ti ti-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('template.layout.footer')
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}"
                });
            </script>
        @endif
        @if (session('alert_message'))
            <script>
                Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
            </script>
        @endif
    </div>

    {{-- <!--customizer-->
    <div id="customizer"></div> --}}

    @include('template.script')
</body>

</html>
