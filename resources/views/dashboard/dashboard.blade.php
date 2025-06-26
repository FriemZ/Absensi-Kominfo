@extends('template.templating')
@section('content')
    <div class="row">
        <!-- Project Dashboard card start -->
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card project-cards">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6>Admin<span class="badge text-success"></span></h6>

                        <div class="d-flex align-items-center gap-2 mt-2">
                            <h4 class="text-success f-w-600 counting" data-count="{{ $totalAdmin }}">{{ $totalAdmin }}
                            </h4>
                        </div>
                    </div>
                    <div class="project-card-icon project-success bg-light-success h-55 w-55 d-flex-center b-r-100">
                        <i class="ti ti-user f-s-30 mb-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card project-cards">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6>Honorer<span class="badge text-warning"></span></h6>

                        <div class="d-flex align-items-center gap-2 mt-2">
                            <h4 class="text-warning f-w-600 counting" data-count="{{ $totalHonorer }}">{{ $totalHonorer }}
                            </h4>
                        </div>
                    </div>
                    <div class="project-card-icon project-secondary bg-light-warning h-55 w-55 d-flex-center b-r-100">
                        <i class="ti ti-users f-s-30 mb-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card project-cards">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6>Alpha<span class="badge text-danger"></span></h6>

                        <div class="d-flex align-items-center gap-2 mt-2">
                            <h4 class="text-danger f-w-600 counting" data-count="{{ $totalAlpha }}">{{ $totalAlpha }}
                            </h4>
                        </div>
                    </div>
                    <div class="project-card-icon project-danger bg-light-danger h-55 w-55 d-flex-center b-r-100">
                        <i class="ti ti-circle-x f-s-30 mb-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card project-cards">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6 class="text-secondary">Absensi<span class="badge text-success"></span></h6>

                        <div class="d-flex align-items-center gap-2 mt-2">
                            <h4 class="text-success f-w-600 counting inline" data-count="{{ $totalAbsensiValid }}">
                                {{ $totalAbsensiValid }}</h4>
                        </div>
                    </div>
                    <div class="project-card-icon project-primary bg-light-success h-60 w-60 d-flex-center b-r-100">
                        <i class="ti ti-browser-check f-s-36 mb-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Line, Column & Area Chart start -->
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Statistic</h5>
                </div>
                <div class="card-body">
                    <div id="mixed4"></div>
                </div>
            </div>
        </div>
        <!-- Line, Column & Area Chart end -->

  
    </div>

    <script>
        var labels = @json($labels);
        var dataHadir = @json($hadir);
        var dataTerlambat = @json($terlambat);
        var dataAlpha = @json($alpha);
    </script>


    {{-- 
    <!-- modal -->
    <div class="modal" id="welcomeCard" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content welcome-image">
                <div class="modal-body">
                    <div>
                        <div class="text-center">
                            <div class="text-end">
                                <i class="ti ti-x fs-5 text-secondary" data-bs-dismiss="modal"></i>
                            </div>
                            <h2 class="text-primary f-w-600">Welcome <i class="ti ti-heart-handshake text-warning"></i>
                            </h2>
                            <p class="text-light f-w-500 f-s-16 mx-sm-5">
                                Start Multipurpose, clean modern responsive bootstrap 5 admin template</p>
                            <img src="assets/images/modals/welcome.png" class="img-fluid h-140 mt-3 mb-3" alt="">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="">
                                        <div class="mb-2">
                                            <p class="text-secondary f-w-400"><i
                                                    class="ti ti-bookmarks f-s-15 text-primary me-2"></i>Build
                                                your next project faster with AdminX</p>
                                        </div>

                                        <div class="mb-2">
                                            <p class="text-secondary f-w-400 ms-2 mb-0"><i
                                                    class="ti ti-presentation-analytics f-s-15 me-2 text-success"></i>Start
                                                Your Project With
                                                Flexible Admin</p>
                                        </div>

                                        <div class="mb-2">
                                            <p class="text-secondary f-w-400 ms-2 mb-0"> <i
                                                    class="ti ti-users f-s-15 me-2 text-danger"></i>
                                                Enjoy dev-friendly features </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 mt-2">
                                <button type="button" class="btn btn-primary text-white w-200 btn-lg"
                                    data-bs-dismiss="modal">Let's
                                    Started <i class="ti ti-chevrons-right"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
