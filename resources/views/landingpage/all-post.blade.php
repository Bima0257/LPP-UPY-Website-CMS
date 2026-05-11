<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="container">
            <div class="col-lg-12">
                <div class="ud-banner-content">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Blog Start ====== -->
    <section class="ud-blog-grids mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Artikel</span>
                        <h2>Berita & Kegiatan LPP UPY</h2>
                        <p>
                            Temukan berbagai berita, kegiatan, dan informasi terbaru seputar LPP-UPY disini
                        </p>
                    </div>
                </div>
            </div>


            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3 mb-4">

                <!-- 🔍 KIRI: SEARCH -->
                <div class="search-wrapper flex-grow-1" style="max-width: 500px;">
                    <form
                        action="{{ isset($category) ? route('posts.byCategory', $category->slug) : (isset($author) ? route('posts.byAuthor', $author->name) : route('post.all')) }}"
                        method="GET" class="search-form">
                        <div class="search-input-wrapper"> <input type="text" name="search"
                                value="{{ request('search') }}" class="form-control search-input"
                                placeholder="Cari artikel berdasarkan judul atau konten..." autocomplete="off"
                                data-suggest-url="{{ isset($category) ? route('post.suggestions', $category->slug) : (isset($author) ? route('post.suggestions', $author->name) : route('post.suggestions')) }}">
                            <!-- Tombol reset (X) --> <button type="button" class="reset-btn d-none" id="resetSearch"
                                title="Hapus pencarian"> <i class="mdi mdi-close-circle-outline"></i> </button> </div>
                        <!-- Tombol search --> <button type="submit" class="btn btn-primary search-btn"> <i
                                class="mdi mdi-magnify"></i> </button>
                    </form> <!-- Box suggestion -->
                    <ul class="search-suggestions list-unstyled d-none"></ul>
                </div>


                <div class="filter-group">

                    <div class="dropdown">

                        <!-- 🔘 BUTTON -->
                        <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="mdi mdi-calendar-range"></i>

                            @if (request('date_from') && request('date_to'))
                                {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                            @elseif(request('date_from'))
                                Dari {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}
                            @elseif(request('date_to'))
                                Sampai {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                            @else
                                Tanggal
                            @endif
                        </button>

                        <!-- 📦 DROPDOWN -->
                        <div class="dropdown-menu p-3 dropdown-date">

                            <!-- 🏷 TITLE DI DALAM -->
                            <div class="mb-2 fw-semibold text-dark">
                                Pilih Rentang Tanggal
                            </div>

                            <!-- 📝 FORM -->
                            <form method="GET" action="{{ route('post.all') }}">

                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">

                                <input type="date" name="date_from" value="{{ request('date_from') }}"
                                    class="form-control mb-2">

                                <input type="date" name="date_to" value="{{ request('date_to') }}"
                                    class="form-control mb-2">

                                <button class="btn btn-primary btn-sm w-100">
                                    Terapkan
                                </button>
                            </form>
                        </div>

                    </div>

                    <!-- 📅 SORT -->
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="mdi mdi-sort"></i>
                            {{ request('sort') == 'asc' ? 'Terlama' : 'Terbaru' }}
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('post.all', array_merge(request()->except('sort'), ['sort' => 'desc'])) }}">
                                    Terbaru
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('post.all', array_merge(request()->except('sort'), ['sort' => 'asc'])) }}">
                                    Terlama
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- 🏷 CATEGORY -->
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="mdi mdi-tag-outline"></i>
                            {{ request('category') ? $categories->firstWhere('slug', request('category'))->name ?? 'Kategori' : 'Kategori' }}
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('post.all') }}">
                                    Semua Kategori
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @foreach ($categories as $cat)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('post.all', array_merge(request()->except('category'), ['category' => $cat->slug])) }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if (request()->hasAny(['search', 'category', 'sort', 'date_from', 'date_to']))
                        <a href="{{ route('post.all') }}" class="btn btn-danger">
                            <i class="mdi mdi-refresh"></i> Reset
                        </a>
                    @endif

                </div>
            </div>


            <div class="row">
                @forelse ($all_posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="ud-single-blog">
                            <div class="ud-blog-image">
                                <a href="{{ route('post.show', $post->slug) }}">
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="blog" />
                                </a>
                            </div>
                            <div class="ud-blog-content">
                                <span class="ud-blog-date">
                                    {{ \Carbon\Carbon::parse($post->date)->translatedFormat('d F Y') }}</span>
                                <h3 class="ud-blog-title">
                                    <a href="{{ route('post.show', $post->slug) }}">
                                        {!! $post->title !!}
                                    </a>
                                </h3>
                                <p class="ud-blog-desc">
                                    {!! Str::words(strip_tags($post->content ?? '-'), 15, '...') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">
                            <i class="mdi mdi-file-search-outline fs-2"></i><br>
                            Tidak ada Artikel
                            ditemukan{{ request('search') ? ' untuk pencarian "' . e(request('search')) . '"' : '' }}.
                        </h5>
                    </div>
                @endforelse

            </div>


            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $all_posts->links('vendor.pagination.custom-3page') }}
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Blog End ====== -->

    @push('scripts')
        <script src="{{ asset('js/post-page.js') }}"></script>
    @endpush

</x-landingpage.layout>

<script>
    function updateSearchPlaceholder() {
        const searchInput = document.querySelector('.search-input');

        if (!searchInput) return;

        if (window.innerWidth <= 576) {
            searchInput.placeholder = 'Cari artikel...';
        } else {
            searchInput.placeholder =
                'Cari Artikel berdasarkan judul atau konten...';
        }
    }

    updateSearchPlaceholder();
</script>
