@extends('layouts.tienda')

@section('title', 'Inicio')

@section('content')
{{-- Hero --}}
<section class="bg-gradient-to-br from-sky-400 via-sky-500 to-teal-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4">
                    Todo para tu bebé en un solo lugar
                </h1>
                <p class="text-sky-100 text-lg mb-8">
                    Pañales, ropa, higiene y más. Productos de calidad para el cuidado de tu bebé.
                </p>
                <a href="{{ route('productos.catalogo') }}" class="inline-block bg-white text-sky-600 font-semibold px-8 py-3 rounded-full hover:bg-sky-50 transition-colors shadow-lg">
                    Ver productos
                </a>
            </div>
            <div class="hidden md:flex justify-center">
                <svg class="w-64 h-64 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- Featured Products --}}
@if($destacados->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Productos destacados</h2>
        <a href="{{ route('productos.catalogo', ['destacados' => 1]) }}" class="text-sky-600 hover:text-sky-700 font-medium text-sm">Ver todos &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($destacados as $producto)
            @include('tienda.partials.product-card', ['producto' => $producto])
        @endforeach
    </div>
</section>
@endif

{{-- Categories --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Categorías</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($categorias as $categoria)
            <a href="{{ route('productos.categoria', $categoria) }}" class="group relative bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-32 bg-gradient-to-br from-sky-100 to-teal-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-sky-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-sky-600 transition-colors">{{ $categoria->nombre }}</h3>
                    @if($categoria->productos_count > 0)
                        <p class="text-sm text-gray-500 mt-1">{{ $categoria->productos_count }} productos</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- New Arrivals --}}
@if($nuevos->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Novedades</h2>
        <a href="{{ route('productos.catalogo', ['sort' => 'latest']) }}" class="text-sky-600 hover:text-sky-700 font-medium text-sm">Ver todas &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($nuevos as $producto)
            @include('tienda.partials.product-card', ['producto' => $producto])
        @endforeach
    </div>
</section>
@endif
@endsection
