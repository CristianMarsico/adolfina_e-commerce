<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Verificá tu email</h1>
        <p class="text-sm text-gray-500 mt-1">Gracias por registrarte. Antes de empezar, verificá tu dirección de email haciendo clic en el enlace que te enviamos.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-6">
            <p class="text-sm text-green-700 font-medium">Se ha enviado un nuevo enlace de verificación al email que proporcionaste.</p>
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-medium px-6 py-2.5 rounded-full transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Reenviar email de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-medium px-6 py-2.5 rounded-full transition-colors border border-gray-300 shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
