<!-- mobile-menu start -->
<div class="mobile-menu d-xl-none position-fixed top-0 bottom-0 extra-bg z-index-5 invisible box-shadow " id="mobile-menu">
    <div class="mobile-contents d-flex flex-column">
        <div class="menu-close ptb-10 plr-15 beb">
            <button type="button" class="menu-close-btn d-block body-secondary-color icon-16 ms-auto"
                aria-label="Menu close"><i class="ri-close-large-line d-block lh-1"></i></button>
        </div>
        <div class="mobilemenu-content beb">
            <div class="main-wrap">
                @php
                    $user = Auth::user();
                    $nama = $user->name; // atau $user->mahasiswa->name jika relasi
                @endphp

                <!-- Profile section -->
                <div class="ti-profile text-center py-4 border-bottom">
                    <div class="d-inline-block position-relative">
                        <img src="assetsz/image/account/female.jpg" class="rounded-circle border shadow-lg"
                            style="width: 96px; height: 96px; object-fit: cover; transform: translateY(-8px); border-color: var(--tertiary-font-color);">
                    </div>
                    <div class="mt-3 fw-semibold" style="color: var(--dominant-font-color); font-size: 1.3rem;">
                        {{ $nama }}
                    </div>
                </div>



                <!-- Menu items -->
                <ul class="menu-ul px-3 pt-3">
                    <li class="menu-li mb-3">
                        <button onclick="window.location.href='/home'" type="button"
                            class="btn btn-light w-100 text-start d-flex align-items-center gap-3 shadow-sm"
                            style="color: var(--dominant-font-color);">
                            <i class="ri-home-line fs-5" style="color: var(--dominant-font-color);"></i>
                            <span class="fw-semibold">Home</span>
                        </button>
                    </li>
                    <li class="menu-li mb-3">
                        <button onclick="window.location.href='/profile'" type="button"
                            class="btn btn-light w-100 text-start d-flex align-items-center gap-3 shadow-sm"
                            style="color: var(--dominant-font-color);">
                            <i class="ri-user-line fs-5" style="color: var(--dominant-font-color);"></i>
                            <span class="fw-semibold">Profil</span>
                        </button>
                    </li>
                    <li class="menu-li mb-3">
                        <button onclick="window.location.href='/history'" type="button"
                            class="btn btn-light w-100 text-start d-flex align-items-center gap-3 shadow-sm"
                            style="color: var(--dominant-font-color);">
                            <i class="ri-history-line fs-5" style="color: var(--dominant-font-color);"></i>
                            <span class="fw-semibold">Rekapitulasi</span>
                        </button>
                    </li>
                    <li class="menu-li mb-3">
                        <button onclick="window.location.href='/jadwal'" type="button"
                            class="btn btn-light w-100 text-start d-flex align-items-center gap-3 shadow-sm"
                            style="color: var(--dominant-font-color);">
                            <i class="ri-calendar-line fs-5" style="color: var(--dominant-font-color);"></i>
                            <span class="fw-semibold">Jam Kerja</span>
                        </button>
                    </li>
                    <li class="menu-li">
                        <form action="{{ route('logout') }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit"
                                class="btn dominant-btn w-100 text-start d-flex align-items-center gap-3">
                                <i class="ri-logout-box-line fs-5"></i>
                                <span class="fw-semibold">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
<!-- mobile-menu end -->
