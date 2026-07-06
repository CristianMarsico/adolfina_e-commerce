<div x-data="productCard({{ $producto->id }})" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group flex flex-col">
    <a href="{{ route('productos.show', $producto->slug) }}" class="block relative">
        <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
            @if($producto->imagenPrincipal)
                <img src="{{ asset('storage/' . $producto->imagenPrincipal->path) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs">Imagen</span>
                </div>
            @endif
        </div>
        <template x-if="descuento">
            <div class="absolute top-2 left-2 bg-pink-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                <span x-text="descuento.tipo === 'porcentaje' ? '-' + descuento.valor + '%' : 'OFERTA'"></span>
            </div>
        </template>
        <template x-if="stock < 1">
            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                Agotado
            </div>
        </template>
    </a>
    <div class="p-4 flex flex-col flex-1">
        @if($producto->categoria)
            <span class="text-xs text-sky-600 font-medium">{{ $producto->categoria->nombre }}</span>
        @endif
        <h3 class="font-semibold text-gray-800 mt-1 group-hover:text-sky-600 transition-colors line-clamp-2">
            <a href="{{ route('productos.show', $producto->slug) }}">{{ $producto->nombre }}</a>
        </h3>
        @if($producto->marca)
            <p class="text-sm text-gray-500 mt-1">{{ $producto->marca }}</p>
        @endif
        <div class="mt-auto pt-3">
            <div class="flex items-center gap-2">
                <template x-if="precioOferta">
                    <span class="text-lg font-bold text-pink-600" x-text="'$' + Number(precioOferta).toLocaleString('es-AR')"></span>
                </template>
                <template x-if="precioOferta">
                    <span class="text-sm text-gray-400 line-through" x-text="'$' + Number(precio).toLocaleString('es-AR')"></span>
                </template>
                <template x-if="!precioOferta">
                    <span class="text-lg font-bold text-gray-900" x-text="'$' + Number(precio).toLocaleString('es-AR')"></span>
                </template>
            </div>
        </div>
        <div class="mt-3">
            <template x-if="stock > 0">
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium py-2 rounded-full transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Agregar
                    </button>
                </form>
            </template>
            <template x-if="stock < 1">
                <button disabled class="w-full bg-gray-200 text-gray-400 text-sm font-medium py-2 rounded-full cursor-not-allowed">
                    Sin stock
                </button>
            </template>
        </div>
    </div>
</div>
