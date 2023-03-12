<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         *  kumpulan data Product yang memiliki relasi productGallery,
         * diurutkan berdasarkan tanggal pembuatan dari yang terbaru ke yang paling lama,
         * dan dibatasi hanya 10 data saja.
         */
        $products = Product::with(['productGallery'])->latest()->limit(10)->get();

        return view('pages.frontend.index', compact('products'));
    }

    public function details(Request $request, $slug)
    {
        /**
         * Pertama-tama, kita mendefinisikan variabel $product dan memanggil model Product.
         * Kemudian, kita menggunakan metode with() untuk memuat kaitan relasional productGallery.
         * Kemudian, kita menggunakan metode where() untuk memfilter data Product berdasarkan kolom slug yang sama dengan nilai variabel $slug.
         * Terakhir, kita menggunakan metode firstOrFail() untuk mengambil data pertama yang sesuai dengan kriteria pencarian, atau mengembalikan HTTP error 404 jika tidak ada data yang sesuai.
         */
        $product = Product::with(['productGallery'])->where('slug', $slug)->firstOrFail();

        /**
         * Pertama-tama, kita mendefinisikan variabel $recommendations dan memanggil model Product.
         * Kemudian, kita menggunakan metode with() untuk memuat kaitan relasional productGallery.
         * Kemudian, kita menggunakan metode whereNot() untuk memfilter data Product dengan menghilangkan data yang memiliki kolom slug yang sama dengan nilai variabel $slug.
         * Metode inRandomOrder() digunakan untuk mengurutkan data secara acak sebelum diambil, dan metode limit() digunakan untuk membatasi jumlah data yang diambil, dalam hal ini sebanyak 4 data saja. Terakhir, kita menggunakan metode get() untuk mengeksekusi query dan mengambil data.
         */
        $recommendations = Product::with(['productGallery'])->whereNot('slug', $slug)->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.details', compact('product', 'recommendations'));
    }

    public function cart(Request $request)
    {
        /**
         * Kode tersebut berfungsi untuk mengambil semua data keranjang belanja (cart) dari seorang pengguna yang sedang login (authenticated user).
         * Cart::with(['product.productGallery']) digunakan untuk memuat relasi model produk (product) dengan model galeri produk (productGallery). Tujuannya agar informasi galeri produk dapat dimuat dalam satu query sehingga lebih efisien daripada memuat informasi galeri produk pada setiap produk terpisah.
         * where('user_id', Auth::user()->id) digunakan untuk membatasi data hanya untuk cart yang dimiliki oleh pengguna yang sedang login.
         * get() digunakan untuk mengambil data dalam bentuk kumpulan objek. Setelah kode tersebut dijalankan, variabel $carts akan berisi data keranjang belanja dari pengguna yang sedang login beserta informasi produk dan galeri produk yang terkait dengan masing-masing produk.
         */
        $carts = Cart::with(['product.productGallery'])->where('user_id', Auth::user()->id)->get();

        return view('pages.frontend.cart', compact('carts'));
    }

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'product_id' => $id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('cart');
    }

    public function cartDelete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('cart');
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
