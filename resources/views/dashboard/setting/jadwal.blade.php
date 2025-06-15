@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('jadwal.update') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-3">Jadwal Kerja</h4>
                            <button type="submit" class="btn btn-primary">Update Jadwal</button>
                        </div>
                        <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Aksi</th> {{-- tambahkan ini --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $index => $item)
                                    <tr>
                                        <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        <td>{{ $item->hari }}</td>
                                        <td>
                                            <input type="time" name="jam_masuk[]" class="form-control"
                                                value="{{ $item->jam_masuk }}">
                                        </td>
                                        <td>
                                            <input type="time" name="jam_pulang[]" class="form-control"
                                                value="{{ $item->jam_pulang }}">
                                        </td>
                                        <td>
                                            <form action="{{ route('jadwal.reset.single', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Reset
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('alert_message'))
        <script>
            Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
        </script>
    @endif
@endsection
