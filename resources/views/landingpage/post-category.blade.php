<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-banner-content">
                        <h1>News & Information</h1>
                        <h4 class="text-white mt-3">Kategori - {{ $category->name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Blog Start ====== -->
    <section class="ud-blog-grids">
        <div class="container">

            <!-- ====== Search Bar ====== -->
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto mb-5">
                    <div class="search-wrapper">
                        <form
                            action="{{ isset($category)
                                ? route('posts.category', $category->slug)
                                : (isset($author)
                                    ? route('posts.byAuthor', $author->name)
                                    : route('post.all')) }}"
                            method="GET" class="search-form">
                            <div class="search-input-wrapper">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control search-input"
                                    placeholder="Cari dokumen berdasarkan judul, deskripsi, atau kategori..."
                                    autocomplete="off">

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
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="ud-blog-desc">
                                    {!! Str::words($post->content, 11, '...') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">
                            <i class="mdi mdi-file-search-outline fs-2"></i><br>
                            Tidak ada dokumen
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

</x-landingpage.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.querySelector('.search-input');
        const resetBtn = document.getElementById('resetSearch');
        const suggestionBox = document.querySelector('.search-suggestions');
        const categorySlug = "{{ $category->slug ?? '' }}";

        input.addEventListener('input', () => {
            resetBtn.classList.toggle('d-none', input.value === '');
            fetchSuggestions(input.value);
        });

        resetBtn.addEventListener('click', () => {
            input.value = '';
            resetBtn.classList.add('d-none');
            suggestionBox.classList.add('d-none');
            input.focus();
        });

        function fetchSuggestions(query) {
            if (query.length < 2) {
                suggestionBox.classList.add('d-none');
                return;
            }

            // Gunakan slug kategori jika ada
            let url = "{{ route('post.suggestions') }}";
            if (typeof categorySlug !== 'undefined' && categorySlug) {
                url = `/posts/suggestions/${categorySlug}`;
            }

            fetch(`${url}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionBox.classList.add('d-none');
                        return;
                    }

                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                    <div class="d-flex flex-column">
                        <span><i class="mdi mdi-file-document-outline"></i> ${item.title}</span>
                        <small class="text-muted ms-4">${item.created_at}</small>
                    </div>`;
                        li.addEventListener('click', () => {
                            input.value = item.title;
                            suggestionBox.classList.add('d-none');
                            input.closest('form').submit();
                        });
                        suggestionBox.appendChild(li);
                    });

                    suggestionBox.classList.remove('d-none');
                })
                .catch(() => suggestionBox.classList.add('d-none'));
        }

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-wrapper')) {
                suggestionBox.classList.add('d-none');
            }
        });
    });
</script>
