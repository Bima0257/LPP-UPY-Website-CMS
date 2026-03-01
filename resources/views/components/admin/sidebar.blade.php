<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="/dashboard" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('superadmin-access')
                    <li>
                        <a href="/users-management" class=" waves-effect">
                            <i class="ri-folder-user-line"></i>
                            <span>Manajemen Akun</span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="/work-programs" class=" waves-effect">
                        <i class="ri-calendar-todo-fill"></i>
                        <span>Program Kerja</span>
                    </a>
                </li>

                @can('superadmin-access')
                    <li>
                        <a href="/members" class=" waves-effect">
                            <i class="ri-team-line"></i>
                            <span>Manajemen Anggota</span>
                        </a>
                    </li>

                    <li>
                        <a href="/menu-setting" class=" waves-effect">
                            <i class="ri-list-settings-line"></i>
                            <span>Pengaturan Menu</span>
                        </a>
                    </li>

                    <li>
                        <a href="/carousels-management" class=" waves-effect">
                            <i class="ri-layout-right-2-line"></i>
                            <span>Konten Carousel</span>
                        </a>
                    </li>

                    <li>
                        <a href="/banner-setting" class=" waves-effect">
                            <i class="ri-image-2-fill"></i>
                            <span>Pengaturan Banner</span>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="/documents-management" class=" waves-effect">
                        <i class="ri-folder-2-line"></i>
                        <span>Dokumen</span>
                    </a>
                </li>


                <li>
                    <a href="/posts-management" class=" waves-effect">
                        <i class="ri-article-line"></i>
                        <span>Artikel</span>
                    </a>
                </li>

                @can('superadmin-access')
                    <li>
                        <a href="/documents-categories" class=" waves-effect">
                            <i class="ri-function-line"></i>
                            <span>Kategori Dokumen</span>
                        </a>
                    </li>

                    <li>
                        <a href="/posts-categories" class=" waves-effect">
                            <i class="ri-apps-line"></i>
                            <span>Kategori Artikel</span>
                        </a>
                    </li>

                    <li>
                        <a href="/services" class=" waves-effect">
                            <i class="ri-external-link-line"></i>
                            <span>Layanan</span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="/messages" class=" waves-effect">
                        <i class="ri-chat-1-line"></i>
                        <span>Pesan</span>
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>

                @can('superadmin-access')
                    <li>
                        <a href="/about-settings" class=" waves-effect">
                            <i class="ri-information-line"></i>
                            <span>Tentang</span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="/logout" class=" waves-effect">
                        <i class="ri-logout-circle-r-line"></i>
                        <span>Keluar</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
