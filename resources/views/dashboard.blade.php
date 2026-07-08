@php
    $estado = request('estado', '');
    $orden = request('orden', 'desc');

    $pedidos = \App\Models\Pedido::ofUser(Auth::id())
        ->when($estado, fn($q, $v) => $q->where('estado', $v))
        ->orderBy('created_at', $orden === 'asc' ? 'asc' : 'desc')
        ->get();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi cuenta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
            @endif

            {{-- Pedidos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Mis pedidos</h3>

                        <form method="GET" class="flex flex-wrap items-center gap-3">
                            <select name="estado" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-sky-500 focus:border-sky-500">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" @selected(request('estado') === 'pendiente')>Pendiente</option>
                                <option value="pagado" @selected(request('estado') === 'pagado')>Pagado</option>
                                <option value="fallado" @selected(request('estado') === 'fallado')>Fallado</option>
                            </select>

                            <select name="orden" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-sky-500 focus:border-sky-500">
                                <option value="desc" @selected(request('orden', 'desc') === 'desc')>Más recientes</option>
                                <option value="asc" @selected(request('orden') === 'asc')>Más antiguos</option>
                            </select>
                        </form>
                    </div>

                    @if($pedidos->isEmpty())
                        <p class="text-gray-500 text-sm">No tenés pedidos todavía.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-600">
                                        <th class="text-left py-3 px-2">#</th>
                                        <th class="text-left py-3 px-2">Fecha</th>
                                        <th class="text-left py-3 px-2">Total</th>
                                        <th class="text-left py-3 px-2">Estado</th>
                                        <th class="text-left py-3 px-2">Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedidos as $pedido)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="py-3 px-2 font-medium">{{ $pedido->id }}</td>
                                            <td class="py-3 px-2 text-gray-600">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="py-3 px-2 font-medium">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                                            <td class="py-3 px-2">
                                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                                    @switch($pedido->estado)
                                                        @case('pagado') bg-green-100 text-green-700 @break
                                                        @case('pendiente') bg-yellow-100 text-yellow-700 @break
                                                        @case('fallado') bg-red-100 text-red-700 @break
                                                        @default bg-gray-100 text-gray-600
                                                    @endswitch
                                                ">{{ ucfirst($pedido->estado) }}</span>
                                            </td>
                                            <td class="py-3 px-2 text-gray-500 text-xs">{{ $pedido->mp_status ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Ir a la tienda --}}
            <div class="text-center">
                <a href="{{ route('productos.catalogo') }}" class="inline-block bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-3 rounded-full transition-colors">
                    Explorar página
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
