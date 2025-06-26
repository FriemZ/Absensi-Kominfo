@extends('template.templating')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-xxl-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="profile-container">
                        <div class="image-details">
                            <div class="profile-image"></div>
                            <div class="profile-pic">
                                <div class="avatar-upload">
                                    <div class="avatar-preview bg-primary  d-flex-center text-white">
                                        <i class="fa-solid fa-user fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="person-details">
                            <h5 class="f-w-600">{{ Auth::user()->name }}
                                <img width="20" height="20" src="assets/images/profile/01.png"
                                    alt="instagram-check-mark">
                            </h5>
                            <p>{{ Auth::user()->role }}</p>
                            <div class="details">
                                <div>
                                    <h4 class="text-primary">10</h4>
                                    <p class="text-secondary">Post</p>
                                </div>
                                <div>
                                    <h4 class="text-primary">3.4k</h4>
                                    <p class="text-secondary">Follower</p>
                                </div>
                                <div>
                                    <h4 class="text-primary">1k</h4>
                                    <p class="text-secondary">Following</p>
                                </div>
                            </div>
                            <div class="my-2">
                                <button type="button" class="btn btn-primary b-r-22"> <i class="ti ti-user-check"></i>
                                    Follow</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
