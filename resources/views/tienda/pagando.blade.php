@extends('layouts.tienda')

@section('title', 'Pagar con QR')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
        <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Escaneá el QR para pagar</h1>
        <p class="text-gray-500 mb-6">Abrí tu app de Mercado Pago o la cámara del celular y escaneá el código.</p>

        @if(config('services.mercadopago.sandbox'))
            <div class="bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-4 py-3 mb-6">
                <strong>Modo de prueba:</strong> escaneá este QR con la app de Mercado Pago del comprador de prueba (usá una tarjeta de prueba).
            </div>
        @endif

        <div class="flex justify-center mb-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-5 inline-flex">
                {!! $qrSvg !!}
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
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

        <div id="estado-esperando" class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-6">
            <div class="w-5 h-5 border-2 border-sky-500 border-t-transparent rounded-full animate-spin"></div>
            Esperando el pago...
        </div>

        <div id="estado-pagado" class="hidden mb-6">
            <div class="flex items-center justify-center gap-2 text-green-600 font-semibold mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Pago confirmado
            </div>
            <a href="{{ route('checkout.exito', [$pedido, 'token' => $pedido->token]) }}"
               class="inline-flex items-center justify-center gap-2 w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 px-6 rounded-full transition-colors text-lg">
                Ver mi pedido
            </a>
        </div>

        <p class="text-xs text-gray-400 mb-6">El QR vence a los 15 minutos. Esta página se actualiza sola.</p>

        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-sky-600 transition-colors">
            ← Volver a la tienda
        </a>
    </div>
</div>

<script>
    (function () {
        const estadoUrl = {!! json_encode(route('checkout.estado', [$pedido, 'token' => $pedido->token])) !!};
        const exitoUrl = {!! json_encode(route('checkout.exito', [$pedido, 'token' => $pedido->token])) !!};

        let redirigiendo = false;

        async function checkEstado() {
            try {
                const res = await fetch(estadoUrl);
                if (!res.ok) return;
                const data = await res.json();

                if (data.pagado && !redirigiendo) {
                    redirigiendo = true;
                    document.getElementById('estado-esperando').classList.add('hidden');
                    document.getElementById('estado-pagado').classList.remove('hidden');
                    setTimeout(function () {
                        window.location.href = exitoUrl;
                    }, 1500);
                }
            } catch (e) {
                console.error('Error consultando estado:', e);
            }
        }

        setInterval(checkEstado, 3000);
        checkEstado();
    })();
</script>
@endsection
