@extends('layouts.tienda')

@section('title', $categoria->nombre)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Inicio</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $categoria->nombre }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="bg-gradient-to-r from-sky-50 to-teal-50 rounded-2xl p-6 md:p-10 mb-8">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-2">{{ $categoria->nombre }}</h1>
        <p class="text-sm text-gray-400 mt-2">{{ $productos->total() }} productos</p>
    </div>

    {{-- Products --}}
    @if($productos->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($productos as $producto)
                @include('tienda.partials.product-card', ['producto' => $producto])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay productos en esta categoría</h3>
            <p class="text-gray-400">Probá con otras categorías.</p>
        </div>
    @endif
</div>
@endsection
