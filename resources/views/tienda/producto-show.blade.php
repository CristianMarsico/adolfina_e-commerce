@extends('layouts.tienda')

@section('title', $producto->nombre)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Inicio</a>
        <span class="mx-2">/</span>
        @if($producto->categoria)
            <a href="{{ route('productos.categoria', $producto->categoria) }}" class="hover:text-sky-600">{{ $producto->categoria->nombre }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-gray-800">{{ $producto->nombre }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
        {{-- Left: Images --}}
        <div x-data="{ selectedImage: '{{ $producto->imagenes->isNotEmpty() ? asset('storage/' . (($producto->imagenes->firstWhere('es_principal', true) ?? $producto->imagenes->first())->path)) : '' }}' }">
            {{-- Main image --}}
            @php
                $mainImage = $producto->imagenes->firstWhere('es_principal', true) ?? $producto->imagenes->first();
            @endphp
            <div class="bg-gray-100 rounded-2xl overflow-hidden aspect-square flex items-center justify-center mb-4">
                @if($producto->imagenes->isNotEmpty())
                    <img :src="selectedImage" src="{{ asset('storage/' . $mainImage->path) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center text-gray-400">
                        <svg class="w-20 h-20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Imagen</span>
                    </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($producto->imagenes->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($producto->imagenes as $imagen)
                        <div @click="selectedImage = '{{ asset('storage/' . $imagen->path) }}'"
                             :class="selectedImage === '{{ asset('storage/' . $imagen->path) }}' ? 'border-sky-500' : 'border-transparent'"
                             class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0 cursor-pointer border-2 hover:border-sky-300 transition-colors">
                            <img src="{{ asset('storage/' . $imagen->path) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right: Info --}}
        <div>
            @if($producto->categoria)
                <span class="inline-block bg-sky-100 text-sky-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                    {{ $producto->categoria->nombre }}
                </span>
            @endif

            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $producto->nombre }}</h1>

            @if($producto->marca?->nombre)
                <p class="text-gray-500 text-sm mb-4">Marca: <span class="font-medium text-gray-700">{{ $producto->marca->nombre }}</span></p>
            @endif

            {{-- Price --}}
            <div class="mb-6">
                @if($producto->precio_oferta)
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-3xl font-bold text-pink-600">${{ number_format($producto->precio_oferta, 0, ',', '.') }}</span>
                        <span class="text-lg text-gray-400 line-through">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                    </div>
                    @if($producto->descuento?->tipo_descuento === 'porcentaje')
                        <span class="inline-block bg-pink-100 text-pink-700 text-xs font-bold px-2.5 py-1 rounded-full">-{{ $producto->descuento?->valor_descuento }}%</span>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Oferta válida hasta {{ $producto->descuento?->fecha_fin?->format('d/m/Y') }}</p>
                @else
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                @endif
            </div>

            {{-- Edad/Talla --}}
            @if($producto->edad_talla)
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span><strong>Edad / Talla:</strong> {{ $producto->edad_talla }}</span>
                </div>
            @endif

            {{-- Stock --}}
            <div class="mb-6">
                @if($producto->stock > 0)
                    <span class="text-green-600 text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        En stock
                    </span>
                @else
                    <span class="text-red-500 text-sm font-medium">Sin stock</span>
                @endif
            </div>

            {{-- Attributes --}}
            @if($producto->atributos->isNotEmpty())
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Opciones:</h3>
                    <div class="flex flex-wrap gap-2" x-data="{ selected: null }">
                        @foreach($producto->atributos as $atributo)
                            <button type="button"
                                @click="selected = {{ $atributo->id }}"
                                :class="selected === {{ $atributo->id }} ? 'border-sky-500 bg-sky-50 text-sky-700' : 'border-gray-300 bg-white text-gray-600 hover:border-sky-300'"
                                class="px-4 py-2 border rounded-lg text-sm font-medium transition-colors">
                                {{ $atributo->valor }}
                                @if($atributo->precio_adicional > 0)
                                    <span class="text-xs text-gray-400">(+${{ number_format($atributo->precio_adicional, 0, ',', '.') }})</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Add to Cart Form --}}
            <form action="{{ route('cart.store') }}" method="POST" class="mb-4" x-data="{ qty: 1 }">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                {{-- Quantity --}}
                <div class="flex items-center gap-4 mb-4">
                    <label class="text-sm font-medium text-gray-700">Cantidad:</label>
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" name="cantidad" x-model="qty" min="1" max="{{ $producto->stock }}" class="w-14 text-center border-0 focus:ring-0 text-sm">
                        <button type="button" @click="qty = Math.min({{ $producto->stock }}, qty + 1)" class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" {{ $producto->stock < 1 ? 'disabled' : '' }} class="w-full bg-sky-500 hover:bg-sky-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold py-3 px-6 rounded-full transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    Agregar al carrito
                </button>
            </form>

            {{-- WhatsApp --}}
            @php
                $precioMostrar = $producto->precio_oferta ?? $producto->precio;
                $whatsappMessage = "Hola! Quiero comprar: " . $producto->nombre . " - $" . number_format($precioMostrar, 0, ',', '.') . "%0a" . url()->current();
            @endphp
            <a href="https://wa.me/541112345678?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Comprar por WhatsApp
            </a>

            {{-- Description Tabs --}}
            <div class="mt-8 border-t border-gray-200 pt-6" x-data="{ tab: 'description' }">
                <div class="flex gap-6 border-b border-gray-200 mb-4">
                    <button @click="tab = 'description'" :class="tab === 'description' ? 'text-sky-600 border-sky-500' : 'text-gray-500 border-transparent hover:text-gray-700'" class="pb-3 text-sm font-medium border-b-2 transition-colors">Descripción</button>
                    <button @click="tab = 'details'" :class="tab === 'details' ? 'text-sky-600 border-sky-500' : 'text-gray-500 border-transparent hover:text-gray-700'" class="pb-3 text-sm font-medium border-b-2 transition-colors">Detalles</button>
                </div>

                <div x-show="tab === 'description'" class="text-gray-600 text-sm leading-relaxed prose max-w-none">
                    {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                </div>

                <div x-show="tab === 'details'" class="text-sm text-gray-600">
                    <table class="w-full">
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 font-medium text-gray-700 w-1/3">Marca</td>
                                <td class="py-2">{{ $producto->marca?->nombre ?? '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 font-medium text-gray-700">Edad / Talla</td>
                                <td class="py-2">{{ $producto->edad_talla ?? '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-2 font-medium text-gray-700">Stock</td>
                                <td class="py-2">{{ $producto->stock > 0 ? $producto->stock . ' unidades' : 'Sin stock' }}</td>
                            </tr>
                            @if($producto->atributos->isNotEmpty())
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 font-medium text-gray-700">Opciones</td>
                                    <td class="py-2">
                                        <ul class="list-disc list-inside">
                                            @foreach($producto->atributos as $atributo)
                                                <li>{{ $atributo->tipo }}: {{ $atributo->valor }} @if($atributo->precio_adicional > 0)(+${{ number_format($atributo->precio_adicional, 0, ',', '.') }})@endif</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relacionados->isNotEmpty())
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Productos relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relacionados as $rel)
                    @include('tienda.partials.product-card', ['producto' => $rel])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

