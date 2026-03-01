<x-landingpage.layout title="{{ $title }}">
    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-banner-content">
                    <h1>{{ $post->title }}</h1>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Blog Details Start ====== -->
    <section class="ud-blog-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-blog-details-image">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="blog details" />
                        <div class="ud-blog-overlay">
                            <div class="ud-blog-overlay-content">
                                <div class="ud-blog-author">
                                    <img src="{{ $post->author && $post->author->avatar
                                        ? asset('storage/' . $post->author->avatar)
                                        : asset('assets_admin/images/default-profile.png') }}"
                                        alt="author" />

                                    <span class="me-3">
                                        By <a class="text-white"
                                            href="{{ route('posts.byAuthor', $post->author->name) }}">{{ $post->author->name ?? '-' }}
                                        </a>
                                    </span>

                                    <span>
                                        Kategori - <a class="text-white"
                                            href="{{ route('posts.byCategory', $post->category->slug) }}">{{ $post->category->name ?? '-' }}
                                        </a>
                                    </span>
                                </div>

                                <div class="ud-blog-meta">
                                    <p class="date">
                                        <i class="lni lni-calendar"></i>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="ud-blog-details-content">
                        <h2 class="ud-blog-details-title">
                            {{ $post->title }}
                        </h2>
                        <div class="ud-blog-details-content-body" style="text-align: justify;">
                            {!! $post->content !!}
                        </div>

                        <div class="ud-blog-details-action">
                            <ul class="ud-blog-tags">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $item)
                                        <li>
                                            <a
                                                href="{{ route('posts.category', $item->slug) }}">{{ $item->name }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <a href="#">Tidak ada Category</a>
                                    </li>
                                @endif

                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ud-blog-sidebar">

                        <div class="ud-articles-box">
                            <h3 class="ud-articles-box-title">Popular Articles</h3>
                            <ul class="ud-articles-list">
                                @if ($popularPosts->count() > 0)
                                    @foreach ($popularPosts as $popular)
                                        <li>
                                            <div class="ud-article-image">
                                                <img src="{{ $popular->author?->avatar
                                                    ? asset('storage/' . $popular->author->avatar)
                                                    : asset('assets_admin/images/default-profile.png') }}"
                                                    alt="{{ $popular->author?->name ?? 'Author' }}" />
                                            </div>
                                            <div class="ud-article-content">
                                                <h5 class="ud-article-title">
                                                    <a href="{{ route('post.show', $popular->slug) }}">
                                                        {{ Str::limit($popular->title, 60) }}
                                                    </a>
                                                </h5>
                                                <p class="ud-article-author">
                                                    {{ $popular->author?->name ?? 'Unknown Author' }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ====== Blog Details End ====== -->

    <!-- ====== Blog Start ====== -->
    <section class="ud-blog-grids ud-related-articles">
        <div class="container">
            <div class="row col-lg-12">
                <div class="ud-related-title">
                    <h2 class="ud-related-articles-title">Related Articles</h2>
                </div>
            </div>
            <div class="row">
                @if ($relatedPosts->count() > 0)
                    @foreach ($relatedPosts as $related)
                        <div class="col-lg-4 col-md-6">
                            <div class="ud-single-blog">
                                <div class="ud-blog-image">
                                    <a href="{{ route('post.show', $related->slug) }}">
                                        <img src="{{ $related->thumbnail ? asset('storage/' . $related->thumbnail) : asset('assets/images/blog/blog-default.jpg') }}"
                                            alt="{{ $related->title }}" />
                                    </a>
                                </div>
                                <div class="ud-blog-content">
                                    <span class="ud-blog-date">
                                        {{ $related->created_at->format('M d, Y') }}
                                    </span>
                                    <h3 class="ud-blog-title">
                                        <a href="{{ route('post.show', $related->slug) }}">
                                            {{ Str::limit($related->title, 60) }}
                                        </a>
                                    </h3>
                                    <p class="ud-blog-desc">
                                        {{ Str::limit(strip_tags($related->content), 100) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                @endif
            </div>

        </div>
    </section>
    <!-- ====== Blog End ====== -->

</x-landingpage.layout>
