@extends('templatez.templating')
@section('content')
    <section class="invoice section-ptb">
        <div class="container">
            <div class="col-xl-10 mx-xl-auto mt-5">
                <div
                    class="track-record width-md-100 p-3 mb-3 border-radius extra-bg mt-3 d-flex justify-content-between align-items-center">
                    <!-- Judul untuk HP (misal font 18) -->
                    <h6 class="font-18 m-0 d-block d-md-none">Jadwal Kerja</h6>

                    <!-- Judul untuk tablet & desktop (misal font 25) -->
                    <h6 class="font-25 m-0 d-none d-md-block">Jadwal Kerja</h6>


                    <!-- Tombol icon download dengan style keren -->
                    <a href="javascript:window.print()"
                        class="invoice-button btn btn-style quaternary-btn px-3 pt-2 pb-2 rounded-3 shadow-sm border-0"
                        style="background: linear-gradient(to right, #056464, #0fcbab); color: white; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);"
                        aria-label="Download Jadwal">
                        <i class="ri-download-2-line font-18"></i>
                    </a>

                </div>
                <!-- track-record delivered start -->
                <div class="track-record width-md-100 ptb-30 plr-15 plr-sm-30 extra-bg border-radius mb-4">

                    <ul class="track-ul">
                        @foreach ($jadwal as $item)
                            <li class="track-li active pb-3">
                                <div class="track-icon-text d-flex flex-wrap align-items-center">
                                    <span
                                        class="track-icon width-64 height-64 d-flex align-items-center justify-content-center rounded-circle">
                                        <i class="ri-calendar-line d-block icon-24 lh-1"></i>
                                    </span>
                                    <div class="track-text width-calc-64 ul-mtm-15 psl-15">
                                        <h4 class="heading-color heading-weight text-uppercase">{{ $item->hari }}</h4>
                                    </div>
                                </div>
                                <div class="track-info ul-mtm-15 pst-8 psl-79">
                                    <div class="row">
                                        <div
                                            class="col-6 text-center quaternary-btn disabled d-flex flex-column align-items-center">
                                            <span class="heading-weight d-block mb-1"
                                                style="font-weight: bold; font-size: 1.1rem;">Masuk</span>
                                            <span class="d-block" style="font-size: 0.8rem;">
                                                {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : 'Libur' }}
                                            </span>
                                        </div>
                                        <div
                                            class="col-6 text-center quaternary-btn disabled d-flex flex-column align-items-center">
                                            <span class="heading-weight d-block mb-1"
                                                style="font-weight: bold; font-size: 1.1rem;">Pulang</span>
                                            <span class="d-block" style="font-size: 0.8rem;">
                                                {{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : 'Libur' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>
        </div>
    </section>
@endsection
