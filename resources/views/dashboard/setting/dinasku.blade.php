@extends('template.templating')
@section('content')
    <div class="row">
        <!-- Custom Styles start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $dinas->nama_dinas }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dinasku.update', $dinas->id) }}" method="POST" class="row g-3 needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="col-md-12">
                            <label for="nama_dinas" class="form-label">Nama Dinas</label>
                            <input type="text" name="nama_dinas" value="{{ $dinas->nama_dinas }}" class="form-control"
                                required>
                        </div>

                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" value="{{ $dinas->alamat }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" step="any" name="latitude" value="{{ $dinas->latitude }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" step="any" name="longitude" value="{{ $dinas->longitude }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="radius_absen" class="form-label">Radius Absen (meter)</label>
                            <input type="number" name="radius_absen" value="{{ $dinas->radius_absen }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="maks_keterlambatan" class="form-label">Max Terlambat (menit)</label>
                            <input type="number" name="maks_keterlambatan" value="{{ $dinas->maks_keterlambatan }}"
                                class="form-control" required>
                        </div>

                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-secondary">
                                <i class="ti ti-refresh"></i>
                            </button>
                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        </div>
                    </form>
                    @if (session('alert_message'))
                        <script>
                            Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
                        </script>
                    @endif
                </div>
            </div>
        </div>
        <!-- Custom Styles end -->
    </div>
@endsection
