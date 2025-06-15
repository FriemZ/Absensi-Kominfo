@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Dinas</h4>
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Dinas
                        </button>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Nama Dinas</th>
                                <th>Alamat</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Radius Absen (m)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dinas as $item)
                                <tr>
                                    <td>{{ $item->nama_dinas }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>{{ $item->longitude }}</td>
                                    <td>{{ $item->radius_absen ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditDinas{{ $item->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <form action="{{ route('dinas.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete btn btn-sm btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                            @if (session('alert_message'))
                                                <script>
                                                    Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
                                                </script>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Dinas -->
                                <div class="modal fade" id="modalEditDinas{{ $item->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('dinas.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Edit Dinas: {{ $item->nama_dinas }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nama_dinas{{ $item->id }}" class="form-label">Nama
                                                            Dinas</label>
                                                        <input type="text" class="form-control"
                                                            id="nama_dinas{{ $item->id }}" name="nama_dinas"
                                                            value="{{ $item->nama_dinas }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat{{ $item->id }}"
                                                            class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat{{ $item->id }}" name="alamat" required>{{ $item->alamat }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="latitude{{ $item->id }}"
                                                            class="form-label">Latitude</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="latitude{{ $item->id }}" name="latitude"
                                                            value="{{ $item->latitude }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="longitude{{ $item->id }}"
                                                            class="form-label">Longitude</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="longitude{{ $item->id }}" name="longitude"
                                                            value="{{ $item->longitude }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="radius_absen{{ $item->id }}"
                                                            class="form-label">Radius Absen (meter)</label>
                                                        <input type="number" class="form-control"
                                                            id="radius_absen{{ $item->id }}" name="radius_absen"
                                                            value="{{ $item->radius_absen ?? 100 }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add Dinas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel3">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel3">Add New Dinas</h5>
            <button type="button" class="btn-close text-reset fs-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('dinas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_dinas" class="form-label">Nama Dinas</label>
                    <input type="text" class="form-control" name="nama_dinas" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="number" step="any" class="form-control" name="latitude" required>
                </div>
                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="number" step="any" class="form-control" name="longitude" required>
                </div>
                <div class="mb-3">
                    <label for="radius_absen" class="form-label">Radius Absen (meter)</label>
                    <input type="number" class="form-control" name="radius_absen" value="100">
                </div>
                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
