@props(['label', 'name', 'id', 'type', 'value', 'placeholder', 'labelClass', 'wrapClass'])

<div @isset($wrapClass)class="{{ $wrapClass }}"@endisset>
    @isset($label)
        <label for="{{ $id ?? $name }}" @isset($labelClass)class="{{ $labelClass }}"@endisset>{{ $label }}</label>
    @endisset
    <input
        {{ $attributes->merge(['class' => 'w-full py-1 border-2 rounded indent-1']) }}
        type="{{ isset($type) ? $type : 'text' }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        @isset($placeholder)
            placeholder="{{ $placeholder }}"
        @endisset
        @isset($value)
            value="{{ $value }}"
        @endisset
    >
</div>