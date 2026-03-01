<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center mb-3">Daftar Menu Navigasi</h4>


                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ $menu->home }}</th>
                                    <th>{{ $menu->about }}</th>
                                    <th>{{ $menu->information }}</th>
                                    <th>{{ $menu->news }}</th>
                                    <th>{{ $menu->service }}</th>
                                    <th>{{ $menu->team }}</th>
                                    <th>{{ $menu->contact }}</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $menu->home }}</td>
                                    <td>{{ $menu->about }}</td>
                                    <td>{{ $menu->information }}</td>
                                    <td>{{ $menu->news }}</td>
                                    <td>{{ $menu->service }}</td>
                                    <td>{{ $menu->team }}</td>
                                    <td>{{ $menu->contact }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit-menu"
                                            data-id="{{ $menu->id }}" data-bs-toggle="modal"
                                            data-bs-target="#modal">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="card-title-desc text-info">Klik tombol edit untuk memperbarui nama menu pada navbar
                        website.</p>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Menu -->
    <div id="modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Menu Navbar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="menuForm" method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="home" class="form-label">Menu 1</label>
                                <input type="text" name="home" id="home" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="about" class="form-label">Menu 2</label>
                                <input type="text" name="about" id="about" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="information" class="form-label">Menu 3</label>
                                <input type="text" name="information" id="information" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="news" class="form-label">Menu 4</label>
                                <input type="text" name="news" id="news" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="team" class="form-label">Menu 5</label>
                                <input type="text" name="team" id="team" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Menu 6</label>
                                <input type="text" name="service" id="service" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Menu 7</label>
                                <input type="text" name="contact" id="contact" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-admin.layout>

<!-- Script -->
<script>
    $(document).ready(function() {
        // Klik tombol edit
        $(document).on('click', '.btn-edit-menu', function() {
            const id = $(this).data('id');
            const form = $('#menuForm');

            // Ganti action form sesuai id
            form.attr('action', '/menu/' + id);

            // Ambil data dari server (AJAX)
            $.ajax({
                url: '/menu/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    // Isi form modal dengan data
                    $('#home').val(data.home);
                    $('#about').val(data.about);
                    $('#information').val(data.information);
                    $('#news').val(data.news);
                    $('#team').val(data.team);
                    $('#service').val(data.service);
                    $('#contact').val(data.contact);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Gagal!', 'Tidak dapat memuat data menu.', 'error');
                }
            });
        });

    });
</script>
