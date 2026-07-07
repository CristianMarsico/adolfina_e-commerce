@extends('layouts.tienda')

@section('title', 'Catálogo de productos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <aside class="w-full md:w-64 shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sticky top-28">
                <h3 class="font-semibold text-gray-800 mb-4 text-lg">Filtros</h3>

                <form action="{{ route('productos.catalogo') }}" method="GET" id="filter-form">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}" id="sort-input">
                    @endif

                    {{-- Categories --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Categorías</h4>
                        <div class="space-y-2">
                            @foreach($categorias as $cat)
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                    <input type="checkbox" name="categorias[]" value="{{ $cat->id }}"
                                        {{ in_array((string)$cat->id, (array)request('categorias', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-sky-500 focus:ring-sky-500"
                                        onchange="this.form.submit()">
                                    {{ $cat->nombre }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Etapas --}}
                    @if($etapas->isNotEmpty())
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Etapas</h4>
                        <div class="space-y-2">
                            @foreach($etapas as $id => $nombre)
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                    <input type="checkbox" name="etapas[]" value="{{ $id }}"
                                        {{ in_array((string)$id, (array)request('etapas', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-sky-500 focus:ring-sky-500"
                                        onchange="this.form.submit()">
                                    {{ $nombre }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Brands --}}
                    @if($marcas->isNotEmpty())
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Marcas</h4>
                        <div class="space-y-2">
                            @foreach($marcas as $id => $nombre)
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                    <input type="checkbox" name="marcas[]" value="{{ $id }}"
                                        {{ in_array((string)$id, (array)request('marcas', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-sky-500 focus:ring-sky-500"
                                        onchange="this.form.submit()">
                                    {{ $nombre }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Price range --}}
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Precio</h4>
                        <div class="flex gap-2">
                            <input type="number" name="precio_min" placeholder="Min" value="{{ request('precio_min') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-sky-500 focus:border-sky-500"
                                onchange="this.form.submit()">
                            <input type="number" name="precio_max" placeholder="Max" value="{{ request('precio_max') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-sky-500 focus:border-sky-500"
                                onchange="this.form.submit()">
                        </div>
                    </div>

                    {{-- Clear filters --}}
                    @if(request()->anyFilled(['categorias', 'etapas', 'marcas', 'precio_min', 'precio_max', 'q']))
                        <a href="{{ route('productos.catalogo') }}" class="block text-center text-sm text-red-500 hover:text-red-600 font-medium py-2 border-t border-gray-100 mt-4 pt-4">
                            Limpiar filtros
                        </a>
                    @endif
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1 min-w-0">
            {{-- Active filters --}}
            @php
                $activeFilters = collect();
                if (request('categorias')) {
                    $activeFilters = $activeFilters->merge($categorias->whereIn('id', request('categorias'))->pluck('nombre'));
                }
                if (request('etapas')) {
                    $activeFilters = $activeFilters->merge(collect(request('etapas'))->map(fn($id) => "Etapa: " . ($etapas[$id] ?? $id)));
                }
                if (request('marcas')) {
                    $activeFilters = $activeFilters->merge(collect(request('marcas'))->map(fn($id) => "Marca: " . ($marcas[$id] ?? $id)));
                }
                if (request('precio_min')) {
                    $activeFilters->push("Desde: $" . number_format(request('precio_min'), 0, ',', '.'));
                }
                if (request('precio_max')) {
                    $activeFilters->push("Hasta: $" . number_format(request('precio_max'), 0, ',', '.'));
                }
            @endphp

            @if($activeFilters->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="text-sm text-gray-500">Filtros activos:</span>
                    @foreach($activeFilters as $filter)
                        <span class="inline-flex items-center gap-1 bg-sky-100 text-sky-700 text-sm px-3 py-1 rounded-full">
                            {{ $filter }}
                        </span>
                    @endforeach
                </div>
            @endif

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    @if(request('q'))
                        Resultados para "{{ request('q') }}"
                    @else
                        Todos los productos
                    @endif
                    <span class="text-base font-normal text-gray-500">({{ $productos->total() }})</span>
                </h1>

                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500">Ordenar:</label>
                    <select name="sort" form="filter-form" onchange="this.form.submit()"
                        class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-sky-500 focus:border-sky-500">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Más recientes</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Menor precio</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Mayor precio</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                    </select>
                </div>
            </div>

            {{-- Grid --}}
            @if($productos->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No encontramos productos</h3>
                    <p class="text-gray-400">Probá con otros filtros o términos de búsqueda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
