@props(['type' => 'success', 'message'])

@php
    $classes = [
        'success' => 'bg-green-100 border-l-4 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-l-4 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-l-4 border-blue-500 text-blue-700',
    ][$type];
@endphp

<div {{ $attributes->merge(['class' => $classes . ' p-4 mb-4']) }}>
    {{ $message }}
</div>
