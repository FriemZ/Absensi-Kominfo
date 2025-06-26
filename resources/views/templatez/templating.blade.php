<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from spacingtech.com/html/malin/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 26 Apr 2025 11:59:15 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIV | {{ $headerText }}</title>
    <meta name="description"
        content="Malin is a modern, responsive bootstrap eCommerce html template for kitchen appliances and furniture stores. Perfect for home decor, interior, and online shopping.">
    <meta name="keywords"
        content="kitchen, furniture, home decor, appliance, bootstrap, eCommerce, HTML template, interior, store, responsive, modern, minimalist, shop, design, UI">
    <meta name="author" content="spacingtech_webify">
    @include('templatez.style')
    <style>
        .square-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url('assetsz/image/bg.jpg');
            background-size: 100% 100%;
            /* ini maksudmu: dimampetkan */
            background-repeat: no-repeat;
            background-position: center;
            z-index: -3;
        }

        /* Efek 3D dan modern */
        .extra-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f3f3f3 100%);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
        }

        .about-counter-content {
            background: #fff;
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .about-counter-content:hover {
            transform: scale(1.01);
            box-shadow: 0 16px 25px rgba(0, 0, 0, 0.18);
        }

        .about-counter-icon {
            background: linear-gradient(135deg, var(--dominant-font-color), var(--secondary-color));
            color: var(--dominant-font-color);
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }

        .about-counter-icon:hover {
            transform: scale(1.1);
        }

        h2.dominant-color {
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.15);
            font-weight: 600;
        }

        h6.dominant-color {
            margin-top: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .extra-bg {
            background: linear-gradient(135deg, #ffffff, #f9f9f9);
            border: 1px solid #e0e0e0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .form-label {
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .form-control,
        .form-select {
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--dominant-font-color);
            box-shadow: 0 0 0 0.2rem rgba(77, 141, 255, 0.25);
        }

        .status-radio-group-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            /* atau space-between, bisa disesuaikan */
            flex-wrap: wrap;
            /* biar tetap responsif di HP */
        }

        .status-option {
            /* biar dua tombol bisa bagi dua space */
            display: block;
        }

        .status-option input[type="radio"] {
            display: none;
        }

        .status-option .option-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 20px;
            border-radius: 12px;
            border: 2px solid var(--dominant-font-color);
            background-color: #fff;
            color: var(--dominant-font-color);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            text-align: center;
        }

        .status-option:hover .option-box {
            background-color: var(--dominant-bg);
            color: white;
        }

        .status-option input[type="radio"]:checked+.option-box {
            background-color: var(--dominant-font-color);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .full-center-wrapper {
            min-height: 100vh;
            /* penuh layar */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-row {
            background: rgba(255, 255, 255, 0.03);
            /* Lebih transparan */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            margin: 4px 8px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .glass-row:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: scale(1.01);
        }

        /* Tambahan agar cell tidak terlalu padat */
        table.table td,
        table.table th {
            padding: 0.75rem 1rem;
        }


        .logo-inset {
            border-radius: 14px;
            padding: 2px 10px;
            /* padding atas-bawah 8px, kiri-kanan 10px */
            background: #f0f0f3;
            box-shadow:
                inset 4px 4px 8px rgba(0, 0, 0, 0.1),
                inset -4px -4px 8px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease-in-out;
        }

        .logo-raised {
            padding: 2px 10px;
            border-radius: 14px;
            background: #f0f0f3;
            color: var(--dominant-font-color);
            box-shadow:
                4px 4px 10px rgba(0, 0, 0, 0.1),
                -4px -4px 10px rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>


<body>

    <!-- Preloader Start -->
    <div class="preloader position-fixed top-0 start-0 w-100 h-100 body-bg z-index-9999">
        <div
            class="loader-img position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
            <img src="assetsz/image/index/logo.png" class="width-96 width-xl-120 img-fluid" alt="logo"
                style="width: 150px;">
        </div>
    </div>
    <!-- Preloader End -->

    <div class="square-bg"></div>

    {{-- <!-- newsletter-modal start -->
    <div class="newsletter-modal modal fade" id="newslettermodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content body-bg border-0 br-hidden">
                <div class="modal-body p-0">
                    <button type="button"
                        class="d-block secondary-btn icon-16 width-32 height-32 position-absolute top-0 end-0"
                        data-bs-dismiss="modal" aria-label="Close"><i
                            class="ri-close-large-line d-block lh-1"></i></button>
                    <div class="newsletter-info">
                        <div class="newsletter-content ptb-30 plr-15 plr-sm-30 text-center">
                            <h2 class="section-heading">Newsletter</h2>
                            <p class="d-inline-block font-18 mst-10 mst-xl-17">Subscribe with us to get special offers
                                and other discount information</p>
                            <div class="newsletter-form mst-26">
                                <form method="post" class="news-form">
                                    <div class="news-wrap">
                                        <input type="email" id="popup-email" name="popup-email"
                                            class="w-100 text-center" placeholder="Enter your email">
                                        <button type="submit"
                                            class="w-100 btn-style secondary-btn mst-15">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- newsletter-modal end -->
    @include('templatez.layout.header')
    <!-- main start -->
    <main id="main">
        @yield('content')

    </main>
    <!-- main end -->

    @include('templatez.layout.footer')
    @include('templatez.layout.mobilemenu')
    @include('templatez.layout.bottom')

    <!-- bg-screen start -->
    <div class="bg-screen">
        <div class="bg-back position-fixed top-0 end-0 bottom-0 start-0 bg-black z-index-4 opacity-0 invisible"></div>
        <div class="bg-shop position-fixed top-0 end-0 bottom-0 start-0 bg-black z-index-4 opacity-0 invisible"></div>
    </div>
    <!-- bg-screen end -->

    <!-- back-to-top start -->
    <style>
        .fab-container {
            position: fixed;
            bottom: 40px;
            right: 20px;
            display: flex;
            flex-direction: column-reverse;
            align-items: center;
            gap: 14px;
            z-index: 3;
        }

        .fixed-circle-btn {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background: linear-gradient(145deg, var(--dominant-font-color), #2c2c2c);
            box-shadow:
                4px 4px 12px rgba(0, 0, 0, 0.3),
                -4px -4px 8px rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            pointer-events: auto;
            backdrop-filter: blur(2px);
        }

        .fixed-circle-btn:hover {
            transform: scale(1.05);
            box-shadow:
                6px 6px 16px rgba(0, 0, 0, 0.4),
                -4px -4px 12px rgba(255, 255, 255, 0.06);
            filter: brightness(1.05);
        }


        /* FAB anak disembunyikan default */
        .fab-child {
            opacity: 0;
            transform: translateY(20px) scale(0.7);
            pointer-events: none;
            transition: all 0.3s ease;
        }

        /* Saat container terbuka */
        .fab-container.open .fab-child {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        /* Ikon di dalam tombol */
        .fixed-circle-btn i {
            font-size: 22px;
            color: white;
        }
    </style>


    @if (!Request::is('scan'))
        <!-- Container tombol fixed -->
        <div class="fab-container">
            <!-- Tombol utama -->
            <button id="fab-main" class="dominant-bg fixed-circle-btn" aria-label="Menu">
                <i class="ri-add-fill"></i>
            </button>

            <a href="/izins" class="dominant-bg fixed-circle-btn fab-child" id="fab-izin" aria-label="Izin">
                <i class="ri-file-text-line"></i>
            </a>

            <a href="/scan" class="dominant-bg fixed-circle-btn fab-child" id="fab-scan" aria-label="Scan">
                <i class="ri-camera-line"></i>
            </a>
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.fab-container');
            const mainBtn = document.getElementById('fab-main');

            // Toggle FAB saat tombol utama diklik
            mainBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // agar klik tidak bubble ke document
                container.classList.toggle('open');
            });

            // Cegah klik di dalam tombol anak menutup FAB
            document.querySelectorAll('.fab-child').forEach(child => {
                child.addEventListener('click', e => e.stopPropagation());
            });

            // Jika klik di luar fab-container, tutup FAB
            document.addEventListener('click', (e) => {
                if (container.classList.contains('open')) {
                    container.classList.remove('open');
                }
            });
        });
    </script>



    <!-- back-to-top end -->
    @include('templatez.script')
</body>

</html>
