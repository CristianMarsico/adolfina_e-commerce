<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-sky-500 border border-transparent rounded-full font-medium text-sm text-white hover:bg-sky-600 focus:bg-sky-600 active:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors shadow-sm']) }}>
    {{ $slot }}
</button>
