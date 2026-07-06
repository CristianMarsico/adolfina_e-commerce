@extends('layouts.tienda')

@section('title', 'Finalizar compra')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Finalizar compra</h1>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.procesar') }}" method="POST" class="grid md:grid-cols-5 gap-8">
        @csrf

        <div class="md:col-span-3 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Dirección de envío</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $user->direccion ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm">
                        @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad') }}" required class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm">
                            @error('ciudad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal *</label>
                            <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}" required class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm">
                            @error('codigo_postal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $user->telefono ?? '') }}" required class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm">
                        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumen</h2>
                <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    @foreach($cart as $key => $item)
                        @php $p = $productos->get($item['producto_id']); @endphp
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-10 h-10 bg-gray-100 rounded shrink-0 flex items-center justify-center overflow-hidden">
                                @if($p && $p->imagenPrincipal)
                                    <img src="{{ asset('storage/' . $p->imagenPrincipal->path) }}" alt="" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 truncate">{{ $item['nombre'] }} <span class="text-gray-400">x{{ $item['cantidad'] }}</span></p>
                                @if(!empty($item['atributo_nombre']))
                                    <p class="text-xs text-gray-500">{{ $item['atributo_nombre'] }}</p>
                                @endif
                            </div>
                            <p class="font-semibold text-gray-800">${{ number_format(($p && $p->precio_oferta ? $p->precio_oferta : $item['precio']) * $item['cantidad'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                    @if($descuentoTotal > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($total + $descuentoTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Descuento</span>
                            <span>-${{ number_format($descuentoTotal, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                        <span>Total</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-full transition-colors">
                    Ir a pagar
                </button>
                <p class="text-xs text-gray-400 text-center mt-2">Serás redirigido a Mercado Pago</p>
            </div>
        </div>
    </form>
</div>
@endsection
