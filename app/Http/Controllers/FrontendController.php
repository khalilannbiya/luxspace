<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

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
        $total_price = 0;

        foreach ($carts as $cart) {
            $total_price  += $cart->product->price;
        }

        return view('pages.frontend.cart', compact('carts', 'total_price'));
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

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        // Get Carts Data
        $carts = Cart::with(['product'])->where('user_id', Auth::user()->id)->get();

        // Add to Transaction data
        $data['user_id'] = Auth::user()->id;
        $data['courier'] = 'JNE Express';
        $data['total_price'] = $carts->sum('product.price');

        // Create transaction
        $transaction = Transaction::create($data);

        // Create Transaction Item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'transaction_id' => $transaction->id,
                'user_id' => $cart->user_id,
                'product_id' => $cart->product_id
            ]);
        }

        // Delete cart after transaction
        Cart::where('user_id', Auth::user()->id)->delete();

        // Configure midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Setup variable midtrans
        $midtrans = [
            'transaction_details' => [
                "order_id" => 'LUX-' . $transaction->id,
                "gross_amount" => (int) $transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email
            ],
            'enabled_payments' => ['gopay', 'shopeepay', 'bank_transfer'],
            "gopay" => [
                "enable_callback" => true,
                "callback_url" => "http://gopay.com"
            ],
            "shopeepay" => [
                "callback_url" => "http://shopeepay.com?order_id=LUX-" . $transaction->id
            ],
            'vtweb' => []
        ];

        // Payment process
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function catalog(Product $product)
    {
        $products = Product::with(['productGallery'])->latest()->get();
        return view('pages.frontend.catalog', compact('products'));
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
