<?php
// app/Models/Barang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'kondisi',
        'jumlah',
        'satuan',
        'tanggal_beli',
        'harga',
        'deskripsi',
        'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
    public function peminjaman()
{
    return $this->belongsToMany(
        Peminjaman::class,
        'detail_peminjamans'
    )->withPivot(
        'jumlah',
        'kondisi_sebelum',
        'kondisi_sesudah'
    )->withTimestamps();
}

}
