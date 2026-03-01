<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="row">
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


            <!-- ====== Search Bar ====== -->
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto mb-5">
                    <div class="search-wrapper">
                        <form
                            action="{{ isset($category)
                                ? route('posts.byCategory', $category->slug)
                                : (isset($author)
                                    ? route('posts.byAuthor', $author->name)
                                    : route('post.all')) }}"
                            method="GET" class="search-form">
                            <div class="search-input-wrapper">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control search-input"
                                    placeholder="Cari artikel berdasarkan judul atau konten..." autocomplete="off"
                                    data-suggest-url="{{ isset($category)
                                        ? route('post.suggestions', $category->slug)
                                        : (isset($author)
                                            ? route('post.suggestions', $author->name)
                                            : route('post.suggestions')) }}">

                                <!-- Tombol reset (X) -->
                                <button type="button" class="reset-btn d-none" id="resetSearch"
                                    title="Hapus pencarian">
                                    <i class="mdi mdi-close-circle-outline"></i>
                                </button>
                            </div>

                            <!-- Tombol search -->
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </form>

                        <!-- Box suggestion -->
                        <ul class="search-suggestions list-unstyled d-none"></ul>
                    </div>
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
                                <span class="ud-blog-date">{{ $post->created_at->format('M d, Y') }}</span>
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
                    {{ $all_posts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Blog End ====== -->

    @push('scripts')
        <script src="{{ asset('js/post-page.js') }}"></script>
    @endpush

</x-landingpage.layout>
