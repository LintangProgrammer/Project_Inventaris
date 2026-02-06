@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-user bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Total Pengguna</span>
                                <h4 class="card-title mb-0">{{ $users->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-user-check bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Admin</span>
                                <h4 class="card-title mb-0">{{ \App\Models\User::where('role', 'admin')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-user-circle bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">User Biasa</span>
                                <h4 class="card-title mb-0">{{ \App\Models\User::where('role', 'user')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class='bx bx-group me-2'></i>Manajemen Pengguna</h5>
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                    <i class='bx bx-plus me-1'></i>Tambah Pengguna
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search & Filter -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-search'></i></span>
                            <input type="text" class="form-control" id="searchUser" placeholder="Cari nama atau email...">
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select class="form-select" id="filterRole">
                            <option value="">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableUsers">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $i => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $i }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <i class='bx bx-envelope'></i> {{ $user->email }}
                                    </td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-success"><i class='bx bx-shield'></i> Admin</span>
                                        @else
                                            <span class="badge bg-info"><i class='bx bx-user'></i> User</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                            @if($user->id !== Auth::id() && $user->role !== 'admin')
                                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" class="mb-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class='bx bx-user bx-lg text-muted mb-2 d-block'></i>
                                        <p class="text-muted mb-2">Belum ada data pengguna.</p>
                                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                                            <i class='bx bx-plus me-1'></i>Tambah Pengguna Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchUser');
            const filterRole = document.getElementById('filterRole');
            const table = document.getElementById('tableUsers');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const roleValue = filterRole.value.toLowerCase();

                for (let row of rows) {
                    if (row.cells.length === 1) continue;

                    const nama = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const role = row.cells[3].textContent.toLowerCase();

                    const matchSearch = nama.includes(searchTerm) || email.includes(searchTerm);
                    const matchRole = !roleValue || role.includes(roleValue);

                    row.style.display = (matchSearch && matchRole) ? '' : 'none';
                }
            }

            searchInput.addEventListener('keyup', filterTable);
            filterRole.addEventListener('change', filterTable);
        });
    </script>
@endsection