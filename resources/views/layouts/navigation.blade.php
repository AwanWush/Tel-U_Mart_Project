<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transform hover:scale-105 transition duration-300">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="hidden space-x-4 sm:flex">
                    
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out
                       {{ request()->routeIs('dashboard')
                            ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200'
                            : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600'
                       }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
                        </svg>
                        Home
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">

                @php
                    $cartCount = \App\Models\CartItem::whereHas('cart', function ($q) {
                        $q->where('user_id', auth()->id());
                    })->sum('quantity');
                @endphp

                <a href="{{ route('cart.index') }}"
                   class="relative mr-5 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out
                   {{ request()->routeIs('cart.*')
                        ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200'
                        : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600'
                   }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4
                                 M7 13L5.4 5M7 13l-2 9m12-9l2 9
                                 M9 21h6" />
                    </svg>

                    <span>Keranjang</span>

                    @if($cartCount > 0)
                        <span class="ml-1 bg-red-500 text-white text-xs px-2 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

               @php
    $isWishlist = request()->routeIs('wishlist.*');
@endphp

<a href="{{ route('wishlist.index') }}"
   class="relative flex items-center gap-1 px-3 py-2 rounded-full transition
          {{ $isWishlist ? 'bg-indigo-100 text-indigo-600 font-semibold' : 'text-gray-500 hover:text-indigo-600' }}">
    
    <svg xmlns="http://www.w3.org/2000/svg"
         fill="{{ $isWishlist ? 'currentColor' : 'none' }}"
         viewBox="0 0 24 24"
         stroke-width="1.8"
         stroke="currentColor"
         class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 8.25c0-2.485-2.099-4.5-4.687-4.5
                 -1.935 0-3.597 1.126-4.313 2.733
                 -.716-1.607-2.378-2.733-4.313-2.733
                 C5.1 3.75 3 5.765 3 8.25
                 c0 7.22 9 12 9 12s9-4.78 9-12z" />
    </svg>

    <span class="text-sm">Wishlist</span>
</a>

@php
    $isNotification = request()->routeIs('notifications.*');

    $notifCount = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
@endphp

<a href="{{ route('notifications.index') }}"
   class="relative mr-4 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium
          transition-all duration-300 ease-in-out
          {{ $isNotification
                ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200'
                : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600'
          }}">
    
    <svg xmlns="http://www.w3.org/2000/svg"
         fill="{{ $isNotification ? 'currentColor' : 'none' }}"
         viewBox="0 0 24 24"
         stroke-width="1.8"
         stroke="currentColor"
         class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M14.857 17.082a23.848 23.848 0 005.454-1.31
                 A8.967 8.967 0 0118 9.75V9
                 a6 6 0 10-12 0v.75
                 a8.967 8.967 0 01-2.312 6.022
                 c1.733.64 3.56 1.085 5.455 1.31
                 m5.714 0a24.255 24.255 0 01-5.714 0
                 m5.714 0a3 3 0 11-5.714 0" />
    </svg>

    <span>Notifikasi</span>

    @if($notifCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white
                     text-xs px-2 rounded-full">
            {{ $notifCount }}
        </span>
    @endif
</a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold uppercase text-xs">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
