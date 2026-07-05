@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="card shadow">
    <div class="card-header bg-info">
        <h3 class="card-title text-white">
            <i class="fas fa-users"></i> Manajemen User
        </h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->isAdmin())
                            <span class="badge badge-danger">Admin</span>
                        @else
                            <span class="badge badge-secondary">User</span>
                        @endif
                    </td>
                    <td>
                        <a href="/users/edit/{{ $user->id }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        @if($user->id !== auth()->id())
                            <form action="/users/delete/{{ $user->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada data user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
