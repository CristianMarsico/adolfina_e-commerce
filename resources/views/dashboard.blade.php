@php
    $estado = request('estado', '');
    $orden = request('orden', 'desc');

    $pedidos = \App\Models\Pedido::ofUser(Auth::id())
        ->when($estado, fn($q, $v) => $q->where('estado', $v))
        ->orderBy('created_at', $orden === 'asc' ? 'asc' : 'desc')
        ->with('items.producto')
        ->get();

    $totalGastado = $pedidos->sum('total');
    $totalPedidos = $pedidos->count();
    $ultimoPedido = $pedidos->first();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mi cuenta</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
            @endif

            {{-- Greeting --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">¡Hola, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 mt-1">Resumen de tu actividad en {{ $configuracion->nombre_negocio ?? 'Pañalera' }}</p>
            </div>

            {{-- Stats cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPedidos }}</p>
                        <p class="text-sm text-gray-500">Pedidos</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($totalGastado, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Gastado</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $ultimoPedido ? $ultimoPedido->created_at->format('d/m/Y') : '-' }}</p>
                        <p class="text-sm text-gray-500">Último pedido</p>
                    </div>
                </div>
            </div>

            {{-- Pedidos --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Mis pedidos</h3>

                        <form method="GET" class="flex flex-wrap items-center gap-2">
                            <select name="estado" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-sky-500 focus:border-sky-500 bg-white">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" @selected(request('estado') === 'pendiente')>Pendiente</option>
                                <option value="pagado" @selected(request('estado') === 'pagado')>Pagado</option>
                                <option value="fallado" @selected(request('estado') === 'fallado')>Fallado</option>
                            </select>

                            <select name="orden" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-sky-500 focus:border-sky-500 bg-white">
                                <option value="desc" @selected(request('orden', 'desc') === 'desc')>Más recientes</option>
                                <option value="asc" @selected(request('orden') === 'asc')>Más antiguos</option>
                            </select>
                        </form>
                    </div>

                    @if($pedidos->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No tenés pedidos todavía.</p>
                            <a href="{{ route('productos.catalogo') }}" class="inline-block mt-4 text-sm text-sky-600 hover:text-sky-700 font-medium">Explorar productos &rarr;</a>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($pedidos as $pedido)
                                <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 transition-colors">
                                    {{-- Row header --}}
                                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="hidden sm:flex w-10 h-10 rounded-lg bg-gray-100 items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-gray-500">#{{ $pedido->id }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <span class="sm:hidden text-sm font-semibold text-gray-800">#{{ $pedido->id }}</span>
                                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @switch($pedido->estado)
                                                            @case('pagado') bg-green-100 text-green-700 @break
                                                            @case('pendiente') bg-yellow-100 text-yellow-700 @break
                                                            @case('fallado') bg-red-100 text-red-700 @break
                                                            @default bg-gray-100 text-gray-600
                                                        @endswitch
                                                    ">{{ ucfirst($pedido->estado) }}</span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-0.5">
                                                    {{ $pedido->created_at->format('d/m/Y H:i') }}
                                                    &middot;
                                                    {{ $pedido->items->count() }} {{ $pedido->items->count() === 1 ? 'producto' : 'productos' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4 shrink-0">
                                            <span class="text-lg font-bold text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</span>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </button>

                                    {{-- Expanded detail --}}
                                    <div x-show="open" x-collapse class="border-t border-gray-100 bg-gray-50">
                                        <div class="p-4 sm:p-5 space-y-4">
                                            {{-- Items --}}
                                            <div class="space-y-2">
                                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Productos</p>
                                                @foreach($pedido->items as $item)
                                                    <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-gray-100">
                                                        <div class="flex items-center gap-3 min-w-0">
                                                            <span class="text-sm text-gray-400 font-medium shrink-0">{{ $item->cantidad }}x</span>
                                                            <div class="min-w-0">
                                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->nombre }}</p>
                                                                @if($item->atributo_info)
                                                                    <p class="text-xs text-gray-500">{{ $item->atributo_info }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span class="text-sm font-medium text-gray-700 shrink-0">${{ number_format($item->precio_unitario * $item->cantidad, 0, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Summary row --}}
                                            <div class="flex flex-wrap items-center justify-between gap-2 text-sm border-t border-gray-200 pt-3">
                                                <div class="flex items-center gap-4 text-gray-500">
                                                    @if($pedido->direccion)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            </svg>
                                                            {{ $pedido->direccion }}, {{ $pedido->ciudad }}
                                                        </span>
                                                    @endif
                                                    @if($pedido->mp_status)
                                                        <span class="flex items-center gap-1">
                                                            MP: {{ $pedido->mp_status }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-base font-bold text-gray-900">Total: ${{ number_format($pedido->total, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('productos.catalogo') }}" class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    Explorar tienda
                </a>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:border-gray-400 text-gray-700 font-medium px-6 py-3 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Editar perfil
                </a>
            </div>

        </div>
    </div>
</x-app-layout>