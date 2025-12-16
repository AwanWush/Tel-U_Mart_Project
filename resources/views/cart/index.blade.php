<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keranjang Kamu
        </h2>
    </x-slot>

    {{-- FORM CHECKOUT (PENTING) --}}
    <form method="POST" action="{{ route('checkout.selected') }}">
        @csrf

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ================= LEFT : CART ITEMS ================= --}}
                <div class="lg:col-span-2">

                    @if($items->count() === 0)
                        <div class="bg-white p-10 text-center rounded shadow">
                            <h3 class="text-lg font-semibold">
                                Yah, keranjangmu kosong 😢
                            </h3>
                            <p class="text-gray-500 mt-2">
                                Yuk belanja dulu!
                            </p>
                        </div>
                    @endif

                    @foreach($items as $item)
                        @php
                            $subtotal = $item->price * $item->quantity;
                        @endphp

                        <div class="bg-white p-4 mb-4 rounded shadow flex items-center gap-4">

                            {{-- CHECKBOX (EDIT) --}}
                            <input type="checkbox"
                                   class="item-check w-5 h-5"
                                   name="cart_items[]"
                                   value="{{ $item->id }}"
                                   data-subtotal="{{ $subtotal }}">

                            {{-- GAMBAR --}}
                            <img src="{{ asset('storage/'.$item->produk->gambar) }}"
                                 class="w-20 h-20 object-cover rounded">

                            {{-- INFO --}}
                            <div class="flex-1">
                                <h4 class="font-semibold">
                                    {{ $item->produk->nama_produk }}
                                </h4>

                                <p class="text-sm text-gray-500">
                                    {{ $item->produk->deskripsi }}
                                </p>

                                <p class="text-sm mt-1">
                                    Harga: <strong>Rp {{ number_format($item->price) }}</strong>
                                </p>

                                @if($item->produk->stok == 0)
                                    <p class="text-red-500 text-sm mt-1">
                                        Stok produk habis
                                    </p>
                                @endif
                            </div>

                            {{-- QTY --}}
                            <div class="flex flex-col items-center">
                                <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           class="w-16 border rounded px-2 py-1 text-center">
                                </form>

                                <span class="text-xs text-gray-500 mt-1">
                                    Subtotal:<br>
                                    <strong>Rp {{ number_format($subtotal) }}</strong>
                                </span>
                            </div>

                            {{-- REMOVE --}}
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xl">
                                    🗑
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- ================= RIGHT : ORDER SUMMARY ================= --}}
                <div class="bg-white p-6 rounded shadow h-fit">
                    <h3 class="font-semibold text-lg mb-4">
                        Order Summary
                    </h3>

                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotalText">Rp 0</span>
                    </div>

                    <div class="flex justify-between mb-2 text-sm text-gray-500">
                        <span>PPN</span>
                        <span>Include</span>
                    </div>

                    <div class="flex justify-between mb-2 text-sm text-gray-500">
                        <span>Ongkos Kirim</span>
                        <span>Rp 0</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span id="totalText">Rp 0</span>
                    </div>

                    {{-- BUTTON SUBMIT (EDIT) --}}
                    <button type="submit"
                            class="w-full mt-5 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- ================= JS ================= --}}
    <script>
        const checkboxes = document.querySelectorAll('.item-check');
        const subtotalText = document.getElementById('subtotalText');
        const totalText = document.getElementById('totalText');

        function hitungTotal() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.dataset.subtotal);
                }
            });

            subtotalText.innerText = 'Rp ' + total.toLocaleString('id-ID');
            totalText.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', hitungTotal);
        });

        // VALIDASI: WAJIB PILIH ITEM
        document.querySelector('form').addEventListener('submit', function (e) {
            if (document.querySelectorAll('.item-check:checked').length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 produk untuk checkout');
            }
        });
    </script>
</x-app-layout>

