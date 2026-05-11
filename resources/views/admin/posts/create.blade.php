<x-admin.layout title="{{ $title }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Post</h4>
                    <form action="{{ route('posts-management.store') }}" id="postForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- Kolom kiri --}}
                            <div class="col-md-6">

                                {{-- Judul --}}
                                <div class="mb-3">
                                    <label for="title" class="col-form-label">Judul</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Masukkan judul post" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div class="mb-3">
                                    <label for="post_category_id" class="col-form-label">Kategori</label>
                                    <select name="post_category_id" id="post_category_id"
                                        class="form-select @error('post_category_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('post_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Status Publikasi --}}
                                <div class="mb-3">
                                    <label for="is_published" class="col-form-label">Status Publikasi</label>
                                    <select name="is_published" id="is_published"
                                        class="form-select @error('is_published') is-invalid @enderror" required>
                                        <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>
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
                                        value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Thumbnail --}}
                                <div class="mb-3">
                                    <label for="thumbnail" class="col-form-label">Thumbnail</label>
                                    <div>
                                        <img id="previewThumbnail" src="" alt="Preview Thumbnail"
                                            class="img-thumbnail mb-2" width="200" style="display:none;">
                                        <small id="thumbFileInfo" class="text-muted mb-2"
                                            style="font-size:13px; display:none;"></small>

                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            accept="image/*" data-preview="previewThumbnail" data-info="thumbFileInfo">
                                        <small class="text-muted">Format: JPG, PNG, Max 5MB</small>
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Gambar Utama --}}
                                <div class="mb-3">
                                    <label for="image" class="col-form-label">Gambar Utama</label>
                                    <div>
                                        <img id="previewImage" src="" alt="Preview Gambar"
                                            class="img-thumbnail mb-2" width="200" style="display:none;">
                                        <small id="imgFileInfo" class="text-muted mb-2"
                                            style="font-size:13px; display:none;"></small>

                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror" accept="image/*"
                                            data-preview="previewImage" data-info="imgFileInfo">
                                        <small class="text-muted">Format: JPG, PNG, Max 5MB</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            {{-- Konten --}}
                            <div class="mb-3">
                                <label for="content" class="col-form-label">Konten</label>
                                <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Tulis isi konten">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div class="modal-footer gap-2">
                            <a href="/posts-management" class="btn btn-light">Batal</a>
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
