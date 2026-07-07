@extends('layouts.tienda')

@section('title', 'Ir a pagar')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Redirigiendo a Mercado Pago</h1>
        <p class="text-gray-500 mb-8">Hacé clic en el botón para abrir Mercado Pago en una nueva ventana.</p>

        <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Pedido #{{ $pedido->id }}</span>
                <span class="font-semibold text-gray-800">${{ number_format($pedido->total, 0, ',', '.') }}</span>
            </div>
            <div class="text-xs text-gray-400">
                @foreach($pedido->items as $item)
                    <div class="flex justify-between py-1">
                        <span>{{ $item->nombre }} <span class="text-gray-300">x{{ $item->cantidad }}</span></span>
                        <span>${{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <a href="{{ $initPoint }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center justify-center gap-2 w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-6 rounded-full transition-colors text-lg mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Pagar con Mercado Pago
        </a>

        <p class="text-sm text-gray-400 mb-6">Después de pagar, volvé a esta ventana para ver el resultado.</p>

        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-sky-600 transition-colors">
            ← Volver a la tienda
        </a>
    </div>
</div>

<script>
    setTimeout(function() {
        window.open('{{ $initPoint }}', '_blank');
    }, 1500);
</script>
@endsection
