@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="faq-header text-center">
                <img src="{{ asset('assets/images/logo/03.png') }}" alt="">
                <h2>Cari Honorer untuk Dispensasi</h2>
                <div class="search-div mx-auto" style="max-width: 500px;">
                    <div class="input-group b-r-search">
                        <span class="input-group-text bg-primary border-0"><i class="ti ti-search"></i></span>
                        <input id="searchInput" class="form-control" type="text" placeholder="Ketik nama honorer...">
                    </div>
                </div>
            </div>
            @if (session('alert_message'))
                <script>
                    Swal.fire("{{ session('alert_title') }}", "{{ session('alert_message') }}", "success");
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: "{{ session('error') }}"
                    });
                </script>
            @endif
            <div id="resultList" class="mt-4">
                @foreach ($honorers as $honorer)
                    <div class="card mt-2 honorer-item" data-name="{{ strtolower($honorer->user->name) }}">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $honorer->user->name }}</strong><br>
                                <small>{{ $honorer->user->email }}</small>
                            </div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#dispensasiModal{{ $honorer->id }}">Ajukan Dispensasi</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="dispensasiModal{{ $honorer->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('admin.dispensasi.store') }}" method="POST"
                                enctype="multipart/form-data" class="modal-content">
                                @csrf
                                <input type="hidden" name="honorer_id" value="{{ $honorer->id }}">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Dispensasi: {{ $honorer->user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="bukti_file">Upload Surat Tugas</label>
                                        <input type="file" name="bukti_file" class="form-control" required
                                            accept=".pdf,image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Dispensasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const honorers = document.querySelectorAll('.honorer-item');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            honorers.forEach(function(item) {
                const name = item.dataset.name;
                item.style.display = name.includes(keyword) ? 'block' : 'none';
            });
        });
    </script>
@endsection
