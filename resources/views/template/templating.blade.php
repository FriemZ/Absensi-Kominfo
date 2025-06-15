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
    <title> AdminX - Premium Admin Template</title>
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

        @include('template.layout.footer')
    </div>

    {{-- <!--customizer-->
    <div id="customizer"></div> --}}

    @include('template.script')
</body>

</html>
