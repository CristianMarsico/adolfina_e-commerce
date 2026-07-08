@extends('layouts.tienda')

@section('title', 'Pago pendiente')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pago pendiente</h1>
        <p class="text-gray-500 mb-6">Estamos esperando la confirmación del pago. Te avisaremos cuando se acredite.</p>
        <a href="{{ route('productos.catalogo') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors">
            Volver a la tienda
        </a>
    </div>
</div>
@endsection
