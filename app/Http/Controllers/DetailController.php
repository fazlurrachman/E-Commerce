<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();
        return view('pages.details', [
            'product' => $product
        ]);
    }

    public function add(Request $request, $id)
    {

        $cart = Cart::where('products_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        if ($cart) {
            $cart->increment('quantity', request()->quantity);
        } else {
            $data = [
                'products_id' => $id,
                'users_id' => Auth::user()->id,
                'quantity' => request()->quantity,
            ];
            Cart::create($data);
        }


        return redirect()->route('cart')->with('success', 'data berhasil ditambahkan ke cart');
    }

    public function findAssociationRules()
    {
        $transaction_count = Transaction::count();

        $transactions =  DB::table('transactions as a')
            ->join('transaction_details as b', 'a.id', '=', 'b.transaction_id')
            ->join('products as c', 'b.products_id', '=', 'c.id')
            ->select(DB::raw(
                'b.code as kode_transaksi,c.name,b.products_id as product_id, COUNT(b.products_id) AS count_product',
            ))
            ->groupBy('b.products_id')
            ->orderByDesc('count_product')
            ->get();
        $data = [];
        foreach ($transactions as $item) {
            $data[] = [
                'item' => $item->name,
                'transaksi' => $item->count_product,
                'support' => ($item->count_product / $transaction_count) * 100 . "%",
            ];
        }

        // $transactions = Transaction::with('details')->get();
        return $this->findItemSetRules();
        return $data;
    }
}
