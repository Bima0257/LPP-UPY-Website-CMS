<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/dashboard" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ $about?->favicon ? asset('storage/' . $about->favicon) : asset('assets/images/logo/favicon.png') }}"
                            alt="logo-sm-dark" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ $about?->white_logo ? asset('storage/' . $about->white_logo) : asset('assets/images/logo/white_logo.png') }}"
                            alt="logo-light" style="width: 100px; height: 30px">
                    </span>
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    @if ($unreadCount > 0)
                        <span class="noti-dot"></span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">

                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">Pesan Masuk</h6>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-danger fs-6">{{ $unreadCount }}</span>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        @forelse ($unreadMessages as $msg)
                            <a href="{{ route('admin.messages.index') }}" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="ri-mail-unread-line"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-1">{{ $msg->name }}</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">{{ Str::limit($msg->subject, 40) }}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                {{ $msg->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-muted p-3">
                                Tidak ada pesan baru
                            </div>
                        @endforelse
                    </div>

                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center"
                                href="{{ route('admin.messages.index') }}">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> Lihat Semua Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if ($user && $user->avatar)
                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . $user->avatar) }}"
                            alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1">{{ $user->name }}</span>
                    @else
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('assets_admin/images/default-profile.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1">{{ $user->name }}</span>
                    @endif

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="/"><i class="ri-home-line align-middle me-1"></i>
                        Landing Page LPP</a>
                    <a class="dropdown-item d-block" href="/profile"><i
                            class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/logout"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
