@php
    $sessionFaviconData = session('app.favicon', []);
    $sessionFavicon     = data_get($sessionFaviconData, 'href');
    $sessionFaviconType = data_get($sessionFaviconData, 'type');
    $sessionAppleTouch  = data_get($sessionFaviconData, 'apple_touch');

    $customFavicon = $favicon ?? null;

    if (!$customFavicon && $sessionFavicon) {
        $customFavicon = $sessionFavicon;
    }

    if (!$customFavicon) {
        $settingInstance = $setting ?? null;

        if (!$settingInstance || empty($settingInstance->favicon_url)) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                    $settingInstance = \Illuminate\Support\Facades\Cache::remember(
                        'app.setting.latest',
                        3600,
                        static fn () => \Modules\Settings\Models\Setting::query()->latest('id')->first()
                    );
                }
            } catch (\Throwable $e) {
                $settingInstance = null;
            }
        }

        if ($settingInstance && !empty($settingInstance->favicon_url)) {
            $customFavicon = $settingInstance->favicon_url;
        }
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

    $faviconType      = $sessionFaviconType ?? ($mimeMap[$extension] ?? 'image/png');
    $appleTouchHref   = $sessionAppleTouch
        ?: ($customFavicon && in_array($extension, ['png', 'jpg', 'jpeg', 'webp'], true)
            ? $customFavicon
            : $defaultAppleIcon);
@endphp

<link rel="icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconHref }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $appleTouchHref }}">
