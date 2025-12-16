<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Wishlist Kamu ❤️
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($items->count() === 0)
                <div class="bg-white p-10 text-center rounded shadow">
                    <h3 class="text-lg font-semibold">
                        Wishlist masih kosong 😢
                    </h3>
                    <p class="text-gray-500 mt-2">
                        Yuk mulai belanja!
                    </p>

                    <a href="{{ route('dashboard') }}"
                       class="inline-block mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
                        Ke Beranda
                    </a>
                </div>
            @else

            <form method="POST" id="bulkForm">
                @csrf

                <div class="flex items-center gap-4 mb-4 bg-white p-4 rounded shadow">
                    <input type="checkbox" id="selectAll" class="w-5 h-5">
                    <span class="text-sm text-gray-600">Pilih Semua</span>

                    <button
                        formaction="{{ route('wishlist.removeSelected') }}"
                        class="ml-auto bg-red-500 text-white px-3 py-1.5 rounded text-sm hover:bg-red-600">
                        Hapus Terpilih
                    </button>

                    <button
                        formaction="{{ route('wishlist.moveToCart') }}"
                        class="bg-indigo-600 text-white px-3 py-1.5 rounded text-sm hover:bg-indigo-700">
                        Pindah ke Keranjang
                    </button>
                </div>

                @foreach($items as $item)
                    <div class="wishlist-item bg-white p-4 mb-4 rounded shadow flex items-center gap-4 transition">

                        <input
                            type="checkbox"
                            name="wishlist_ids[]"
                            value="{{ $item->id }}"
                            class="item-checkbox w-5 h-5"
                        >

                        <img
                            src="{{ asset('storage/' . $item->produk->gambar) }}"
                            class="w-20 h-20 object-cover rounded"
                        >

                        <div class="flex-1">
                            <h4 class="font-semibold">
                                {{ $item->produk->nama_produk }}
                            </h4>

                            <p class="text-sm text-gray-500">
                                Rp {{ number_format($item->produk->harga) }}
                            </p>

                            @if($item->produk->stok > 0)
                                <span class="text-green-600 text-sm">Stok tersedia</span>
                            @else
                                <span class="text-red-500 text-sm">Stok habis</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">

                            <button
                                formaction="{{ route('wishlist.moveToCart') }}"
                                type="submit"
                                class="flex items-center gap-1 px-3 py-1.5 rounded text-sm
                                    {{ $item->produk->stok > 0
                                        ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                                        : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                    }}"
                                {{ $item->produk->stok < 1 ? 'disabled' : '' }}
                            >
                                🛒 <span>Cart</span>
                            </button>

                            <button
                                formaction="{{ route('wishlist.removeSelected') }}"
                                type="submit"
                                class="text-red-500 hover:text-red-700 text-xl">
                                🗑
                            </button>

                        </div>
                    </div>
                @endforeach
            </form>
            @endif
        </div>
    </div>

    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');

        selectAll?.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                toggleHighlight(cb);
            });
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                toggleHighlight(this);
            });
        });

        function toggleHighlight(checkbox) {
            const item = checkbox.closest('.wishlist-item');
            if (checkbox.checked) {
                item.classList.add('bg-indigo-50', 'ring-2', 'ring-indigo-300');
            } else {
                item.classList.remove('bg-indigo-50', 'ring-2', 'ring-indigo-300');
            }
        }
    </script>
</x-app-layout>
