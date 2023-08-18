<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_Nilai_Kombinasi;
use App\Models\M_Pengujian;
use App\Models\M_Support;
use App\Models\Product;

class show extends Controller
{


    public function rekom()
    {
        $dataPengujian = M_Pengujian::all();
        $dr = ['dataPengujian' => $dataPengujian];
        return view('pages.rekom', $dr);
    }
}
