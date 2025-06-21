@extends('templatez.templating')
@section('content')
    <section class="about-feature-counter section-pt mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"></h4>

                            <table id="datatable-buttons"
                                class="table table-bordered app-data-table deafult-data-tabel dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Kehadiran</th>
                                        <th>Tanggal</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                        <th>Telat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensis as $absen)
                                        <tr>
                                            <td>{{ $absen->user->name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($absen->status === 'terlambat')
                                                    Terlambat ({{ $absen->menit_terlambat }} mnt)
                                                @else
                                                    {{ ucfirst($absen->status) }}
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                                            <td>{{ $absen->waktu_masuk_formatted }}</td>
                                            <td>{{ $absen->waktu_pulang_formatted }}</td>
                                            <td>{{ $absen->menit_terlambat ?? '-' }} Menit</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <script script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
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
    </section>
@endsection
