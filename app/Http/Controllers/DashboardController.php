<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\TransactionDetail;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
        //     ->whereHas('product', function ($product) {
        //         $product->where('users_id', Auth::user()->id);
        //     });

        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })->get();

        // dd(Auth::user()->id);
        // dd($transactions->get());

        // $revenue = $transactions->get()->reduce(function ($carry, $item) {
        //     return $carry + $item->price;
        // });

        // $customer = User::count();

        return view('pages.dashboard', [
            // 'transaction_count' => $transactions->count(),
            'transaction_data' => $buyTransactions,
            // 'revenue' => $revenue,
            // 'customer' => $customer,
        ]);
    }
}
