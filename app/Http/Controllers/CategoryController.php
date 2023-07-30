<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $categories = Category::all();
        $products = Product::with(['galleries'])->paginate(20);

        //ambil data terakhir bisa pakai latest (cek di doc query builder)

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $slug)
    {

        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrfail();
        $products = Product::with(['galleries'])->where('categories_id', $category->id)->paginate(20);

        //ambil data terakhir bisa pakai latest (cek di doc query builder)

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
