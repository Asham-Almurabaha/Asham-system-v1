@props(['status' => null])
@if($status)
    <div {{ $attributes->merge(['class' => 'mb-4 text-success']) }}>
        {{ $status }}
    </div>
@endif
