@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Rekapitulasi</h4>
                    </div>

                    {{-- Form Filter --}}
                    <form method="GET" class="row mb-3">
                        <div class="col-md-3">
                            <select name="bulan" class="form-control">
                                @foreach (range(1, 12) as $bln)
                                    <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $bln)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="tahun" class="form-control">
                                @for ($tahun = date('Y'); $tahun >= 2020; $tahun--)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </form>

                    {{-- Tabel Rekap --}}
                    <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tgl Lahir</th>
                                <th>L / P</th>
                                <th>Status</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Keterlambatan</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensis as $absensi)
                                <tr>
                                    <td>{{ $absensi->user->name ?? '-' }}</td>
                                    <td>{{ $absensi->user->tanggal_lahir ?? '-' }}</td>
                                    <td>{{ $absensi->user->honorer->jenis_kelamin ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = $absensi->status;
                                            $badgeClass = match ($status) {
                                                'alpha' => 'badge bg-danger',
                                                'hadir' => 'badge bg-success',
                                                'terlambat' => 'badge bg-warning',
                                                'izin', 'sakit' => 'badge bg-secondary',
                                                default => 'badge bg-light text-muted',
                                            };
                                        @endphp

                                        @if ($status)
                                            <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                        @else
                                            <span class="badge bg-light text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>{{ $absensi->waktu_masuk ?? '-' }}</td>
                                    <td>{{ $absensi->waktu_pulang ?? '-' }}</td>
                                    <td class="terlambat-cell">
                                        {{ is_numeric($absensi->menit_terlambat) ? $absensi->menit_terlambat : 0 }}</td>
                                    <td>
                                        @if ($absensi->bukti_file)
                                            <a href="{{ asset('storage/' . $absensi->bukti_file) }}"
                                                target="_blank">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-end">Total Telat : </th>
                                <th id="tfoot-terlambat">445</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @if (session('alert_message'))
        <script>
            Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
        </script>
    @endif
@endsection
