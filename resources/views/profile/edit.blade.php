<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Perfil</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Greeting --}}
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-sky-600 hover:text-sky-700 font-medium mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver a Mi cuenta
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Configuración de tu cuenta</h1>
                <p class="text-gray-500 mt-1">Administrá tus datos personales y seguridad.</p>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
