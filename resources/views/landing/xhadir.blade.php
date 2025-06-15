@extends('templatez.templating')
@section('content')
    <!-- about-feature-counter start -->
    <section class="about-feature-counter ">
        <div class="container">
            <div class="row row-mtm30">
                <div class="col-12 col-lg-12 text-center full-center-wrapper" data-animate="animate__fadeIn">
                    {{-- Tampilkan pesan error --}}
                    @if (session('error'))
                        <div class="alert alert-danger mb-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Tampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('storeIzin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="position-relative peb-19">
                            <div class="about-feature-counter-info ptb-10 plr-10 extra-bg box-shadow br-hidden">
                                <div class="d-flex flex-column align-items-center p-4 extra-bg shadow-lg rounded-4 mt-3 w-100"
                                    style="max-width: 500px; margin: auto;">
                                    <label class="form-label fw-semibold text-muted mb-2">Status</label>
                                    <div class="status-radio-group-row mb-4">
                                        <label class="status-option">
                                            <input type="radio" name="status" value="izin" required>
                                            <div class="option-box">
                                                <i class="ri-check-line"></i>
                                                <span>Izin</span>
                                            </div>
                                        </label>

                                        <label class="status-option">
                                            <input type="radio" name="status" value="sakit" required>
                                            <div class="option-box">
                                                <i class="ri-hospital-line"></i>
                                                <span>Sakit</span>
                                            </div>
                                        </label>
                                    </div>




                                    <label class="form-label fw-semibold text-muted mb-2 mt-2">Upload Bukti
                                        (jpg/png/pdf)</label>
                                    <input type="file" name="bukti_file"
                                        class="form-control shadow-sm rounded-3 border-1" required>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn position-absolute bottom-0 start-50 translate-middle-x z-1 btn-style "
                                style="cursor:pointer; padding: 0;">
                                <span
                                    class="dominant-color font-16 width-auto height-auto d-inline-flex align-items-center justify-content-center extra-bg box-shadow border-radius gap-2 px-3 py-2"
                                    style="min-width: 120px;">
                                    <i class="ri-send-plane-line"></i>
                                    Ajukan
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- about-feature-counter end -->
@endsection
