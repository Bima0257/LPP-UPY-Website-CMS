<x-admin.layout title="{{ $title }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Carousel</h4>
                    <form action="{{ route('carousels-management.store') }}" id="carouselForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- Kolom kiri --}}
                            <div class="col-md-6">
                                {{-- Title --}}
                                <div class="mb-3">
                                    <label for="title" class="col-form-label">Judul</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Masukkan judul carousel" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="btn_link" class="form-label">Link Tombol</label>
                                    <input type="url" name="btn_link" id="btn_link"
                                        class="form-control @error('btn_link') is-invalid @enderror"
                                        placeholder="link tombol show more">
                                    @error('btn_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            {{-- Kolom kanan --}}
                            <div class="col-md-6">
                                {{-- Gambar --}}
                                <div class="mb-3">
                                    <label for="image" class="col-form-label">Gambar Carousel</label>
                                    <div>
                                        <img id="preview" src="" alt="Preview Gambar"
                                            class="img-thumbnail mb-2" width="200" style="display:none;">
                                        <small id="fileSizeInfo" class="mb-2 text-muted"
                                            style="display:none; font-size:13px;"></small>

                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror" accept="image/*"
                                            data-preview="preview" data-info="fileSizeInfo">
                                        <small class="text-danger">Upload gambar (jpg, png, max 1MB)</small>

                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label for="description" class="col-form-label">Deskripsi</label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi singkat">{{ old('description') }}</textarea>
                                @error('description')
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
                                    <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Publik
                                    </option>
                                </select>
                                @error('is_published')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div class="modal-footer gap-2">
                            <a href="/carousels-management" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin.layout>

<script>
    tinymce.init({
        selector: '#description',
        menubar: false,
        plugins: 'wordcount',
        branding: false,
        statusbar: false,
        forced_root_block: '', // agar tidak auto-wrap dengan <p>
        valid_elements: 'strong,em,span,b,i,u', // hanya izinkan tag dasar teks
        invalid_elements: 'img,table,a,video,audio,iframe,div',
        placeholder: 'Masukkan deskripsi singkat...',
    });
</script>
