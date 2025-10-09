@php
    $customFavicon = $favicon ?? null;

    if (!$customFavicon && !empty($setting?->favicon_url)) {
        $customFavicon = $setting->favicon_url;
    }

    if (!$customFavicon && !empty($setting?->favicon)) {
        $customFavicon = asset('storage/' . $setting->favicon);
    }

    $defaultPngFavicon   = asset('assets/img/favicon.png');
    $defaultAppleIcon    = asset('assets/img/apple-touch-icon.png');

    $faviconHref         = $customFavicon ?? $defaultPngFavicon;
    $faviconPath         = parse_url($faviconHref, PHP_URL_PATH);
    $faviconExtension    = $faviconPath ? pathinfo($faviconPath, PATHINFO_EXTENSION) : null;
    $extension           = strtolower($faviconExtension ?? '');

    $mimeMap = [
        'ico'  => 'image/x-icon',
        'png'  => 'image/png',
        'svg'  => 'image/svg+xml',
        'gif'  => 'image/gif',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
    ];

    $faviconType      = $mimeMap[$extension] ?? 'image/png';
    $appleTouchHref   = $customFavicon && in_array($extension, ['png', 'jpg', 'jpeg', 'webp'], true)
        ? $customFavicon
        : $defaultAppleIcon;
@endphp

<link rel="icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $appleTouchHref }}">
