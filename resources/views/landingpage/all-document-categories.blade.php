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
                        <h1>{!! $title !!}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Document Categories Section Start ====== -->
    <section class="ud-categories-section mt-5">
        <div class="container">
            <!-- ====== Section Title ====== -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center mb-5">
                        <span>Kategori Dokumen</span>
                        <h2>Daftar Kategori Dokumen</h2>
                        <p>Jelajahi berbagai kategori dokumen yang tersedia sesuai kebutuhan Anda.</p>
                    </div>
                </div>
            </div>

            <!-- ====== Categories Grid ====== -->
            <div class="row justify-content-center">
                @forelse ($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="ud-category-card text-center p-4 h-100">
                            <a href="{{ route('document.category', $category->slug) }}">
                                <div class="ud-category-icon mb-3">
                                    <i class="ri-file-text-line fs-3"></i>
                                </div>
                            </a>
                            <h5 class="mb-2">
                                <a href="{{ route('document.category', $category->slug) }}"
                                    class="text-dark text-decoration-none">
                                    {!! $category->name !!}
                                </a>
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! Str::limit($category->description, 60) !!}
                            </p>

                            <button class="btn btn-link text-primary p-0 mb-3 see-more-btn text-center"
                                data-bs-toggle="modal" data-bs-target="#modalDesc{{ $category->id }}">
                                Lihat Selengkapnya
                            </button>

                        </div>
                    </div>
                    <div class="modal fade custom-modal" id="modalDesc{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Deskripsi Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p id="modal-description">{!! $category->description !!}</p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">
                            <i class="ri-folder-reduce-line fs-2"></i><br>
                            Belum ada kategori dokumen tersedia.
                        </h5>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- ====== Document Categories Section End ====== -->
</x-landingpage.layout>
