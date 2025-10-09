@php
    $customFavicon = $favicon ?? ($setting?->favicon ? asset('storage/'.$setting->favicon) : null);
    $defaultFavicon = asset('favicon.ico');
    $defaultAppleIcon = asset('assets/img/apple-touch-icon.png');

    $faviconHref = $customFavicon ?? $defaultFavicon;
    $appleTouchHref = $customFavicon ?? $defaultAppleIcon;
@endphp

<link rel="icon" href="{{ $faviconHref }}" type="image/x-icon">
<link rel="apple-touch-icon" href="{{ $appleTouchHref }}">
