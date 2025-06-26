@extends('templatez.templating')
@section('content')
    <section class="about-feature-counter section-pt mt-5">
        <div class="container">
            {{-- Form Pilih Bulan dan Tahun --}}
            <form id="filterForm" class="row gx-2 gy-2 mb-4 align-items-end">
                <div class="col-5 col-md-4">
                    <select id="bulan" class="form-control logo-raised" name="bulan" required>
                        <option value="" disabled selected>Pilih Bulan</option>
                        @foreach (range(1, 12) as $bln)
                            <option value="{{ $bln }}">{{ DateTime::createFromFormat('!m', $bln)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-5 col-md-4">
                    <select id="tahun" class="form-control logo-raised" name="tahun" required>
                        <option value="" disabled selected>Pilih Tahun</option>
                        @for ($th = date('Y'); $th >= 2020; $th--)
                            <option value="{{ $th }}">{{ $th }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-2 col-md-4">
                    <button type="button" class="btn w-100 logo-raised" id="btnLihatRekap" style="height: 48px;">
                        <i class="ri-eye-line"></i>
                    </button>
                </div>
            </form>

            {{-- Absensi Hari Ini --}}
            <div class="card" id="absenHariIni">
                <div class="card-body logo-raised text-center p-4">
                    <h2 class="card-title mb-4">
                        Absensi {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                    </h2>

                    @if ($absensiHariIni)
                        {{-- Tanggal besar di tengah --}}
                        <h1 class="fw-bold display-1 mb-3" style="font-size: 5rem;">
                            {{ \Carbon\Carbon::parse($absensiHariIni->tanggal)->translatedFormat('d') }}
                        </h1>

                        <p style="font-size: 1.2rem;">
                            @if ($absensiHariIni->status === 'terlambat')
                                Terlambat <br>({{ $absensiHariIni->menit_terlambat }} menit)
                            @else
                                {{ ucfirst($absensiHariIni->status) }}
                            @endif
                        </p>

                        <div class="d-flex justify-content-center align-items-center gap-5 mt-3">
                            <p><strong>Masuk :</strong>
                                {{ $absensiHariIni->waktu_masuk ? \Carbon\Carbon::parse($absensiHariIni->waktu_masuk)->format('H:i') : '-' }}
                            </p>

                            <p><strong>Pulang :</strong>
                                {{ $absensiHariIni->waktu_pulang ? \Carbon\Carbon::parse($absensiHariIni->waktu_pulang)->format('H:i') : '-' }}
                            </p>
                        </div>
                    @else
                        <h1 class="fw-bold display-1 mb-3" style="font-size: 5rem;">
                            {{ \Carbon\Carbon::now()->translatedFormat('d') }}
                        </h1>
                        <p class="mt-4">Belum ada data hari ini.</p>
                    @endif
                </div>
            </div>



            {{-- Tabel Rekap Bulanan --}}
            <div class="card mt-4 logo-raised" id="rekapCard"
                style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Kehadiran</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensis as $absen)
                                @php
                                    $bulanAbsen = \Carbon\Carbon::parse($absen->tanggal)->month;
                                    $tahunAbsen = \Carbon\Carbon::parse($absen->tanggal)->year;
                                @endphp
                                <tr data-bulan="{{ $bulanAbsen }}" data-tahun="{{ $tahunAbsen }}">
                                    <td>
                                        @if ($absen->status === 'terlambat')
                                            Terlambat ({{ $absen->menit_terlambat }} mnt)
                                        @else
                                            {{ ucfirst($absen->status) }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- SweetAlert + Logic Transisi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('btnLihatRekap').addEventListener('click', function() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;

            if (!bulan || !tahun) {
                Swal.fire('Peringatan', 'Silakan pilih bulan dan tahun terlebih dahulu.', 'warning');
                return;
            }

            // Filter baris dengan class d-none agar tetap responsif
            document.querySelectorAll('#rekapCard tbody tr').forEach(row => {
                const rowBulan = row.getAttribute('data-bulan');
                const rowTahun = row.getAttribute('data-tahun');

                if (rowBulan == bulan && rowTahun == tahun) {
                    row.classList.remove('d-none');
                } else {
                    row.classList.add('d-none');
                }
            });

            // Tampilkan rekap dan sembunyikan absensi hari ini
            const rekapCard = document.getElementById('rekapCard');
            const absenHariIni = document.getElementById('absenHariIni');

            absenHariIni.style.display = 'none';
            rekapCard.style.display = 'block';
            setTimeout(() => {
                rekapCard.style.opacity = 1;
            }, 50);
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>

@endsection
