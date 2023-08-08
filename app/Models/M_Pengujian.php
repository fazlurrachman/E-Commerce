<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Pengujian extends Model
{
    use HasFactory;

    protected $table = "tbl_pengujian";

    protected $fillable = [
        'kd_pengujian',
        'nama_penguji',
        'min_supp',
        'min_confidence'
    ];

    public function totalPolaProduk($kdPengujian, $confidence)
    {
        return M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->where('support', '>=', $confidence)->count();
    }
}
