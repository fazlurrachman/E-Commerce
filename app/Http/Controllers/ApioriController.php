<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\M_Nilai_Kombinasi;
use App\Models\M_Pengujian;
use App\Models\M_Support;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApioriController extends Controller
{
    public function setupPerhitunganApriori()
    {
        return view('pages.setup');
    }

    public function prosesAnalisaApriori(Request $request)
    {
        $nama = $request->nama;
        $minSupp = $request->support;
        $minConfidence = $request->confidence;
        // insert data pengujian
        $kdPengujian = Str::uuid();
        $pengujian = new M_Pengujian();
        $pengujian->kd_pengujian = $kdPengujian;
        $pengujian->nama_penguji = $nama;
        $pengujian->min_supp = $minSupp;
        $pengujian->min_confidence = $minConfidence;
        $totalProduk = Product::count();

        // cari nilai support
        $dataProduk = Product::all();
        foreach ($dataProduk as $produk) {
            $kdProduk = $produk->id;
            $totalTransaksi = TransactionDetail::where('products_id', $kdProduk)->count();
            $nSupport = ($totalTransaksi / $totalProduk) * 100;
            $supp = new M_Support();
            $supp->kd_pengujian = $kdPengujian;
            $supp->kd_produk = $kdProduk;
            $supp->support = $nSupport;
            $supp->save();
        }

        // kombinasi 2 item set
        $qProdukA = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->orderBy('kd_produk')->get();
        foreach ($qProdukA as $qProdA) {
            $kdProdukA = $qProdA->kd_produk;
            $qProdukB = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
            foreach ($qProdukB as $qProdB) {
                $kdProdukB = $qProdB->kd_produk;
                $jumB = M_Nilai_Kombinasi::where('kd_barang_a', $kdProdukB)->count();

                if ($kdProdukA != $kdProdukB && $jumB <= 0) {
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

        // kombinasi 2 itemset phase 2
        $nilaiKombinasi = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->get();
        $no = 1;
        foreach ($nilaiKombinasi as $nk) {
            $kdKombinasi = $nk->kd_kombinasi;
            $kdBarangA = $nk->kd_barang_a;
            $kdBarangB = $nk->kd_barang_b;

            // cari total transaksi
            $dataFaktur = TransactionDetail::distinct()->get(['transaction_id']);
            $fnTransaksi = 0;
            foreach ($dataFaktur as $faktur) {
                $noFaktur = $faktur->transaction_id;
                $qBonTransaksiA = TransactionDetail::where('transaction_id', $noFaktur)->where('products_id', $kdBarangA)->count();
                $qBonTransaksiB = TransactionDetail::where('transaction_id', $noFaktur)->where('products_id', $kdBarangB)->count();
                if ($qBonTransaksiA == 1 && $qBonTransaksiB == 1) {
                    $fnTransaksi++;
                }
            }
            $support = ($fnTransaksi / $totalProduk) * 100;
            M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->where('kd_kombinasi', $kdKombinasi)->update([
                'jumlah_transaksi' => $fnTransaksi,
                'support' => $support,
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
        $dr = [
            'dataSupport' => $dataSupportProduk,
            'totalProduk' => $totalProduk,
            'dataPengujian' => $dataPengujian,
            'dataMinSupport' => $dataMinSupp,
            'dataKombinasiItemset' => $dataKombinasiItemset,
            'dataMinConfidence' => $dataMinConfidence,
            'kdPengujian' => $kdPengujian,
        ];
        return view('pages.hasilAnalisa', $dr);
    }

    public function hasilRekom(Request $request, $kdPengujian)
    {
        $dataPengujian = M_Pengujian::where('kd_pengujian', $kdPengujian)->first();
        $dataSupportProduk = M_Support::where('kd_pengujian', $kdPengujian)->get();
        $dataMinSupp = M_Support::where('kd_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_supp)->get();
        $dataKombinasiItemset = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->get();
        $dataMinConfidence = M_Nilai_Kombinasi::where('kd_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_confidence)->get();
        $totalProduk = Product::count();
        $dr = [
            'dataSupport' => $dataSupportProduk,
            'totalProduk' => $totalProduk,
            'dataPengujian' => $dataPengujian,
            'dataMinSupport' => $dataMinSupp,
            'dataKombinasiItemset' => $dataKombinasiItemset,
            'dataMinConfidence' => $dataMinConfidence,
            'kdPengujian' => $kdPengujian,
        ];
        return view('pages.hasilRekom', $dr);
    }
}
