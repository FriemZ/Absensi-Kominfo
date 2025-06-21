@extends('templatez.templating')
@section('content')
    <section class="about-feature-counter section-pt mt-5">
        <div class="container">
            <div class="row row-mtm30">
                <div class="col-12 col-lg-12 text-center" data-animate="animate__fadeIn">
                    <div class="position-relative peb-19">
                        <div class="about-feature-counter-info ptb-10 plr-10 extra-bg box-shadow br-hidden">
                            <div
                                class="d-flex flex-column align-items-center ptb-30 plr-15 plr-sm-30 extra-bg box-shadow border-radius">
                                <h2 class="dominant-color font-18 text-center" id="realtime-date">Sabtu, 4 Mei 2025</h2>
                                <h2 class="dominant-color font-32" id="realtime-time">00:00:00</h2>
                                <div class="secondary-color d-flex align-items-baseline mst-9 mb-4">
                                    @if (!$absenHariIni)
                                        {{-- Belum absen hari ini --}}
                                        Absen Masuk
                                        @if ($tampilkanTerlambat)
                                            (<span class="text-danger">-{{ round($menitTerlambat) }}mnt</span>)
                                        @endif
                                    @elseif ($absenHariIni && !$absenHariIni->waktu_pulang)
                                        {{-- Sudah absen masuk tapi belum pulang --}}
                                        Absen Pulang
                                        @if ($tampilkanTerlambat)
                                            (<span class="text-danger">-{{ round($menitTerlambat) }}mnt</span>)
                                        @endif
                                    @else
                                        {{-- Sudah absen penuh --}}
                                        Sudah absen hari ini
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 z-1 d-flex justify-content-center align-content-center mb-4"
                            style="transform: translateY(48%);">
                            <div class="col-2.9 col-lg-11 about-counter-content d-flex flex-wrap border-full br-hidden"
                                style="border: 3.5px solid var(--dominant-font-color); border-radius: 20px;">

                                <div class="col-2.9 col-lg-3 d-flex flex-column pt-2 pb-2 align-items-center ptb-30 plr-15 plr-sm-30 extra-bg text-center about-counter-info"
                                    data-animate="animate__fadeIn">
                                    <span
                                        class="about-counter-icon secondary-color icon-16 width-40 height-40 d-flex align-items-center justify-content-center rounded-circle box-shadow mb-1">
                                        {{ $absenTotal['hadir'] ?? 0 }}
                                    </span>
                                    <h6 class="dominant-color font-12">Hadir</h6>
                                </div>
                                <div class="col-2.9 col-lg-3 d-flex flex-column pt-2 pb-2 align-items-center ptb-30 plr-15 plr-sm-30 extra-bg text-center about-counter-info"
                                    data-animate="animate__fadeIn">
                                    <span
                                        class="about-counter-icon secondary-color icon-16 width-40 height-40 d-flex align-items-center justify-content-center rounded-circle box-shadow mb-1">
                                        {{ $absenTotal['izin'] ?? 0 }}
                                    </span>
                                    <h6 class="dominant-color font-12">Izin</h6>
                                </div>
                                <div class="col-2.9 col-lg-3 d-flex flex-column pt-2 pb-2 align-items-center ptb-30 plr-15 plr-sm-30 extra-bg text-center about-counter-info"
                                    data-animate="animate__fadeIn">
                                    <span
                                        class="about-counter-icon secondary-color icon-16 width-40 height-40 d-flex align-items-center justify-content-center rounded-circle box-shadow mb-1">
                                        {{ $absenTotal['sakit'] ?? 0 }}
                                    </span>
                                    <h6 class="dominant-color font-12">Sakit</h6>
                                </div>
                                <div class="col-2.9 col-lg-3 d-flex flex-column pt-2 pb-2 align-items-center ptb-30 plr-15 plr-sm-30 extra-bg text-center about-counter-info"
                                    data-animate="animate__fadeIn">
                                    <span
                                        class="about-counter-icon secondary-color icon-16 width-40 height-40 d-flex align-items-center justify-content-center rounded-circle box-shadow mb-1">
                                        {{ $absenTotal['alpha'] ?? 0 }}
                                    </span>
                                    <h6 class="dominant-color font-12">Alpha</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="about-feature-counter section-pt" style="margin-bottom: 80px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="app-scroll table-responsive">
                                <table class="table align-middle mb-0">
                                    {{-- <thead class="bg-light text-center text-muted">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>T.Lambat</th>
                                        </tr>
                                    </thead> --}}
                                    <tbody>
                                        @forelse ($absensis as $absen)
                                            <tr class="text-center glass-row">
                                                <td class="text-start ps-3">
                                                    <div class="text-muted small">
                                                        {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d M Y') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        style="color: var(--dominant-font-color); white-space: nowrap; display: inline-block;">
                                                        <b>{{ $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i') : '-' }}</b>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        style="color: var(--dominant-font-color); white-space: nowrap; display: inline-block;">
                                                        <b>{{ $absen->waktu_pulang ? \Carbon\Carbon::parse($absen->waktu_pulang)->format('H:i') : '-' }}</b>
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($absen->status === 'alpha')
                                                        <span class="text-secondary text-capitalize">Alpha</span>
                                                    @elseif (in_array($absen->status, ['izin', 'sakit']))
                                                        <span
                                                            class="text-warning text-capitalize">{{ $absen->status }}</span>
                                                    @elseif ($absen->status === 'terlambat')
                                                        <span
                                                            class="text-danger fw-semibold">-{{ $absen->menit_terlambat }}
                                                            menit</span>
                                                    @else
                                                        <span class="text-success">Ontime</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    Belum ada riwayat absensi.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div>
    </section>
@endsection
