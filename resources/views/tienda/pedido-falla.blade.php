@extends('layouts.tienda')

@section('title', 'Pago rechazado')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pago rechazado</h1>
        <p class="text-gray-500 mb-6">El pago no pudo procesarse. Podés intentar con otro medio de pago.</p>
        <a href="{{ route('checkout.index') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors">
            Reintentar
        </a>
    </div>
</div>
@endsection
