@extends('templatez.templating')

@section('content')
    <section class="account-page section-ptb mt-5 mb-4">
        <div class="container">
            <div class="row row-mtm align-items-lg-start">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class="ap-detail shadow-sm p-4 rounded-4 bg-white"
                        style="color: var(--dominant-font-color); transition: all 0.3s ease;">
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="ap-detail-info">
                                <div class="acc-info">
                                    <div class="acc-detail-form">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control shadow-sm" name="username"
                                                    value="{{ old('username', $user->username) }}" placeholder="Nama Alias">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control shadow-sm" name="name"
                                                    value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Dinas</label>
                                                <input type="text" class="form-control shadow-sm"
                                                    value="{{ $user->dinas->nama_dinas ?? '-' }}" readonly>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">No HP</label>
                                                <input type="text" class="form-control shadow-sm" name="no_hp"
                                                    value="{{ old('no_hp', $honorer->no_hp) }}" placeholder="Nomor HP">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label mb-3">Jenis Kelamin</label>
                                                <div class="row row-cols-2">
                                                    <div class="col d-flex justify-content-start">
                                                        <label class="cust-radio-label">
                                                            <input type="radio" name="jenis_kelamin" value="Laki-laki"
                                                                class="cust-checkbox"
                                                                {{ $honorer->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                                            <span class="d-block cust-check"></span>
                                                            <span class="cust-text">
                                                                <span class="cust-other-text">Laki-Laki</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col d-flex justify-content-start">
                                                        <label class="cust-radio-label">
                                                            <input type="radio" name="jenis_kelamin" value="Perempuan"
                                                                class="cust-checkbox"
                                                                {{ $honorer->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                                            <span class="d-block cust-check"></span>
                                                            <span class="cust-text">
                                                                <span class="cust-other-text">Perempuan</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" class="form-control shadow-sm" name="alamat"
                                                    value="{{ old('alamat', $honorer->alamat) }}"
                                                    placeholder="Alamat Lengkap">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control shadow-sm"
                                                    value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d')) }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Ganti Password (opsional)</label>
                                                <input type="password" name="password" class="form-control shadow-sm"
                                                    placeholder="********">
                                            </div>

                                        </div>

                                        <div class="mt-4 d-flex justify-content-end align-content-end flex-wrap gap-3">
                                            <button type="submit" class="btn dominant-btn px-4 rounded-pill">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
