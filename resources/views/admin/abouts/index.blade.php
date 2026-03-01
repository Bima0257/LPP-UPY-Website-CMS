<x-admin.layout title="{{ $title }}">
    <div class="user-profile-page">
        <div class="card radius-15">
            <div class="card-body">
                @if ($about)
                    <div class="row">
                        <!-- Logo dan Informasi Singkat -->
                        <div class="col-12 col-lg-7 border-end">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                        <!-- Logo -->
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . ($about->favicon ?? 'default-logo.png')) }}"
                                                class="rounded-circle shadow-sm border" width="120" height="120"
                                                alt="{{ $about->name ?? 'Logo Organisasi' }}">
                                        </div>

                                        <!-- Info Organisasi -->
                                        <div class="grow text-center text-md-start">
                                            <h4 class="mb-1 fw-bold">{{ $about->name ?? 'Nama Organisasi' }}</h4>
                                            <div class="text-muted mb-3" style="text-align: justify;">
                                                {!! $about->description ?? 'Deskripsi singkat organisasi belum ditambahkan.' !!}
                                            </div>

                                            <ul class="list-unstyled mb-0 small">
                                                <li class="mb-1">
                                                    <i class="ri-map-pin-line text-primary me-1"></i>
                                                    {{ $about->address ?? '-' }}
                                                </li>
                                                <li class="mb-1">
                                                    <i class="ri-mail-line text-primary me-1"></i>
                                                    {{ $about->email ?? '-' }}
                                                </li>
                                                <li>
                                                    <i class="ri-phone-line text-primary me-1"></i>
                                                    {{ $about->phone ?? '-' }}
                                                </li>
                                                <li>
                                                    <i class="ri-instagram-line text-danger me-1"></i>
                                                    @if (!empty($about->instagram_link))
                                                        <a href="{{ $about->instagram_link }}" target="_blank"
                                                            class="text-decoration-none text-dark">
                                                            Instagram LPP
                                                        </a>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </li>

                                                <li>
                                                    <i class="ri-youtube-line text-danger me-1"></i>
                                                    @if (!empty($about->youtube_link))
                                                        <a href="{{ $about->youtube_link }}" target="_blank"
                                                            class="text-decoration-none text-dark">
                                                            Youtube LPP
                                                        </a>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Logo besar -->
                        <div class="col-12 col-lg-5 text-center">
                            @if ($about->image)
                                <img src="{{ asset('storage/' . $about->image) }}"
                                    class="img-fluid rounded shadow-sm mt-3 mt-lg-0" alt="Logo Besar">
                            @else
                                <img src="{{ asset('assets/images/placeholder.png') }}"
                                    class="img-fluid rounded shadow-sm mt-3 mt-lg-0" alt="No Logo">
                            @endif
                        </div>
                    </div>

                    <!-- Tab Konten -->
                    <ul class="nav nav-pills mt-4">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#Tentang">
                                <span class="p-tab-name">Tentang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#VisiMisi">
                                <span class="p-tab-name">Visi, Misi dan Tujuan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#EditProfil">
                                <span class="p-tab-name">Edit Profil</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Tab Tentang -->
                        <div class="tab-pane fade show active" id="Tentang">
                            <div class="card shadow-none border mb-0 radius-15">
                                <div class="card-body">
                                    <h5 class="mb-3">Tentang LPP</h5>
                                    <div style="text-align: justify;">{!! $about->description ?? 'Belum ada deskripsi lPP.' !!}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Visi Misi -->
                        <div class="tab-pane fade" id="VisiMisi">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <div class="card shadow-none border mb-0 radius-15">
                                        <div class="card-body">
                                            <h5 class="mb-3 text-primary">Visi</h5>
                                            <div style="text-align: justify;">{!! $about->vision ?? 'Belum ada visi yang ditambahkan.' !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <div class="card shadow-none border mb-0 radius-15">
                                        <div class="card-body">
                                            <h5 class="mb-3 text-success">Misi</h5>
                                            <div style="text-align: justify;">{!! $about->mission ?? 'Belum ada misi yang ditambahkan.' !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <div class="card shadow-none border mb-0 radius-15">
                                        <div class="card-body">
                                            <h5 class="mb-3 text-success">Tujuan</h5>
                                            <div style="text-align: justify;">{!! $about->purpose ?? 'Belum ada Tujuan yang ditambahkan.' !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 📝 Tab Edit Profil -->
                        <div class="tab-pane fade" id="EditProfil">
                            <div class="card shadow-none border radius-15">
                                <div class="card-body">
                                    <h5 class="mb-3">Edit Profil LPP</h5>
                                    <form action="{{ route('about.update', $about->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <!-- Kolom Kiri -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $about->name) }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Alamat</label>
                                                    <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $about->address) }}</textarea>
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            value="{{ old('email', $about->email) }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone" class="form-label">Telepon</label>
                                                        <input type="text" name="phone"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            value="{{ old('phone', $about->phone) }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- 🔗 Link Sosial Media --}}
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="instagram_link"
                                                            class="form-label">Instagram</label>
                                                        <input type="url" name="instagram_link"
                                                            id="instagram_link"
                                                            class="form-control @error('instagram_link') is-invalid @enderror"
                                                            placeholder="https://www.instagram.com/nama_akun"
                                                            value="{{ old('instagram_link', $about->instagram_link) }}">
                                                        @error('instagram_link')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="youtube_link" class="form-label">YouTube</label>
                                                        <input type="url" name="youtube_link" id="youtube_link"
                                                            class="form-control @error('youtube_link') is-invalid @enderror"
                                                            placeholder="https://www.youtube.com/@nama_channel"
                                                            value="{{ old('youtube_link', $about->youtube_link) }}">
                                                        @error('youtube_link')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <label for="favicon" class="form-label">Favicon</label>
                                                <div class="mb-3">
                                                    @if ($about->favicon)
                                                        <img id="previewFavicon"
                                                            src="{{ asset('storage/' . $about->favicon) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewFavicon" src="" alt="Preview Gambar"
                                                            class="img-thumbnail mb-2" width="200">
                                                    @endif
                                                    <small id="imgFileInfoFavicon" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="favicon" class="form-control"
                                                        data-preview="previewFavicon" data-info="imgFileInfoFavicon">
                                                </div>


                                            </div>

                                            <!-- Kolom Kanan -->
                                            <div class="col-md-6">

                                                <label for="white_logo" class="form-label">Logo Putih</label>
                                                <div class="mb-3">
                                                    @if ($about->white_logo)
                                                        <img id="previewWhiteLogo"
                                                            src="{{ asset('storage/' . $about->white_logo) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewWhiteLogo" src=""
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @endif
                                                    <small id="imgFileInfoWhiteLogo" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="white_logo" class="form-control"
                                                        data-preview="previewWhiteLogo"
                                                        data-info="imgFileInfoWhiteLogo">
                                                </div>

                                                <label for="black_logo" class="form-label">Logo Hitam</label>
                                                <div class="mb-3">
                                                    @if ($about->black_logo)
                                                        <img id="previewBlackLogo"
                                                            src="{{ asset('storage/' . $about->black_logo) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewBlackLogo" src=""
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @endif
                                                    <small id="imgFileInfoBlackLogo" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="black_logo" class="form-control"
                                                        data-preview="previewBlackLogo"
                                                        data-info="imgFileInfoBlackLogo">
                                                </div>


                                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                                <div class="mb-3">
                                                    @if ($about->thumbnail)
                                                        <img id="previewThumbnail"
                                                            src="{{ asset('storage/' . $about->thumbnail) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewThumbnail" src=""
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @endif
                                                    <small id="imgFileInfoThumbnail" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="thumbnail" class="form-control"
                                                        data-preview="previewThumbnail"
                                                        data-info="imgFileInfoThumbnail">
                                                </div>

                                                <label for="image" class="form-label">Gambar Utama</label>
                                                <div class="mb-3">
                                                    @if ($about->image)
                                                        <img id="previewImage"
                                                            src="{{ asset('storage/' . $about->image) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewImage" src="" alt="Preview Gambar"
                                                            class="img-thumbnail mb-2" width="200">
                                                    @endif
                                                    <small id="imgFileInfoImage" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="image" class="form-control"
                                                        data-preview="previewImage" data-info="imgFileInfoImage">
                                                </div>


                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Deskripsi</label>
                                                <textarea name="description" id="description" rows="4"
                                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $about->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="vision" class="form-label">Visi</label>
                                                <textarea name="vision" id="vision" rows="3" class="form-control @error('vision') is-invalid @enderror">{{ old('vision', $about->vision) }}</textarea>
                                                @error('vision')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="mission" class="form-label">Misi</label>
                                                <textarea name="mission" id="mission" rows="3" class="form-control @error('mission') is-invalid @enderror">{{ old('mission', $about->mission) }}</textarea>
                                                @error('mission')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="purpose" class="form-label">Tujuan</label>
                                                <textarea name="purpose" id="purpose" rows="3" class="form-control @error('purpose') is-invalid @enderror">{{ old('purpose', $about->purpose) }}</textarea>
                                                @error('purpose')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="bx bx-save"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Jika Belum Ada Data -->
                    <div class="text-center py-5 text-muted">
                        <i class="bx bx-building display-4 text-secondary mb-3"></i>
                        <h5 class="fw-semibold">Belum ada data profil Lpp</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layout>

<script>
    initTiny('#description,#vision,#mission,#purpose');
</script>
