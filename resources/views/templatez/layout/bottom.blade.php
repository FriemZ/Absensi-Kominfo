{{-- <!-- bottom-menu start -->
<div class="bottom-menu d-block d-lg-none position-fixed bottom-0 w-100 extra-bg z-3 box-shadow">
    <div class="bottom-menu-element d-flex flex-wrap align-items-center">

        <div class="col">
            <a href="/home"
                class="d-flex flex-column align-items-center ptb-10 text-center rounded-3 {{ request()->is('/') ? 'fw-bold' : '' }}"
                style="color: {{ request()->is('/') ? 'var(--dominant-font-color)' : '#000' }};">
                <span class="bottom-menu-icon heading-color icon-16">
                    <i class="ri-home-5-line d-block lh-1"
                        style="color: {{ request()->is('/') ? 'var(--dominant-font-color)' : '#000' }};"></i>
                </span>
                <span class="bottom-menu-title font-10 mst-4 text-uppercase lh-1">Home</span>
            </a>
        </div>

        <div class="col">
            <a href="/history"
                class="d-flex flex-column align-items-center ptb-10 text-center rounded-3 {{ request()->is('history') ? 'fw-bold' : '' }}"
                style="color: {{ request()->is('history') ? 'var(--dominant-font-color)' : '#000' }};">
                <span class="bottom-menu-icon heading-color icon-16">
                    <i class="ri-file-list-3-line d-block lh-1"
                        style="color: {{ request()->is('history') ? 'var(--dominant-font-color)' : '#000' }};"></i>
                </span>
                <span class="bottom-menu-title font-10 mst-4 text-uppercase lh-1">Histori</span>
            </a>
        </div>

        <div class="col">
            <a href="/scan"
                class="d-flex flex-column align-items-center justify-content-center text-center position-relative {{ request()->is('scan') ? 'fw-bold' : '' }}"
                style="margin-top: -20px; color: {{ request()->is('scan') ? 'var(--extra-font-color)' : 'var(--extra-font-color)' }};">
                <div class="dominant-bg extra-color rounded-4 d-flex flex-column align-items-center justify-content-center"
                    style="width: 60px; height: 60px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                    <i class="ri-camera-fill icon-24 mb-1" style="color: var(--extra-font-color);"></i>


                    <span class="font-10 text-uppercase">Scan</span>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="/jadwal"
                class="d-flex flex-column align-items-center ptb-10 text-center rounded-3 {{ request()->is('jadwal') ? 'fw-bold' : '' }}"
                style="color: {{ request()->is('jadwal') ? 'var(--dominant-font-color)' : '#000' }};">
                <span class="bottom-menu-icon heading-color icon-16">
                    <i class="ri-calendar-line d-block lh-1"
                        style="color: {{ request()->is('jadwal') ? 'var(--dominant-font-color)' : '#000' }};"></i>
                </span>
                <span class="bottom-menu-title font-10 mst-4 text-uppercase lh-1">Jadwal</span>
            </a>
        </div>

        <div class="col">
            <a href="javascript:void(0)" aria-label="Menu toggler button"
                class="toggler-btn d-flex flex-column align-items-center ptb-10 text-center"
                style="color: var(--dominant-font-color);">
                <span class="bottom-menu-icon-wrap position-relative per-7">
                    <i class="ri-user-3-line d-block lh-1" style="color: var(--dominant-font-color);"></i>
                </span>
                <span class="bottom-menu-title body-color font-10 mst-4 text-uppercase lh-1">Profile</span>
            </a>
        </div>

    </div>
</div>
<!-- bottom-menu end --> --}}
