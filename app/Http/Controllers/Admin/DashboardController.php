<?php

namespace App\Http\Controllers\Admin;

use App\Charts\MonthlyTransactionChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(MonthlyTransactionChart $chart)
    {
        $customer = User::count();
        $revenue = Transaction::sum('total_price');

        $transaction = Transaction::count();
        $transaction_best =  DB::table('transactions as a')
            ->join('transaction_details as b','a.id','=','b.transaction_id')
            ->join('products as c','b.products_id','=','c.id')
            ->select(DB::raw('b.code as kode_transaksi,c.name,b.products_id as product_id, COUNT(b.products_id) AS count_product',
            ))
            ->whereMonth('created_at',date('m'))
            ->whereYear('created_at',date('Y'))
            ->groupBy('b.products_id')
            ->orderByDesc('count_product')
            ->get();
        $transaction_success = Transaction::where('transaction_status','SUCCESS')->count();
        $transaction_pending = Transaction::where('transaction_status','PENDING')->count();
        $transaction_shipping = Transaction::where('transaction_status','SHIPPING')->count();

        $pendapatan_bulan = Transaction::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->sum('total_price');
        $pendapatan_tahun = Transaction::whereYear('created_at',date('Y'))->sum('total_price');
        $pendapatan_global = Transaction::whereYear('created_at',date('Y'))->sum('total_price');
        // return  $chart->build();
        return view('pages.admin.dashboard', [
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction,
            'transaction_best' => $transaction_best,
            'transaction_success' => $transaction_success,
            'transaction_pending' => $transaction_pending,
            'transaction_shipping' => $transaction_shipping,
            'pendapatan_bulan' => $pendapatan_bulan,
            'pendapatan_tahun' => $pendapatan_tahun,
            'pendapatan_global' => $pendapatan_global,
            'chart' => $chart->build()
        ]);
    }
}
