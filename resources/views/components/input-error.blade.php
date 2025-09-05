@props(['messages' => []])
@if($messages)
    @foreach((array)$messages as $message)
        <p {{ $attributes->merge(['class' => 'text-danger']) }}>{{ $message }}</p>
    @endforeach
@endif
