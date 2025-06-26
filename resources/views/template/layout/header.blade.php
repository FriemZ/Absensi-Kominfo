       <!-- Header Section starts -->
       <header class="header-main">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="row">
                                   <div class="col-6 d-flex align-items-center header-left">

                                       <span class="header-toggle me-3">
                                           <i class="ti ti-category"></i>
                                       </span>

                                   </div>

                                   <div class="col-6 d-flex align-items-center justify-content-end header-right">
                                       <ul class="d-flex align-items-center">

                                           <li class="header-apps">
                                               <div class="flex-shrink-0 app-dropdown">
                                                   <a href="#" class="d-block head-icon" data-bs-toggle="dropdown"
                                                       data-bs-auto-close="true" aria-expanded="false">
                                                       <i class="ti ti-apps"></i>
                                                   </a>
                                                   <div
                                                       class="dropdown-menu headerapp-dropdown dropdown-menu-center bg-transparent border-0">
                                                       <div class="card">
                                                           <div class="card-header bg-primary">
                                                               <h5 class="text-white">Shortcut
                                                                   <span><i class="ti ti-apps text-white"></i></span>
                                                               </h5>
                                                           </div>
                                                           <div class="card-body">
                                                               <div class="row row-cols-2">
                                                                   <div class="d-flex-center text-center mb-3">
                                                                       <a href="/dispensasi">
                                                                           <span
                                                                               class="text-light-info h-60 w-60 d-flex-center b-r-100">
                                                                               <i
                                                                                   class="ti ti-user-question f-s-26"></i>
                                                                               {{-- Icon untuk Dispensasi --}}
                                                                           </span>
                                                                           <p class="mt-2 f-w-500 text-muted">Dispen</p>
                                                                       </a>
                                                                   </div>

                                                                   <div class="d-flex-center text-center mb-3">
                                                                       <a href="/rekapitulasi">
                                                                           <span
                                                                               class="text-light-primary h-60 w-60 d-flex-center b-r-100">
                                                                               <i
                                                                                   class="ti ti-calendar-check f-s-26"></i>
                                                                               {{-- Icon untuk Absensi --}}
                                                                           </span>
                                                                           <p class="mt-2 f-w-500 text-muted">Absensi
                                                                           </p>
                                                                       </a>
                                                                   </div>

                                                                   <div class="d-flex-center text-center mb-3">
                                                                       <a href="/honorer">
                                                                           <span
                                                                               class="text-light-success h-60 w-60 d-flex-center b-r-100">
                                                                               <i class="ti ti-id-badge f-s-26"></i>
                                                                               {{-- Icon untuk Honorer --}}
                                                                           </span>
                                                                           <p class="mt-2 f-w-500 text-muted">Honorer
                                                                           </p>
                                                                       </a>
                                                                   </div>

                                                                   <div class="d-flex-center text-center">
                                                                       <a href="/dinasku">
                                                                           <span
                                                                               class="text-light-warning h-60 w-60 d-flex-center b-r-100">
                                                                               <i class="ti ti-building f-s-26"></i>
                                                                               {{-- Icon untuk Instansi --}}
                                                                           </span>
                                                                           <p class="mt-2 f-w-500 text-muted">Instansi
                                                                           </p>
                                                                       </a>
                                                                   </div>
                                                               </div>

                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </li>
                                           <li class="header-dark head-icon">
                                               <div class="sun-logo">
                                                   <i class="ti ti-moon-off"></i>
                                               </div>
                                               <div class="moon-logo">
                                                   <i class="ti ti-moon-filled"></i>
                                               </div>
                                           </li>

                                           <li class="header-profile">
                                               <div class="flex-shrink-0 dropdown">
                                                   <a href="#" class="d-block head-icon pe-0"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                       @if (Auth::user()->foto)
                                                           <span
                                                               class="h-35 w-35 d-flex-center b-r-50 position-relative">
                                                               <img src="{{ asset(Auth::user()->foto) }}"
                                                                   alt="foto profil" class="img-fluid b-r-50"
                                                                   width="35" height="35">
                                                               <span
                                                                   class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                           </span>
                                                       @else
                                                           <span
                                                               class="bg-primary h-35 w-35 d-flex-center b-r-50 text-white">
                                                               <i class="fa-solid fa-user"></i>
                                                           </span>
                                                       @endif
                                                   </a>
                                                   <ul
                                                       class="dropdown-menu dropdown-menu-end header-card border-0 px-2">
                                                       <li class="dropdown-item d-flex align-items-center p-2">
                                                           <span
                                                               class="h-35 w-35 d-flex-center b-r-50 position-relative">
                                                               @if (Auth::user()->foto)
                                                                   <span
                                                                       class="h-35 w-35 d-flex-center b-r-50 position-relative">
                                                                       <img src="{{ asset(Auth::user()->foto) }}"
                                                                           alt="foto profil" class="img-fluid b-r-50"
                                                                           width="35" height="35">
                                                                       <span
                                                                           class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                                   </span>
                                                               @else
                                                                   <span
                                                                       class="bg-primary h-35 w-35 d-flex-center b-r-50 text-white">
                                                                       <i class="fa-solid fa-user"></i>
                                                                   </span>
                                                               @endif
                                                               <span
                                                                   class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                           </span>
                                                           <div class="flex-grow-1 ps-2">
                                                               <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                                               <p class="f-s-12 mb-0 text-secondary">
                                                                   {{ Auth::user()->role ?? 'Pengguna' }} |
                                                                   {{ Auth::user()->email ?? 'no email' }}
                                                               </p>
                                                           </div>
                                                       </li>

                                                       <li class="app-divider-v dotted py-1"></li>
                                                       {{-- <li>
                                                           <a class="dropdown-item" href="/profil">
                                                               <i class="ti ti-user-circle pe-1 f-s-18"></i>
                                                               Profile Detaiils
                                                           </a>
                                                       </li> --}}
                                                       <li>
                                                           <a class="dropdown-item" href="#"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#ubahPasswordModal">
                                                               <i class="ti ti-lock pe-1 f-s-18"></i>
                                                               Ubah Password
                                                           </a>
                                                       </li>
                                                       <li class="app-divider-v dotted py-1"></li>
                                                       <li class="btn-light-danger b-r-5">
                                                           <form action="{{ route('logout') }}" method="POST"
                                                               class="mb-0">
                                                               @csrf
                                                               <button type="submit" class="dropdown-item text-danger"
                                                                   style="background: none; border: none;">
                                                                   <i class="ti ti-logout pe-1 f-s-18 text-danger"></i>
                                                                   Log Out
                                                               </button>
                                                           </form>
                                                       </li>

                                                   </ul>
                                               </div>


                                            

                                           </li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </header>
       <!-- Header Section ends -->
