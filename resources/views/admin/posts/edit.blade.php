<x-admin.layout title="{{ $title }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Carousel</h4>
                    {{-- Form Update --}}
                    <form action="{{ route('posts-management.update', $post->id) }}" id="postForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Kolom kiri --}}
                            <div class="col-md-6">
                                {{-- Kategori --}}
                                <div class="mb-3">
                                    <label for="post_category_id" class="col-form-label">Kategori</label>
                                    <select name="post_category_id" id="post_category_id"
                                        class="form-select @error('post_category_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('post_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Title --}}
                                <div class="mb-3">
                                    <label for="title" class="col-form-label">Judul</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Masukkan judul" value="{{ old('title', $post->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="mb-3">
                                    <label for="slug" class="col-form-label">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        placeholder="Masukkan slug" value="{{ old('slug', $post->slug) }}" required>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Publikasi --}}
                                <div class="mb-3">
                                    <label for="is_published" class="col-form-label">Status Publikasi</label>
                                    <select name="is_published" id="is_published"
                                        class="form-select @error('is_published') is-invalid @enderror" required>
                                        <option value="0"
                                            {{ old('is_published', $post->is_published) == 0 ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="1"
                                            {{ old('is_published', $post->is_published) == 1 ? 'selected' : '' }}>
                                            Publik</option>
                                    </select>
                                    @error('is_published')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">

                                {{-- Tanggal Pelaksanaan --}}
                                <div class="mb-3">
                                    <label for="date" class="col-form-label">Tanggal Dokumen</label>
                                    <input type="date" name="date" id="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date', $post->date) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Thumbnail --}}
                                <label for="thumbnail" class="col-form-label">Thumbnail</label>
                                <div class="mb-3">
                                    @if ($post->thumbnail)
                                        <img id="previewThumbnail" src="{{ asset('storage/' . $post->thumbnail) }}"
                                            class="img-thumbnail mb-2" width="200">
                                    @else
                                        <img id="previewThumbnail" src="" class="img-thumbnail mb-2"
                                            width="200" style="display:none;">
                                    @endif
                                    <small id="thumbFileInfo" class="text-muted mb-2"
                                        style="font-size:13px; display:none;"></small>

                                    <input type="file" name="thumbnail" id="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*"
                                        data-preview="previewThumbnail" data-info="thumbFileInfo">
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gambar --}}
                                <label for="image" class="col-form-label">Gambar</label>
                                <div class="mb-3">
                                    @if ($post->image)
                                        <img id="previewImageMain" src="{{ asset('storage/' . $post->image) }}"
                                            class="img-thumbnail mb-2" width="200">
                                    @else
                                        <img id="previewImageMain" src="" class="img-thumbnail mb-2"
                                            width="200" style="display:none;">
                                    @endif
                                    <small id="imgFileInfoMain" class="text-muted mb-2"
                                        style="font-size:13px; display:none;"></small>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*"
                                        data-preview="previewImageMain" data-info="imgFileInfoMain">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                            {{-- Konten --}}
                            <div class="mb-3">
                                <label for="content" class="col-form-label">Konten</label>
                                <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div class="modal-footer gap-2">
                            <a href="{{ route('posts-management.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin.layout>

<script>
    initTiny('#content');
</script>
