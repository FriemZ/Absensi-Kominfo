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
                                                <h5 class="modal-title text-white">Honorer :
                                                    {{ $honorer->user->name ?? '-' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('honorer.update', $honorer->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    @if ($honorer->foto_wajah)
                                                        <div class="mb-2">
                                                            <label>Foto Wajah Saat Ini:</label>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach (json_decode($honorer->foto_wajah, true) as $foto)
                                                                    <img src="{{ $foto }}" width="100"
                                                                        height="100" class="rounded border"
                                                                        alt="Foto">
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <label>Upload Foto Wajah (minimal 3 jika ingin mengganti):</label>
                                                        <input type="file" name="foto_wajah[]" multiple
                                                            accept="image/jpeg,image/jpg,image/png">
                                                        <br> <small class="text-muted">Kosongkan jika tidak ingin
                                                            mengganti.</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username{{ $honorer->id }}"
                                                            class="form-label">Username</label>
                                                        <input type="text" class="form-control"
                                                            id="username{{ $honorer->id }}" name="username"
                                                            value="{{ $honorer->user->username }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name{{ $honorer->id }}" class="form-label">Nama
                                                            Lengkap</label>
                                                        <input type="text" class="form-control"
                                                            id="name{{ $honorer->id }}" name="name"
                                                            value="{{ $honorer->user->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="check-box">Jenis Kelamin</label>
                                                        <div class="form-check d-flex align-items-center gap-3 my-2 ps-0">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelamin"
                                                                    id="radio_laki{{ $honorer->id ?? '' }}"
                                                                    value="Laki-laki"
                                                                    {{ old('jenis_kelamin', $honorer->jenis_kelamin ?? '') == 'Laki-laki' ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="radio_laki{{ $honorer->id ?? '' }}">Laki-laki</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelamin"
                                                                    id="radio_perempuan{{ $honorer->id ?? '' }}"
                                                                    value="Perempuan"
                                                                    {{ old('jenis_kelamin', $honorer->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : '' }}
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="radio_perempuan{{ $honorer->id ?? '' }}">Perempuan</label>
                                                            </div>
                                                        </div>
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
                                                        <label for="new_password{{ $honorer->id }}"
                                                            class="form-label">Password Baru (Opsional)</label>
                                                        <input type="password" class="form-control"
                                                            id="new_password{{ $honorer->id }}" name="new_password"
                                                            placeholder="Kosongkan jika tidak ingin mengubah (max:6) ">
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
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" placeholder="Masukkan Email.....(Optional)">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }} {{-- Contoh: "The email has already been taken." --}}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <div class="input-group" id="content">
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
