<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Postingan</h4>

                    <!-- Button trigger modal -->
                    <a href="{{ route('posts-management.create') }}" class="btn btn-primary mb-3 ">
                        Tambah Postingan
                    </a>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Author</th>
                                <th>Kategori</th>
                                <th>Title</th>
                                <th>Thumbnail</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->author?->name ?? '-' }}</td>
                                    <td>{{ $post->category?->name ?? '-' }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="post-img"
                                            width="50" height="50"
                                            style="object-fit: cover; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="post-img" width="50"
                                            height="50"
                                            style="object-fit: cover; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                                    </td>
                                    <td>
                                        @if ($post->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('posts-management.edit', $post) }}"
                                                class="btn btn-success btn-edit-post d-flex ">
                                                <i class='ri-edit-box-line'></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="/posts-management/{{ $post->id }}" method="POST"
                                                class="m-0 delete-btn">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-danger d-flex delete-btn">
                                                    <i class='ri-delete-bin-7-line'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row-->
</x-admin.layout>
