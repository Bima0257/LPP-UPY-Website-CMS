<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center mb-3">Daftar Pesan Masuk</h4>

                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                        <!-- Delete -->
                        <form action="{{ route('admin.messages.deleteAll') }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm d-flex delete-btn">
                                <i class="ri-delete-bin-7-line me-2"></i> Hapus Semua
                            </button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Asal</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Pesan</th>
                                    <th>Dikirim</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($messages as $index => $msg)
                                    <tr data-id="{{ $msg->id }}"
                                        @if (!$msg->is_read) class="table-warning" @endif>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $msg->name }}</td>
                                        <td>{{ $msg->origin ?? '-' }}</td>
                                        <td>{{ $msg->email }}</td>
                                        <td>{{ $msg->phone }}</td>
                                        <td>{{ Str::limit($msg->message, 10, '...') }}</td>
                                        <td>{{ $msg->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @if ($msg->is_read)
                                                <span class="badge bg-success">Dibaca</span>
                                            @else
                                                <span class="badge bg-secondary">Belum Dibaca</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                <!-- Tombol -->
                                                <button type="button" class="btn btn-info btn-sm btn-show-message"
                                                    data-id="{{ $msg->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>


                                                <!-- Balas WA -->
                                                @php
                                                    $phone = \App\Helpers\PhoneHelper::normalize($msg->phone);
                                                @endphp


                                                @if ($phone)
                                                    <a href="https://wa.me/{{ $phone }}" target="_blank"
                                                        class="btn btn-success btn-sm">
                                                        <i class="ri-whatsapp-line"></i>
                                                    </a>
                                                @endif

                                                <!-- Delete -->
                                                <form action="{{ route('admin.messages.delete', $msg->id) }}"
                                                    method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm d-flex">
                                                        <i class="ri-delete-bin-7-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Belum ada pesan yang masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <p class="card-title-desc text-info mt-3">
                        Klik tombol <i class="fas fa-eye"></i> untuk membaca pesan. <br> Klik tombol <i
                            class="ri-whatsapp-line text-success"></i> untuk membalas pesan lewat Whats App
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Detail Pesan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="message-detail">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="label-line">
                                    <span class="label">Nama</span>
                                    <span class="colon">:</span>
                                    <span class="value" id="show_name"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="label-line">
                                    <span class="label">Asal</span>
                                    <span class="colon">:</span>
                                    <span class="value" id="show_origin"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="label-line">
                                    <span class="label">Email</span>
                                    <span class="colon">:</span>
                                    <span class="value text-primary text-decoration-underline" id="show_email"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="label-line">
                                    <span class="label">No HP</span>
                                    <span class="colon">:</span>
                                    <span class="value text-primary text-decoration-underline" id="show_phone"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="label-line align-items-start">
                                    <span class="label">Pesan</span>
                                    <span class="colon">:</span>
                                    <div class="value">
                                        <div id="show_message" class="message-box"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4 border-top pt-2 small text-muted">
                            <div class="col-12">
                                <div class="label-line">
                                    <span class="label">Dikirim pada</span>
                                    <span class="colon">:</span>
                                    <span class="value" id="waktu"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-end">
                    <button class="btn btn-secondary px-4" data-bs-dismiss="modal"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* ===== Modal Detail Styling ===== */
        .message-detail {
            font-size: 15px;
            line-height: 1.6;
        }

        .label-line {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .label {
            width: 130px;
            /* atur lebar agar titik dua sejajar */
            font-weight: 600;
            text-align: left;
        }

        .colon {
            width: 10px;
            text-align: right;
            display: inline-block;
        }

        .value {
            flex: 1;
            color: #333;
            font-weight: 500;
            word-wrap: break-word;
        }

        .message-box {
            background: #f8f9fa;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* ===== Table Highlight ===== */
        tr.table-warning {
            background-color: #fff8e1 !important;
            transition: background 0.3s ease;
        }

        tr.table-success {
            background-color: #e8f5e9 !important;
        }

        /* ===== Badge ===== */
        .badge {
            font-size: 0.75rem;
            padding: 6px 10px;
            border-radius: 8px;
        }
    </style>

</x-admin.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('viewMessageModal');
        const modal = new bootstrap.Modal(modalElement);

        document.querySelectorAll('.btn-show-message').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const row = this.closest('tr');

                fetch(`/messages/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        // Tampilkan data di modal
                        document.getElementById('show_name').textContent = data.name ?? '-';
                        document.getElementById('show_origin').textContent = data.origin ??
                            '-';
                        document.getElementById('show_email').textContent = data.email ??
                            '-';
                        document.getElementById('show_phone').textContent = data.phone ??
                            '-';
                        document.getElementById('show_message').textContent = data
                            .message ?? '-';
                        document.getElementById('waktu').textContent = new Date(data
                            .created_at).toLocaleString('id-ID', {
                            weekday: 'long',
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        modal.show();

                        // Realtime ubah tampilan tabel
                        const badge = row.querySelector('.badge');
                        badge.classList.remove('bg-secondary');
                        badge.classList.add('bg-success');
                        badge.textContent = 'Dibaca';
                        row.classList.remove('table-warning');
                    })
                    .catch(error => console.error(error));
            });
        });
    });
</script>
