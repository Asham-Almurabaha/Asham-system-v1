@props(['for' => null, 'value' => null])
<label {{ $attributes->merge(['for' => $for]) }}>
    {{ $value ?? $slot }}
</label>
