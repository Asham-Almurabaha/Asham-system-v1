@php
    $brandName = $appName ?? ($setting?->name ?? config('app.name', 'Application'));
    $logoUrl   = $appLogoUrl ?? ($setting?->logo_url ?? asset('assets/img/logo.png'));
    $altText   = $attributes->get('alt', $brandName);
@endphp

<img src="{{ $logoUrl }}" alt="{{ $altText }}" loading="lazy" {{ $attributes->except('alt')->merge([
    'class' => trim(($attributes->get('class') ?? '').' object-contain'),
]) }}>
