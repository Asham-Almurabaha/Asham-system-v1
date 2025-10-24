@php
    $faviconData = $appFavicon ?? session('app.favicon', []);

    $fallbackPng   = asset('assets/img/favicon.png');
    $fallbackApple = asset('assets/img/apple-touch-icon.png');

    $settingInstance = $setting ?? null;
    $settingFavicon  = $settingInstance?->favicon_url;

    $faviconHref = data_get($faviconData, 'href') ?: ($settingFavicon ?: $fallbackPng);
    $faviconType = data_get($faviconData, 'type');
    $appleTouch  = data_get($faviconData, 'apple_touch');

    if (!$faviconType) {
        $faviconPath      = parse_url($faviconHref, PHP_URL_PATH);
        $faviconExtension = $faviconPath ? pathinfo($faviconPath, PATHINFO_EXTENSION) : null;
        $extension        = strtolower($faviconExtension ?? '');

        $mimeMap = [
            'ico'  => 'image/x-icon',
            'png'  => 'image/png',
            'svg'  => 'image/svg+xml',
            'gif'  => 'image/gif',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
        ];

        $faviconType = $mimeMap[$extension] ?? 'image/png';

        $appleTouch = $appleTouch
            ?: ($extension && in_array($extension, ['png', 'jpg', 'jpeg', 'webp'], true)
                ? $faviconHref
                : null);
    }

    $appleTouch ??= $fallbackApple;
@endphp

<link rel="icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $appleTouch }}">
