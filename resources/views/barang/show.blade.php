@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Barang</h5>
                        <div>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                @if($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                                        class="img-fluid rounded" style="max-width:100%; max-height:400px; object-fit:cover;" />
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width:100%; height:300px;">
                                        <div class="text-muted text-center">
                                            <i class="bx bx-image" style="font-size:48px;"></i>
                                            <p>Tidak ada foto</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5">Kode Barang</dt>
                                    <dd class="col-sm-7"><strong>{{ $barang->kode_barang }}</strong></dd>

                                    <dt class="col-sm-5">Nama</dt>
                                    <dd class="col-sm-7"><strong>{{ $barang->nama_barang }}</strong></dd>

                                    <dt class="col-sm-5">Kategori</dt>
                                    <dd class="col-sm-7">
                                        @if($barang->kategori)
                                            <a
                                                href="{{ route('kategori.show', $barang->kategori->id) }}">{{ $barang->kategori->nama_kategori }}</a>
                                        @else
                                            -
                                        @endif
                                    </dd>

                                    <dt class="col-sm-5">Lokasi</dt>
                                    <dd class="col-sm-7">
                                        @if($barang->lokasi)
                                            <a
                                                href="{{ route('lokasi.show', $barang->lokasi->id) }}">{{ $barang->lokasi->nama_lokasi }}</a>
                                        @else
                                            -
                                        @endif
                                    </dd>

                                    <dt class="col-sm-5">Kondisi</dt>
                                    <dd class="col-sm-7">
                                        @php
                                            $kondisiColor = match ($barang->kondisi) {
                                                'baik' => 'success',
                                                'rusak_ringan' => 'warning',
                                                'rusak_berat' => 'danger',
                                                'hilang' => 'dark',
                                                default => 'secondary'
                                            };
                                            $kondisiLabel = match ($barang->kondisi) {
                                                'baik' => 'Baik',
                                                'rusak_ringan' => 'Rusak Ringan',
                                                'rusak_berat' => 'Rusak Berat',
                                                'hilang' => 'Hilang',
                                                default => $barang->kondisi
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $kondisiColor }}">{{ $kondisiLabel }}</span>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <hr>

                        <h6>Informasi Tambahan</h6>
                        <dl class="row">
                            <dt class="col-sm-3">Jumlah</dt>
                            <dd class="col-sm-9">{{ $barang->jumlah }} {{ $barang->satuan }}</dd>

                            <dt class="col-sm-3">Tanggal Beli</dt>
                            <dd class="col-sm-9">
                                @if($barang->tanggal_beli)
                                    {{ \Carbon\Carbon::parse($barang->tanggal_beli)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-3">Harga</dt>
                            <dd class="col-sm-9">
                                {{ $barang->harga ? 'Rp ' . number_format($barang->harga, 2, ',', '.') : '-' }}
                            </dd>

                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9">{{ $barang->deskripsi ?? '-' }}</dd>

                            <dt class="col-sm-3">Dibuat</dt>
                            <dd class="col-sm-9">{{ $barang->created_at->format('d M Y H:i') }}</dd>

                            <dt class="col-sm-3">Diperbarui</dt>
                            <dd class="col-sm-9">{{ $barang->updated_at->format('d M Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Riwayat Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        @if($barang->peminjaman->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($barang->peminjaman->take(5) as $p)
                                    <a href="{{ route('peminjaman.show', $p->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $p->nama_peminjam }}</strong>
                                                <div class="small text-muted">{{ $p->kode_peminjaman }}</div>
                                            </div>
                                            <span
                                                class="badge bg-{{ $p->status === 'dipinjam' ? 'warning' : 'success' }}">{{ ucfirst($p->status) }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            @if($barang->peminjaman->count() > 5)
                                <div class="mt-3 text-center">
                                    <small class="text-muted">+{{ $barang->peminjaman->count() - 5 }} peminjaman lainnya</small>
                                </div>
                            @endif
                        @else
                            <p class="text-muted text-center">Belum ada riwayat peminjaman.</p>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus barang ini? Tindakan ini tidak bisa dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100">Hapus Barang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection