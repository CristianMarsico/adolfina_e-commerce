@extends('layouts.tienda')

@section('title', 'Pago exitoso')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">¡Pago exitoso!</h1>
        <p class="text-gray-500 mb-6">Gracias por tu compra. Te enviaremos un email con los detalles del pedido.</p>

        <div class="bg-gray-50 rounded-xl p-4 text-left text-sm mb-6">
            <p class="font-medium text-gray-700 mb-2">Pedido #{{ $pedido->id }}</p>
            <p class="text-gray-500">Total: <span class="font-semibold text-gray-800">${{ number_format($pedido->total, 0, ',', '.') }}</span></p>
            <p class="text-gray-500">Estado: <span class="text-green-600 font-medium">Pagado</span></p>
        </div>

        <a href="{{ route('productos.catalogo') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors">
            Volver a la tienda
        </a>
    </div>
</div>
@endsection
