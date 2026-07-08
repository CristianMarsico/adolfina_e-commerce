@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-green-50 border border-green-200 rounded-lg px-4 py-3']) }}>
        <p class="text-sm text-green-700 font-medium">{{ $status }}</p>
    </div>
@endif
