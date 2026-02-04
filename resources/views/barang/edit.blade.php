@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class='bx bx-edit me-2'></i>Edit Barang</h5>
                <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class='bx bx-error-circle me-2'></i>Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Kode & Nama -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror"
                                value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                                value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori & Lokasi -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">Pilih kategori...</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <select name="lokasi_id" class="form-select @error('lokasi_id') is-invalid @enderror" required>
                                <option value="">Pilih lokasi...</option>
                                @foreach($lokasis as $l)
                                    <option value="{{ $l->id }}" {{ old('lokasi_id', $barang->lokasi_id) == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kondisi, Jumlah & Satuan -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ old('kondisi', $barang->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ old('kondisi', $barang->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                <option value="hilang" {{ old('kondisi', $barang->kondisi) == 'hilang' ? 'selected' : '' }}>Hilang</option>
                            </select>
                            @error('kondisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah', $barang->jumlah) }}" min="0" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror"
                                value="{{ old('satuan', $barang->satuan) }}" placeholder="misal: unit, pcs, dos" required>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Beli & Harga -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Beli</label>
                            <input type="date" name="tanggal_beli" class="form-control"
                                value="{{ old('tanggal_beli', $barang->tanggal_beli) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" step="0.01" name="harga" class="form-control"
                                value="{{ old('harga', $barang->harga) }}" placeholder="0.00">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                            placeholder="Tambahkan deskripsi barang...">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                    </div>

                    <!-- Foto -->
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        @if($barang->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                                    class="img-fluid rounded border" style="max-width:200px; max-height:200px; object-fit:cover;" />
                                <p class="small text-muted mt-1">Foto saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: jpg, png, jpeg. Maks 2MB. Kosongkan jika tidak ingin mengganti.</small>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection