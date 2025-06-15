@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Honorer</h4>
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Honorer
                        </button>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered app-data-table dt-responsive w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Tgl Lahir</th>
                                <th>L / P</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                @if (auth()->user()->role == 'super_admin')
                                    <th>Dinas</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($honorers as $honorer)
                                <tr>
                                    <td>{{ $honorer->user->name ?? '-' }}</td>
                                    <td>{{ $honorer->user->username ?? '-' }}</td>
                                    <td>{{ $honorer->user->tanggal_lahir ?? '-' }}</td>
                                    <td>{{ $honorer->jenis_kelamin }}</td>
                                    <td>{{ $honorer->no_hp }}</td>
                                    <td>{{ $honorer->alamat }}</td>
                                    @if (auth()->user()->role == 'super_admin')
                                        <td>{{ $honorer->user->dinas->nama_dinas ?? '-' }}</td>
                                    @endif
                                    {{-- <td>
                                        @if ($honorer->foto_wajah)
                                            <img src="{{ asset('storage/' . $honorer->foto_wajah) }}" alt="Foto Wajah"
                                                width="50" height="50" class="rounded">
                                        @else
                                            -
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditHonorer{{ $honorer->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <form action="{{ route('honorer.destroy', $honorer->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete btn btn-sm btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Honorer -->
                                <div class="modal fade" id="modalEditHonorer{{ $honorer->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white">Edit Honorer:
                                                    {{ $honorer->user->name ?? '-' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('honorer.update', $honorer->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="jenis_kelamin{{ $honorer->id }}"
                                                            class="form-label">Jenis Kelamin</label>
                                                        <select class="form-select" id="jenis_kelamin{{ $honorer->id }}"
                                                            name="jenis_kelamin" required>
                                                            <option value="Laki-laki"
                                                                {{ $honorer->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="Perempuan"
                                                                {{ $honorer->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_hp{{ $honorer->id }}" class="form-label">No
                                                            HP</label>
                                                        <input type="text" class="form-control"
                                                            id="no_hp{{ $honorer->id }}" name="no_hp"
                                                            value="{{ $honorer->no_hp }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat{{ $honorer->id }}"
                                                            class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat{{ $honorer->id }}" name="alamat" rows="3" required>{{ $honorer->alamat }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="foto_wajah{{ $honorer->id }}" class="form-label">Foto
                                                            Wajah</label>
                                                        <input type="file" class="form-control"
                                                            id="foto_wajah{{ $honorer->id }}" name="foto_wajah"
                                                            accept="image/*">
                                                        @if ($honorer->foto_wajah)
                                                            <img src="{{ asset('storage/' . $honorer->foto_wajah) }}"
                                                                alt="Foto Wajah" width="80" height="80"
                                                                class="mt-2 rounded">
                                                        @endif
                                                    </div>
                                                    <!-- Kalau mau update face_encoding, bisa tambah input hidden atau khusus -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary">
                                                        <i class="ti ti-refresh"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ti ti-check"></i> Save changes
                                                    </button>
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

    @if (session('alert_message'))
        <script>
            Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
        </script>
    @endif
    
    <!-- Offcanvas Add User -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel3">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel3">Add New User</h5>
            <button type="button" class="btn-close text-reset fs-5" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('honorer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Upload Foto Wajah (minimal 3):</label>
                    <input type="file" name="foto_wajah[]" multiple required accept="image/jpeg,image/jpg,image/png">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" required placeholder="Masukkan Nama.....">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required
                        placeholder="Masukkan Username.....">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required>
                </div>
                <div class="mb-3">
                    <label class="check-box">Jenis Kelamin</label>
                    <div class="form-check d-flex align-items-center gap-2 my-2 ps-0">
                        <input class="form-check-input f-s-18 mb-1 m-1" type="radio" name="jenis_kelamin"
                            id="radio_laki" value="Laki-laki" required>
                        <label for="radio_laki">Laki-laki</label>

                        <input class="form-check-input f-s-18 mb-1 m-1" type="radio" name="jenis_kelamin"
                            id="radio_perempuan" value="Perempuan" required>
                        <label for="radio_perempuan">Perempuan</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required
                        placeholder="Masukkan @Email.....">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <div class="input-group" id="content">
                        <span class="input-group-text">+62</span>
                        <input type="text" class="form-control" name="no_hp" placeholder="xxx-xxxxx-xxx" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat Anda........." required></textarea>
                </div>

                <input type="hidden" name="role" value="honorer">



                @if (auth()->user()->role == 'super_admin')
                    <div class="mb-3">
                        <label for="dinas_id" class="form-label">Dinas</label>
                        <select name="dinas_id" class="form-select" required>
                            <option selected disabled>Pilih Dinas</option>
                            @foreach ($dinas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_dinas }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif(auth()->user()->role == 'admin')
                    <input type="hidden" name="dinas_id" value="{{ auth()->user()->dinas_id }}">
                @endif


                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <button type="reset" class="btn btn-secondary">
                        <i class="ti ti-refresh"></i>
                    </button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">
                        <i class="ti ti-x"></i> Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
