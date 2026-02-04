@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Welcome Banner -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-white mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                                <p class="mb-0 text-white-50">
                                    Sistem Manajemen Inventaris & Peminjaman Barang
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h6 class="text-white mb-1">{{ now()->format('d F Y') }}</h6>
                                <small class="text-white-50">{{ now()->format('H:i') }} WIB</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="row">
            <!-- Total Barang -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-package bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block mb-1">Total Barang</span>
                                <h3 class="card-title mb-0">{{ $totalBarang }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class='bx bx-time-five bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block mb-1">Sedang Dipinjam</span>
                                <h3 class="card-title mb-0">{{ $peminjamanAktif }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Kategori -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-category bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block mb-1">Kategori</span>
                                <h3 class="card-title mb-0">{{ $totalKategori }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Lokasi -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-map bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block mb-1">Lokasi</span>
                                <h3 class="card-title mb-0">{{ $totalLokasi }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Peminjaman & Kondisi Barang -->
        <div class="row">
            <!-- Status Peminjaman -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Status Peminjaman</h5>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 mb-3">
                                <div class="p-3 rounded bg-label-warning">
                                    <i class='bx bx-time-five bx-lg mb-2'></i>
                                    <h4 class="mb-1">{{ $peminjamanAktif }}</h4>
                                    <small>Dipinjam</small>
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="p-3 rounded bg-label-success">
                                    <i class='bx bx-check-circle bx-lg mb-2'></i>
                                    <h4 class="mb-1">{{ $peminjamanSelesai }}</h4>
                                    <small>Dikembalikan</small>
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="p-3 rounded bg-label-danger">
                                    <i class='bx bx-error-circle bx-lg mb-2'></i>
                                    <h4 class="mb-1">{{ $peminjamanTerlambat }}</h4>
                                    <small>Terlambat</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total Peminjaman</span>
                            <h4 class="mb-0">{{ $totalPeminjaman }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kondisi Barang -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Kondisi Barang</h5>
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-3 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class='bx bx-check-circle'></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Baik</h6>
                                        <small class="text-muted">Kondisi sempurna</small>
                                    </div>
                                    <div class="user-progress">
                                        <h5 class="mb-0">{{ $barangBaik }}</h5>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-3 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class='bx bx-error'></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Rusak Ringan</h6>
                                        <small class="text-muted">Perlu perbaikan ringan</small>
                                    </div>
                                    <div class="user-progress">
                                        <h5 class="mb-0">{{ $barangRusakRingan }}</h5>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-3 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class='bx bx-x-circle'></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Rusak Berat</h6>
                                        <small class="text-muted">Tidak dapat digunakan</small>
                                    </div>
                                    <div class="user-progress">
                                        <h5 class="mb-0">{{ $barangRusakBerat }}</h5>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class='bx bx-help-circle'></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Hilang</h6>
                                        <small class="text-muted">Tidak ditemukan</small>
                                    </div>
                                    <div class="user-progress">
                                        <h5 class="mb-0">{{ $barangHilang }}</h5>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Populer & Stok Rendah -->
        <div class="row">
            <!-- Kategori Populer -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Kategori Populer</h5>
                        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($kategoriPopuler->count() > 0)
                            <ul class="p-0 m-0">
                                @foreach($kategoriPopuler as $index => $kategori)
                                    <li class="d-flex mb-3 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded 
                                                @if($index == 0) bg-label-primary
                                                @elseif($index == 1) bg-label-success
                                                @elseif($index == 2) bg-label-info
                                                @else bg-label-secondary
                                                @endif">
                                                <i class='bx bx-category'></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $kategori->nama_kategori }}</h6>
                                                <small class="text-muted">{{ $kategori->barang_count }} barang</small>
                                            </div>
                                            <div class="user-progress">
                                                <span class="badge bg-label-primary">#{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-category bx-lg text-muted mb-2'></i>
                                <p class="text-muted mb-0">Belum ada kategori</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alert Stok Rendah -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Peringatan Stok</h5>
                        @if($barangStokRendah > 0)
                            <span class="badge bg-danger">{{ $barangStokRendah }} Item</span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($barangStokRendah > 0)
                            <div class="alert alert-warning mb-3">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-error-circle bx-sm me-2'></i>
                                    <div>
                                        <strong>Perhatian!</strong> Ada {{ $barangStokRendah }} barang dengan stok rendah (< 5 unit)
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('barang.index') }}" class="btn btn-warning w-100">
                                <i class='bx bx-search-alt me-1'></i> Lihat Barang Stok Rendah
                            </a>
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-check-circle bx-lg text-success mb-2'></i>
                                <h6 class="text-success">Semua Stok Aman</h6>
                                <p class="text-muted mb-0">Tidak ada barang dengan stok rendah</p>
                            </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Quick Actions</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('barang.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class='bx bx-plus me-1'></i> Tambah Barang Baru
                            </a>
                            <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-outline-success">
                                <i class='bx bx-transfer me-1'></i> Buat Peminjaman Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman & Barang Terbaru -->
        <div class="row">
            <!-- Peminjaman Terbaru -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Peminjaman Terbaru</h5>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($peminjamanTerbaru->count() > 0)
                            <ul class="p-0 m-0">
                                @foreach($peminjamanTerbaru as $peminjaman)
                                    <li class="d-flex mb-3 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded 
                                                @if($peminjaman->status == 'dipinjam') bg-label-warning
                                                @elseif($peminjaman->status == 'dikembalikan') bg-label-success
                                                @else bg-label-danger
                                                @endif">
                                                <i class='bx bx-user'></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $peminjaman->nama_peminjam }}</h6>
                                                <small class="text-muted">{{ $peminjaman->kode_peminjaman }} • {{ $peminjaman->tanggal_pinjam }}</small>
                                            </div>
                                            <div class="user-progress">
                                                <span class="badge 
                                                    @if($peminjaman->status == 'dipinjam') bg-warning
                                                    @elseif($peminjaman->status == 'dikembalikan') bg-success
                                                    @else bg-danger
                                                    @endif">
                                                    {{ ucfirst($peminjaman->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-transfer bx-lg text-muted mb-2'></i>
                                <p class="text-muted mb-0">Belum ada peminjaman</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Barang Terbaru -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Barang Terbaru</h5>
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($barangTerbaru->count() > 0)
                            <ul class="p-0 m-0">
                                @foreach($barangTerbaru as $barang)
                                    <li class="d-flex mb-3 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            @if($barang->foto)
                                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="rounded">
                                            @else
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class='bx bx-package'></i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $barang->nama_barang }}</h6>
                                                <small class="text-muted">{{ $barang->kategori->nama_kategori ?? '-' }} • {{ $barang->jumlah }} {{ $barang->satuan }}</small>
                                            </div>
                                            <div class="user-progress">
                                                <span class="badge 
                                                    @if($barang->kondisi == 'baik') bg-success
                                                    @elseif($barang->kondisi == 'rusak_ringan') bg-warning
                                                    @elseif($barang->kondisi == 'rusak_berat') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $barang->kondisi)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-package bx-lg text-muted mb-2'></i>
                                <p class="text-muted mb-0">Belum ada barang</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection