<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\M_Pengujian;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\M_Support;
use App\Models\M_Nilai_Kombinasi;


class C_Apriori extends Controller
{
    public function setupPerhitunganApriori()
    {
        return view('pages.setup');
    }

    public function prosesAnalisaApriori(Request $request)
    {
        $minSupp = $request->support;
        $minConfidence = $request->confidence;
        // insert data pengujian
        $kdPengujian = Str::uuid();
        $pengujian = new M_Pengujian();
        $pengujian->kd_pengujian = $kdPengujian;
        $pengujian->nama_penguji = $request->nama;
        $pengujian->min_supp = $minSupp;
        $pengujian->min_confidence = $minConfidence;
        $totalProduk = Product::count();
        // cari nilai support
        $dataProduk = Product::all();
        foreach ($dataProduk as $produk) {
            $kdProduk = $produk->kd_produk;
            $totalTransaksi = TransactionDetail::where('kd_barang', $kdProduk)->count();
            $nSupport = ($totalTransaksi / $totalProduk) * 100;
            $supp = new M_Support();
            $supp->kd_pengujian = $kdPengujian;
            $supp->kd_produk = $kdProduk;
            $supp->support = $nSupport;
            $supp->save();
        }
        // kombinasi 2 item set
        $qProdukA = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
        foreach ($qProdukA as $qProdA) {
            $kdProdukA = $qProdA->kd_produk;
            $qProdukB = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
            foreach ($qProdukB as $qProdB) {
                $kdProdukB = $qProdB->kd_produk;
                $jumB = M_Nilai_Kombinasi::where('kd_barang_a', $kdProdukB)->count();
                if ($jumB > 0) {
                } else {
                    if ($kdProdukA == $kdProdukB) {
                    } else {
                        $kdKombinasi = Str::uuid();
                        $nk = new M_Nilai_Kombinasi();
                        $nk->kd_pengujian = $kdPengujian;
                        $nk->kd_kombinasi = $kdKombinasi;
                        $nk->kd_barang_a = $kdProdukA;
                        $nk->kd_barang_b = $kdProdukB;
                        $nk->jumlah_transaksi = 0;
                        $nk->support = 0;
                        $nk->save();
                    }
                }
            }
        }

        // kombinasi 2 itemset phase 2
        $nilaiKombinasi = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->get();
        $no = 1;
        foreach ($nilaiKombinasi as $nk) {
            $kdKombinasi = $nk->kd_kombinasi;
            $kdBarangA = $nk->kd_barang_a;
            $kdBarangB = $nk->kd_barang_b;

            // cari total transaksi
            $dataFaktur = TransactionDetail::distinct()->get(['code']);
            $fnTransaksi = 0;
            foreach ($dataFaktur as $faktur) {
                $noFaktur = $faktur->code;
                $qBonTransaksiA = TransactionDetail::where('code', $noFaktur)->where('kd_barang', $kdBarangA)->count();
                $qBonTransaksiB = TransactionDetail::where('code', $noFaktur)->where('kd_barang', $kdBarangB)->count();
                if ($qBonTransaksiA == 1 && $qBonTransaksiB == 1) {
                    $fnTransaksi++;
                }
            }
            $support = ($fnTransaksi / $totalProduk) * 100;
            M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->where('kd_kombinasi', $kdKombinasi)->update([
                'jumlah_transaksi' => $fnTransaksi,
                'support' => $support
            ]);
        }

        $pengujian->save();
        $dr = ['status' => 'sukses', 'kdPengujian' => $kdPengujian];
        return \Response::json($dr);
    }

    public function hasilAnalisa(Request $request, $kdPengujian)
    {
        $dataPengujian = M_Pengujian::where('kd_pengujian', $kdPengujian)->first();
        $dataSupportProduk = M_Support::where('kd_pengujian', $kdPengujian)->get();
        $dataMinSupp = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_supp)->get();
        $dataKombinasiItemset = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->get();
        $dataMinConfidence = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_confidence)->get();
        $totalProduk = Product::count();
        // dd($dataSupportProduk);
        $dr = [
            'dataSupport' => $dataSupportProduk,
            'totalProduk' => $totalProduk,
            'dataPengujian' => $dataPengujian,
            'dataMinSupport' => $dataMinSupp,
            'dataKombinasiItemset' => $dataKombinasiItemset,
            'dataMinConfidence' => $dataMinConfidence,
            'kdPengujian' => $kdPengujian
        ];
        return view('pages.hasilAnalisa', $dr);
    }
}
