@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">User (Admin)</h4>
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Admin
                        </button>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Tgl Lahir</th>
                                <th>Email</th>
                                <th>Dinas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->role === 'admin')
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->tanggal_lahir ?? '-' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->dinas->nama_dinas ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditUser{{ $user->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete btn btn-sm btn-danger">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- SweetAlert -->
                                    <script src="assets/vendor/sweetalert/sweetalert.js"></script>
                                    <script src="assets/js/sweet_alert.js"></script>


                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white">Edit Admin: {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="username"
                                                                value="{{ $user->username }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Lahir</label>
                                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                                value="{{ $user->tanggal_lahir }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="{{ $user->email }}">
                                                        </div>
                                                        <input type="hidden" name="role" value="admin">
                                                        <div class="mb-3">
                                                            <label class="form-label">Dinas</label>
                                                            <select name="dinas_id" class="form-select">
                                                                <option value="">-- Pilih Dinas --</option>
                                                                @foreach ($dinas as $dinases)
                                                                    <option value="{{ $dinases->id }}"
                                                                        {{ $user->dinas_id == $dinases->id ? 'selected' : '' }}>
                                                                        {{ $dinases->nama_dinas }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-secondary"><i
                                                                class="ti ti-refresh"></i></button>
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="ti ti-check"></i> Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add Admin -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel3">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel3">Add New Admin</h5>
            <button type="button" class="btn-close text-reset fs-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" required placeholder="Masukkan Nama.....">
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required placeholder="Masukkan Username.....">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required placeholder="Masukkan @Email.....">
                </div>
                <input type="hidden" name="role" value="admin">
                <div class="mb-3">
                    <label class="form-label">Dinas</label>
                    <select name="dinas_id" class="form-select" required>
                        <option selected disabled>Pilih Dinas</option>
                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_dinas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <button type="reset" class="btn btn-secondary"><i class="ti ti-refresh"></i></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><i class="ti ti-x"></i>
                        Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
