   <!-- ====== Header Start ====== -->
   <header class="ud-header">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <nav class="navbar navbar-expand-lg">
                       <a class="navbar-brand" href="/">
                           <img src="{{ $about?->white_logo ? asset('storage/' . $about->white_logo) : asset('assets/images/logo/white_logo.png') }}"
                               data-white="{{ $about?->white_logo ? asset('storage/' . $about->white_logo) : asset('assets/images/logo/white_logo.png') }}"
                               data-black="{{ $about?->black_logo ? asset('storage/' . $about->black_logo) : asset('assets/images/logo/black_logo.png') }}"
                               alt="Logo" />
                       </a>
                       <button class="navbar-toggler">
                           <span class="toggler-icon"></span>
                           <span class="toggler-icon"></span>
                           <span class="toggler-icon"></span>
                       </button>

                       <div class="navbar-collapse">
                           <ul id="nav" class="navbar-nav mx-auto">
                               <!-- Home - tanpa submenu -->
                               <li class="nav-item">
                                   <a class="ud-menu-scroll" href="/#home">{{ $menu->home ?? 'Home' }}</a>
                               </li>

                               <!-- About - dengan submenu -->
                               <li class="nav-item nav-item-has-children">
                                   <div class="nav-item-wrapper">
                                       <a href="/#about">{{ $menu->about ?? 'About' }}</a>
                                       <button class="submenu-toggle" type="button"
                                           aria-label="Toggle submenu"></button>
                                   </div>
                                   <ul class="ud-submenu">
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('about.landingpage.index') }}" class="ud-submenu-link">
                                               Tentang LPP
                                           </a>
                                       </li>
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('about.landingpage.visi-misi') }}" class="ud-submenu-link">
                                               Visi - Misi & Tujuan
                                           </a>
                                       </li>
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('organizational-structure.index') }}"
                                               class="ud-submenu-link">
                                               Struktur Organisasi
                                           </a>
                                       </li>
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('work-programs.timeline') }}" class="ud-submenu-link">
                                               Program Kerja
                                           </a>
                                       </li>
                                   </ul>
                               </li>

                               <!-- Information - dengan submenu -->
                               <li class="nav-item nav-item-has-children">
                                   <div class="nav-item-wrapper">
                                       <a href="/#document">{{ $menu->information ?? 'Information' }}</a>
                                       <button class="submenu-toggle" type="button"
                                           aria-label="Toggle submenu"></button>
                                   </div>
                                   <ul class="ud-submenu">
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('document.all') }}" class="ud-submenu-link">
                                               Semua Dokumen
                                           </a>
                                       </li>
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('document.allCategory') }}" class="ud-submenu-link">
                                               Kategori
                                           </a>
                                       </li>
                                       @foreach ($documentCategories as $item)
                                           <li class="ud-submenu-item">
                                               <a href="{{ route('document.category', $item->slug) }}"
                                                   class="ud-submenu-link">
                                                   {{ $item->name }}
                                               </a>
                                           </li>
                                       @endforeach
                                   </ul>
                               </li>

                               <!-- News - dengan submenu -->
                               <li class="nav-item nav-item-has-children">
                                   <div class="nav-item-wrapper">
                                       <a href="/#news">{{ $menu->news ?? 'News' }}</a>
                                       <button class="submenu-toggle" type="button"
                                           aria-label="Toggle submenu"></button>
                                   </div>
                                   <ul class="ud-submenu">
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('post.all') }}" class="ud-submenu-link">
                                               Semua Artikel
                                           </a>
                                       </li>
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('post.allCategory') }}" class="ud-submenu-link">
                                               Kategori
                                           </a>
                                       </li>
                                       @foreach ($postCategories as $item)
                                           <li class="ud-submenu-item">
                                               <a href="{{ route('posts.category', $item->slug) }}"
                                                   class="ud-submenu-link">
                                                   {{ $item->name }}
                                               </a>
                                           </li>
                                       @endforeach
                                   </ul>
                               </li>

                               <!-- Service - dengan submenu -->
                               <li class="nav-item nav-item-has-children">
                                   <div class="nav-item-wrapper">
                                       <a href="/#service">{{ $menu->service ?? 'Service' }}</a>
                                       <button class="submenu-toggle" type="button"
                                           aria-label="Toggle submenu"></button>
                                   </div>
                                   <ul class="ud-submenu">
                                       <li class="ud-submenu-item">
                                           <a href="/service" class="ud-submenu-link">
                                               Semua Layanan
                                           </a>
                                       </li>
                                       @foreach ($services as $service)
                                           <li class="ud-submenu-item">
                                               <a href="{{ filter_var($service?->link, FILTER_VALIDATE_URL) ? $service->link : '#' }}" target="_blank" class="ud-submenu-link">
                                                   {{ $service->name }}
                                               </a>
                                           </li>
                                       @endforeach
                                   </ul>
                               </li>

                               <!-- Team - dengan submenu -->
                               <li class="nav-item nav-item-has-children">
                                   <div class="nav-item-wrapper">
                                       <a href="/#team">{{ $menu->team ?? 'Team' }}</a>
                                       <button class="submenu-toggle" type="button"
                                           aria-label="Toggle submenu"></button>
                                   </div>
                                   <ul class="ud-submenu">
                                       <li class="ud-submenu-item">
                                           <a href="{{ route('organizational-structure.index') }}"
                                               class="ud-submenu-link">
                                               Semua Anggota
                                           </a>
                                       </li>
                                   </ul>
                               </li>

                               <!-- Contact - tanpa submenu -->
                               <li class="nav-item">
                                   <a class="ud-menu-scroll" href="/#contact">{{ $menu->contact ?? 'Contact' }}</a>
                               </li>
                           </ul>
                       </div>
                   </nav>
               </div>
           </div>
       </div>
   </header>
   <!-- ====== Header End ====== -->
