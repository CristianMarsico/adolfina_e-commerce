<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Pañalera')) | Pañalera</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        {{-- Header --}}
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 md:h-20">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                        <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <span class="text-xl md:text-2xl font-bold text-sky-600">Pañalera</span>
                    </a>

                    {{-- Search --}}
                    <div class="hidden md:flex flex-1 max-w-lg mx-8">
                        <form action="{{ route('productos.catalogo') }}" method="GET" class="w-full">
                            <div class="relative">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar productos..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:ring-sky-500 focus:border-sky-500 bg-gray-50">
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </form>
                    </div>

                    {{-- Right --}}
                    <div class="flex items-center gap-3 md:gap-5">
                        <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-sky-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                            </svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                            @endif
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex text-sm font-medium text-gray-600 hover:text-sky-600 transition-colors">Mi cuenta</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-gray-600 hover:text-sky-600 transition-colors">Ingresar</a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex text-sm font-medium bg-sky-500 text-white px-4 py-2 rounded-full hover:bg-sky-600 transition-colors">Registrarse</a>
                        @endauth

                        {{-- Mobile menu toggle --}}
                        <button x-data @click="$dispatch('toggle-mobile-menu')" class="md:hidden text-gray-600 hover:text-sky-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile search --}}
            <div class="md:hidden px-4 pb-3">
                <form action="{{ route('productos.catalogo') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar productos..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:ring-sky-500 focus:border-sky-500 bg-gray-50">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>

            {{-- Navbar --}}
            <nav class="border-t border-gray-100 bg-sky-50 hidden md:block">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <ul class="flex items-center justify-center gap-1 overflow-x-auto">
                        <li>
                            <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-sky-600 hover:bg-white/60 rounded-t transition-colors {{ request()->routeIs('home') ? 'text-sky-600 bg-white' : '' }}">
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('productos.catalogo') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-sky-600 hover:bg-white/60 rounded-t transition-colors {{ request()->routeIs('productos.catalogo') ? 'text-sky-600 bg-white' : '' }}">
                                Todos los productos
                            </a>
                        </li>
                        @php
                            $categoriasNav = \App\Models\Categoria::where('activo', true)->get();
                        @endphp
                        @foreach($categoriasNav as $cat)
                            <li>
                                <a href="{{ route('productos.categoria', $cat) }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-sky-600 hover:bg-white/60 rounded-t transition-colors whitespace-nowrap {{ request()->routeIs('productos.categoria') && request()->route('categoria')?->id === $cat->id ? 'text-sky-600 bg-white' : '' }}">
                                    {{ $cat->nombre }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('contacto.index') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-sky-600 hover:bg-white/60 rounded-t transition-colors {{ request()->routeIs('contacto.*') ? 'text-sky-600 bg-white' : '' }}">
                                Contacto
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        {{-- Main --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-800 text-gray-300 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                            </svg>
                            <span class="text-lg font-bold text-white">Pañalera</span>
                        </div>
                        <p class="text-sm leading-relaxed">Tu tienda de confianza para el cuidado de tu bebé. Pañales, ropa, higiene y más.</p>
                    </div>

                    <div>
                        <h3 class="text-white font-semibold mb-4">Contacto</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>contacto@panalera.com</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>+54 11 3435-2107</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-white font-semibold mb-4">Atención al cliente</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="https://wa.me/541112345678?text=Hola!%20Quiero%20consultar%20por%20productos" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-green-400 hover:text-green-300 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span>Escribinos por WhatsApp</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contacto.index') }}" class="text-gray-400 hover:text-white transition-colors">Contacto</a>
                            </li>
                            <li>
                                <a href="{{ route('productos.catalogo') }}" class="text-gray-400 hover:text-white transition-colors">Catálogo</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Pañalera. Todos los derechos reservados.
                </div>
            </div>
        </footer>
    </div>

    {{-- WhatsApp floating button --}}
    <a href="https://wa.me/541112345678?text=Hola!%20Quiero%20consultar%20por%20productos"
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all hover:scale-110 active:scale-95">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    @stack('scripts')

    {{-- Alpine product card component --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productCard', (productoId) => ({
                precio: 0,
                precioOferta: null,
                descuento: null,
                stock: 0,
                init() {
                    this.fetchPrecio();
                    setInterval(() => this.fetchPrecio(), 60000);
                },
                fetchPrecio() {
                    fetch('/api/productos/' + productoId + '/precio')
                        .then(r => r.json())
                        .then(data => {
                            this.precio = data.precio;
                            this.precioOferta = data.precio_oferta;
                            this.descuento = data.descuento;
                            this.stock = data.stock;
                        })
                        .catch(() => {});
                }
            }));
        });
    </script>
</body>
</html>
