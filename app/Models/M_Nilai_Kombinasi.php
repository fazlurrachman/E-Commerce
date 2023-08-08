<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Nilai_Kombinasi extends Model
{
    use HasFactory;

    protected $table = "tbl_nilai_kombinasi";

    protected $fillable = [
        'kd_pengujian',
        'kd_kombinasi',
        'kd_barang_a',
        'kd_barang_b',
        'jumlah_transaksi',
        'support'
    ];

    public function dataProduk($kdProduk)
    {
        return Product::where('kd_produk', $kdProduk)->first();
    }
}
