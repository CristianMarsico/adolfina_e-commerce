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
                <img src="{{ asset('images/hero.jpg') }}" alt="Productos para bebé" class="w-72 h-72 object-cover rounded-2xl shadow-xl">
            </div>
        </div>
    </div>
</section>

{{-- Promociones --}}
@if($promociones->isNotEmpty())
    @foreach($promociones as $promocion)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                    {{ $promocion->nombre }}
                </h2>
                @if($promocion->descripcion)
                    <p class="text-gray-500 mt-2">{{ $promocion->descripcion }}</p>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($promocion->productos as $producto)
                    @include('tienda.partials.product-card', ['producto' => $producto])
                @endforeach
            </div>
        </section>
    @endforeach
@endif

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
                <div class="h-32 bg-gradient-to-br from-sky-100 to-teal-50 overflow-hidden">
                    <img src="{{ asset('images/categorias/' . \Illuminate\Support\Str::slug($categoria->nombre) . '.jpg') }}" alt="{{ $categoria->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
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

{{-- Brands --}}
@if($marcas->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
         x-data="{
            timer: null,
            step() {
                const track = this.$refs.track;
                const slide = track.querySelector('.snap-start');
                if (!slide) return 0;
                return slide.offsetWidth + 16;
            },
            next() {
                const track = this.$refs.track;
                if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
                    track.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: this.step(), behavior: 'smooth' });
                }
            },
            prev() {
                this.$refs.track.scrollBy({ left: -this.step(), behavior: 'smooth' });
            },
            start() {
                this.stop();
                this.timer = setInterval(() => this.next(), 3500);
            },
            stop() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },
            init() {
                this.start();
            }
         }"
         @mouseenter="stop()" @mouseleave="start()"
         @touchstart.passive="stop()" @touchend.passive="start()">
    <h2 class="text-center text-2xl md:text-3xl font-bold text-gray-800 mb-8">Nuestras marcas</h2>

    <div class="relative max-w-5xl mx-auto">
        <div x-ref="track" class="flex overflow-x-auto gap-4 snap-x snap-mandatory scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach($marcas as $marca)
                <a href="{{ route('productos.catalogo', ['marcas' => [$marca->id]]) }}" title="{{ $marca->nombre }}" class="group shrink-0 snap-start flex items-center justify-center bg-white w-40 sm:w-44 h-24 sm:h-28 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:border-sky-200 hover:-translate-y-1 transition-all duration-300 p-4">
                    @if($marca->imagen)
                        <img src="{{ asset('storage/' . $marca->imagen) }}" alt="{{ $marca->nombre }}" class="max-h-full max-w-full object-contain grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300">
                    @else
                        <span class="text-lg font-semibold text-gray-500 group-hover:text-sky-600 transition-colors text-center">{{ $marca->nombre }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-gray-50 to-transparent"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-gray-50 to-transparent"></div>

        <button type="button" @click="prev()" aria-label="Anterior" class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 items-center justify-center w-10 h-10 rounded-full bg-white border border-gray-200 shadow-md hover:bg-sky-50 hover:text-sky-600 transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button type="button" @click="next()" aria-label="Siguiente" class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 items-center justify-center w-10 h-10 rounded-full bg-white border border-gray-200 shadow-md hover:bg-sky-50 hover:text-sky-600 transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</section>
@endif

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
