@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- User Hero Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-label-primary border-0">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-primary text-uppercase">Pusat Peminjaman Barang</h4>
                        <p class="mb-0 text-muted">Halo, <strong>{{ Auth::user()->name }}</strong>. Cari dan pinjam barang yang Anda butuhkan di sini.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjamCepat">
                            <i class='bx bx-plus-circle me-1'></i> Mulai Peminjaman Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Overview -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar bg-light-warning p-2 me-3">
                        <i class='bx bx-time fs-3 text-warning'></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Pinjaman Aktif Anda</h6>
                        <h4 class="mb-0 fw-bold">{{ $myActiveLoans ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar bg-light-success p-2 me-3">
                        <i class='bx bx-check-double fs-3 text-success'></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Barang Tersedia</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalItemsAvailable ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar bg-light-info p-2 me-3">
                        <i class='bx bx-grid-alt fs-3 text-info'></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Kategori Aset</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalCategories ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Available Items to Borrow -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between bg-white border-bottom py-3">
                    <h5 class="m-0 fw-bold text-dark"><i class='bx bx-package me-2 text-primary'></i>Barang Tersedia</h5>
                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Lihat Katalog</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($availableBarang as $barang)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($barang->foto)
                                                <img src="{{ asset('storage/' . $barang->foto) }}" class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="avatar avatar-sm bg-label-secondary me-3">
                                                    <span class="avatar-initial rounded"><i class='bx bx-box'></i></span>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="fw-semibold d-block text-dark">{{ $barang->nama_barang }}</span>
                                                <small class="text-muted">{{ $barang->kode_barang }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-info">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td>
                                        <span class="text-dark fw-bold">{{ $barang->jumlah }}</span> 
                                        <small class="text-muted">{{ $barang->satuan }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="selectForBorrow({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}')">
                                            Pinjam
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="{{ asset('assets/img/illustrations/empty-state.png') }}" class="mb-3" alt="Empty" width="120">
                                        <p class="text-muted">Tidak ada barang tersedia saat ini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Borrowings History -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="m-0 fw-bold text-dark"><i class='bx bx-history me-2 text-warning'></i>Pinjaman Saya</h5>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush">
                        @forelse($myPeminjaman as $p)
                        <div class="list-group-item px-0 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold text-dark">{{ $p->kode_peminjaman }}</h6>
                                <span class="badge bg-label-{{ $p->status == 'dipinjam' ? 'warning' : 'success' }} px-2 py-1">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class='bx bx-calendar-event me-1 text-primary'></i> {{ $p->tanggal_pinjam }}
                            </div>
                            <div class="bg-light p-2 rounded">
                                <p class="mb-0 small fw-semibold text-dark">
                                    @foreach($p->barang as $b)
                                        {{ $b->nama_barang }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class='bx bx-archive text-muted mb-2 display-6'></i>
                            <p class="text-muted small">Anda belum pernah meminjam barang.</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-light text-primary w-100">
                            Lihat Semua Riwayat <i class='bx bx-chevron-right'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pinjam Cepat -->
<div class="modal fade" id="modalPinjamCepat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="exampleModalLabel1">Formulir Peminjaman Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Peminjam</label>
                            <input type="text" name="nama_peminjam" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Peminjam</label>
                            <select name="jenis_peminjam" class="form-select" required>
                                <option value="Staf">Staf</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="divider text-start fw-bold mb-3">
                        <div class="divider-text">Detail Barang</div>
                    </div>

                    <div id="items-container">
                        <div class="row item-row mb-2 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label small">Barang</label>
                                <select name="barang_id[]" class="form-select select-barang" required>
                                    <option value="">Pilih barang...</option>
                                    @foreach($allBarang as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_barang }} (Stok: {{ $b->jumlah }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-label-danger btn-icon" onclick="addRow(this)">
                                    <i class='bx bx-plus'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addRow(btn) {
        const container = document.getElementById('items-container');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Reset values
        newRow.querySelector('select').value = '';
        newRow.querySelector('input').value = '1';
        
        // Change button to remove
        const button = newRow.querySelector('button');
        button.className = 'btn btn-label-danger btn-icon';
        button.innerHTML = "<i class='bx bx-trash'></i>";
        button.onclick = function() { this.closest('.row').remove(); };
        
        container.appendChild(newRow);
    }

    function selectForBorrow(id, name) {
        const modal = new bootstrap.Modal(document.getElementById('modalPinjamCepat'));
        const select = document.querySelector('.select-barang');
        select.value = id;
        modal.show();
    }
</script>
@endpush

<style>
    .bg-light-warning { background-color: #fff8e1; }
    .bg-light-success { background-color: #e8f5e9; }
    .bg-light-info { background-color: #e3f2fd; }
    .avatar {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    .btn-label-danger {
        background-color: #fce4e4;
        color: #f44336;
        border: none;
    }
    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
    }
</style>
@endsection

