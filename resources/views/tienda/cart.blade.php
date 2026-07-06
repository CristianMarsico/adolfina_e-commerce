@extends('layouts.tienda')

@section('title', 'Carrito de compras')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Carrito de compras</h1>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="text-center py-16">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-400 mb-6">Agregá productos para empezar a comprar.</p>
            <a href="{{ route('productos.catalogo') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors">
                Ver productos
            </a>
        </div>
    @else
        <div class="space-y-4">
            @php $total = 0; @endphp
            @foreach($cart as $key => $item)
                @php
                    $producto = $productos->get($item['producto_id']);
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center gap-4">
                    {{-- Image --}}
                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0 flex items-center justify-center">
                        @if($producto && $producto->imagenPrincipal)
                            <img src="{{ asset('storage/' . $producto->imagenPrincipal->path) }}" alt="{{ $item['nombre'] }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('productos.show', $item['slug']) }}" class="font-semibold text-gray-800 hover:text-sky-600 transition-colors">{{ $item['nombre'] }}</a>
                        @if(!empty($item['atributo_nombre']))
                            <p class="text-xs text-gray-500 mt-0.5">{{ $item['atributo_nombre'] }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-1">${{ number_format($item['precio'], 0, ',', '.') }} c/u</p>
                    </div>

                    {{-- Qty --}}
                    <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="submit" name="cantidad" value="{{ max(1, $item['cantidad'] - 1) }}" class="px-2 py-1.5 text-gray-500 hover:text-gray-700 text-sm">−</button>
                            <span class="px-3 py-1.5 text-sm font-medium">{{ $item['cantidad'] }}</span>
                            <button type="submit" name="cantidad" value="{{ $item['cantidad'] + 1 }}" class="px-2 py-1.5 text-gray-500 hover:text-gray-700 text-sm">+</button>
                        </div>
                    </form>

                    {{-- Subtotal --}}
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">${{ number_format($subtotal, 0, ',', '.') }}</p>
                    </div>

                    {{-- Remove --}}
                    <form action="{{ route('cart.destroy', $key) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Total & Checkout --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-lg font-semibold text-gray-800">Total</span>
                <span class="text-2xl font-bold text-gray-900">${{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="flex flex-col gap-3">
                <a href="{{ auth()->check() ? route('checkout.index') : route('login', ['redirect' => route('checkout.index')]) }}" class="w-full inline-flex items-center justify-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-6 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    Finalizar compra
                </a>
                <a href="https://wa.me/541112345678?text=Hola!%20Quiero%20comprar%20los%20siguientes%20productos:%0a{{ urlencode(implode('%0a', collect($cart)->map(fn($i) => $i['nombre'] . ' x' . $i['cantidad'] . ' - $' . number_format($i['precio'] * $i['cantidad'], 0, ',', '.') )->toArray())) }}%0aTotal:%20${{ number_format($total, 0, ',', '.') }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Consultar por WhatsApp
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
