    <!-- header start -->
    <header id="header" class="main-header">
        <!-- header-top start -->
        <div class="header-top-area fixed-top">
            <!-- header-top-first start -->
            <div class="header-top-first ptb-15 extra-bg">
                <div class="container-fluid">
                    <div class="row ad-flex align-items-center justify-content-between position-relative header-area">
                        <!-- header-logo start -->
                        <div
                            class="col-12 col-xl-3 header-element header-logo d-flex align-items-center justify-content-between">
                            <!-- Spacer (Sebagai penyeimbang visual kanan) -->

                            <!-- Menu Icon (Kiri) -->
                            <div class="header-icon-wrapper">
                                <a href="javascript:void(0)" class="d-block header-icon-toggler toggler-btn logo-raised"
                                    aria-label="Menu toggler button">
                                    <span class="d-block header-block-icon dominant-link font-25">
                                        <i class="ri-menu-line d-block lh-1" style="color: var(--dominant-font-color);"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="header-theme-logo mx-auto text-center">
                                <a href="/home" class="d-inline-block theme-logo">
                                    <img src="assetsz/image/index/logo.png" class="img-fluid logo-raised" alt="logo"
                                        style="width: 200px;">
                                </a>
                            </div>

                            <!-- Menu Icon (Kiri) -->
                            <div class="header-icon-wrapper">
                                <a href="/profile" class="d-block  logo-raised"
                                    aria-label="Menu toggler button">
                                    <span class="d-block header-block-icon dominant-link font-25">
                                        <i class="ri-user-line fs-5" style="color: var(--dominant-font-color);"></i>
                                    </span>
                                </a>
                            </div>

                        </div>
                        <!-- header-logo end -->
                        <!-- header-search-contact start -->
                        <div class="col-xl-9 d-none d-xl-block">
                            <div class="ul-mt30 flex-nowrap justify-content-end">
                                <!-- main-menu start -->
                                <ul class="menu-ul d-flex flex-wrap">
                                    <li class="menu-li">
                                        <a href="/home" class="menu-link d-flex align-items-center ptb-15 plr-15">
                                            <i class="ri-home-5-line me-2"></i>
                                            <span class="menu-title text-uppercase heading-weight">Home</span>
                                        </a>
                                    </li>
                                    <li class="menu-li">
                                        <a href="/history" class="menu-link d-flex align-items-center ptb-15 plr-15">
                                            <i class="ri-file-list-3-line me-2"></i>
                                            <span class="menu-title text-uppercase heading-weight">Histori</span>
                                        </a>
                                    </li>
                                    <li class="menu-li">
                                        <a href="/jadwal" class="menu-link d-flex align-items-center ptb-15 plr-15">
                                            <i class="ri-calendar-line me-2"></i>
                                            <span class="menu-title text-uppercase heading-weight">Jadwal</span>
                                        </a>
                                    </li>
                                    <li class="menu-li">
                                        <!-- Profile menu dropdown start -->
                                        <a href="javascript:void(0)"
                                            class="menu-link d-flex align-items-center ptb-15 plr-15"
                                            data-bs-toggle="collapse" data-bs-target="#dropdownProfile">
                                            <span class="menu-title text-uppercase heading-weight">Profile</span>
                                        </a>
                                        <div id="dropdownProfile"
                                            class="menu-dropdown menu-sub collapse position-absolute top-100 extra-bg z-2 DropDownSlide box-shadow">
                                            <ul class="menudrop-ul ptb-25">
                                                <!-- Lihat Profile -->
                                                <li class="menudrop-li">
                                                    <button type="button" onclick="window.location.href='/profile'"
                                                        class="w-100 btn-sm btn-style quaternary-btn d-flex align-items-center py-1 px-3">
                                                        <span class="icon me-2"><i class="ri-user-3-line"></i></span>
                                                        <span>Profile</span>
                                                    </button>
                                                </li>

                                                <!-- Edit Profile -->
                                                <li class="menudrop-li">
                                                    <button type="button"
                                                        onclick="window.location.href='/edit-profile'"
                                                        class="w-100 btn-sm btn-style quaternary-btn d-flex align-items-center py-1 px-3">
                                                        <span class="icon me-2"><i class="ri-pencil-line"></i></span>
                                                        <span>Setting</span>
                                                    </button>
                                                </li>

                                                <!-- Logout -->
                                                <li class="menudrop-li">
                                                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                                        @csrf
                                                        <button type="button" onclick="window.location.href='/logout'"
                                                            class="w-100 btn-sm btn-style quaternary-btn d-flex align-items-center py-1 px-3">
                                                            <span class="icon me-2"><i
                                                                    class="ri-logout-box-line"></i></span>
                                                            <span>Logout</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                    </li>
                                </ul>

                                <!-- main-menu end -->
                            </div>
                        </div>
                        <!-- header-search-contact end -->

                    </div>
                </div>
            </div>
            <!-- header-top-first end -->
        </div>
        <!-- header-top end -->
    </header>
    <!-- header end -->
