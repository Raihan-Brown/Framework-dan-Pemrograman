<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    {{-- Container utama halaman --}}
    <div class="container p-4 mx-auto">
        {{-- Card atau Box untuk Detail Produk --}}
        <div class="overflow-x-auto rounded-lg bg-white p-6 shadow-md border border-gray-100">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('product-index') }}" class="text-blue-600 hover:underline inline-flex items-center mb-4 transition duration-150 ease-in-out">
                {{-- Menggunakan icon SVG untuk visual yang lebih baik --}}
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>

            {{-- Bagian Detail --}}
            <div class="mt-4 border-t pt-4">
                {{-- Nama Produk (Judul Utama) --}}
                <h3 class="mb-6 text-3xl font-bold text-gray-800">{{ $product->product_name }}</h3>

                {{-- Daftar Detail --}}
                <div class="space-y-3 text-lg">
                    <p class="text-gray-700"><strong>ID:</strong> {{ $product->id }}</p>
                    <p class="text-gray-700"><strong>Unit:</strong> {{ $product->unit }}</p>
                    <p class="text-gray-700"><strong>Type:</strong> {{ $product->type }}</p>
                    <p class="text-gray-700"><strong>Information:</strong> {{ $product->information }}</p>
                    <p class="text-gray-700"><strong>Quantity:</strong> {{ $product->qty }}</p>
                    <p class="text-gray-700"><strong>Producer:</strong> {{ $product->producer }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
