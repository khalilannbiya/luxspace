@extends('layouts.frontend')

@section('content')
<section class="px-3 md:px-9 py-4 flex flex-wrap flex-row gap-2 md:gap-2 lg:gap-3 justify-around md:justify-center">
    @foreach ($products as $product)
    <div class="w-[48%] md:w-44 lg:w-52 bg-slate-100 mt-2 rounded border">
        <a href="{{ route('details', $product->slug) }}">
            <div>

                {{-- Jika produk memiliki relasi productGallery() yang terhubung dengan gambar produk, maka kode
                akan mengembalikan URL gambar produk yang disimpan di sistem penyimpanan, yaitu dengan memanggil
                method Storage::url() pada URL gambar. Namun, jika produk tidak memiliki relasi productGallery()
                atau tidak memiliki gambar produk, maka kode akan mengembalikan string base64 yang merepresentasikan
                gambar kosong --}}
                <img class="w-full h-full object-cover object-center"
                    src="{{ $product->productGallery()->exists() ? Storage::url($product->productGallery->first()->url) : 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' }}"
                    alt="Image Product {{ $product->name }}">
            </div>
            <h2 class="font-bold mt-5 text-center uppercase px-3">{{ $product->name }}</h2>
            <h3 class="my-3 text-center text-sm font-semibold">IDR {{ number_format($product->price) }}</h3>
        </a>
    </div>
    @endforeach
</section>
@endsection