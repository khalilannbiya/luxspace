<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

        return view('pages.frontend.details', compact('product'));
    }

    public function cart(Request $request)
    {
        return view('pages.frontend.cart');
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
