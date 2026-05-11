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
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Categories Section Start ====== -->
    <section class="ud-categories-section mt-5">
        <div class="container">
            <!-- ====== Section Title ====== -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Kategori</span>
                        <h2>Daftar Kategori Artikel</h2>
                        <p>Temukan topik yang menarik dan relevan sesuai minat Anda.</p>
                    </div>
                </div>
            </div>

            <!-- ====== Categories Grid ====== -->
            <div class="row justify-content-center">
                @forelse ($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="ud-category-card text-center p-4 h-100">
                            <a href="{{ route('posts.byCategory', $category->slug) }}">
                                <div class="ud-category-icon mb-3">
                                    <i class="ri-article-line fs-3"></i>
                                </div>
                            </a>
                            <h5 class="mb-2">
                                <a href="{{ route('posts.byCategory', $category->slug) }}"
                                    class="text-dark text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </h5>
                            <p class="mb-0">
                                {{ $category->posts_count ?? 0 }} Artikel
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">
                            <i class="mdi mdi-folder-remove-outline fs-2"></i><br>
                            Belum ada kategori tersedia.
                        </h5>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- ====== Categories Section End ====== -->

</x-landingpage.layout>
