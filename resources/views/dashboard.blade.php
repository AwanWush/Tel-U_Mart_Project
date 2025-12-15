<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Daftar Produk
                    </h3>

                    @foreach($produk as $item)
                        <div class="border p-4 rounded mb-4">

                            <h4 class="font-semibold">
                                {{ $item->nama_produk }}
                            </h4>

                            <p>Rp {{ number_format($item->harga) }}</p>

                            <p>Stok: {{ $item->stok }}</p>

                            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button class="bg-orange-500 text-white px-4 py-2 rounded">
                                    Tambah ke Keranjang
                                </button>
                            </form>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
