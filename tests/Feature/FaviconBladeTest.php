<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Modules\Settings\Models\Setting;
use Tests\TestCase;

class FaviconBladeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['filesystems.default' => 'public']);
        Storage::fake('public');

        $session = app('session');
        $session->start();
        $session->forget('app.favicon');
    }

    public function test_partial_prefers_session_data(): void
    {
        $session = app('session');
        $session->put('app.favicon', [
            'href'        => 'https://example.com/favicon.ico',
            'type'        => 'image/x-icon',
            'apple_touch' => 'https://example.com/apple-touch.png',
        ]);

        $setting = new Setting(['favicon' => 'favicons/icon.png']);

        $html = view('layouts.partials.favicon', [
            'setting' => $setting,
        ])->render();

        $this->assertStringContainsString('href="https://example.com/favicon.ico"', $html);
        $this->assertStringContainsString('type="image/x-icon"', $html);
        $this->assertStringContainsString('<link rel="apple-touch-icon" href="https://example.com/apple-touch.png">', $html);
    }

    public function test_partial_falls_back_to_setting_accessor(): void
    {
        $session = app('session');
        $session->forget('app.favicon');

        $setting = new Setting(['favicon' => 'favicons/icon.png']);
        $expectedUrl = Storage::url('favicons/icon.png');

        $html = view('layouts.partials.favicon', [
            'setting' => $setting,
        ])->render();

        $this->assertStringContainsString('href="'.$expectedUrl.'"', $html);
        $this->assertStringContainsString('<link rel="apple-touch-icon" href="'.$expectedUrl.'">', $html);
    }
}
