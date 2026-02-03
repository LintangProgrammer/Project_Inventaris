@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Barang</h5>
                <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah Barang</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang as $i => $b)
                                <tr>
                                    <td>{{ $barang->firstItem() + $i }}</td>

                                    <!-- Foto -->
                                    <td style="width:80px">
                                        @if($b->foto)
                                            <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}"
                                                style="width:60px; height:60px; object-fit:cover;" class="rounded border" />
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>{{ $b->kode_barang }}</td>
                                    <td>{{ $b->nama_barang }}</td>
                                    <td>{{ optional($b->kategori)->nama_kategori ?? '-' }}</td>
                                    <td>{{ optional($b->lokasi)->nama_lokasi ?? '-' }}</td>

                                    <!-- Kondisi: badge warna sesuai status -->
                                    <td>
                                        @if($b->kondisi == 'baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($b->kondisi == 'rusak_ringan')
                                            <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                        @elseif($b->kondisi == 'rusak_berat')
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @elseif($b->kondisi == 'hilang')
                                            <span class="badge bg-secondary">Hilang</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <!-- Jumlah & Satuan -->
                                    <td>{{ number_format($b->jumlah) }} {{ !empty($b->satuan) ? $b->satuan : 'unit' }}</td>

                                    <!-- Aksi -->
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <a href="{{ route('barang.show', $b->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('barang.destroy', $b->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus barang ini?');" class="mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Belum ada data barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $barang->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection