<?php

declare(strict_types=1);

use Touta\Eolas\EnvOverlayLoader;

it('overlays environment variables onto base config', function (): void {
    $base = ['app' => ['name' => 'MyApp', 'debug' => false]];
    $env = ['APP_NAME' => 'OverriddenApp', 'APP_DEBUG' => 'true'];
    $map = [
        'APP_NAME' => 'app.name',
        'APP_DEBUG' => 'app.debug',
    ];

    $loader = new EnvOverlayLoader($base, $map, $env);
    $data = $loader->load();

    expect($data['app']['name'])->toBe('OverriddenApp')
        ->and($data['app']['debug'])->toBe('true');
});

it('preserves base values when env vars are absent', function (): void {
    $base = ['app' => ['name' => 'MyApp']];
    $map = ['APP_NAME' => 'app.name'];

    $loader = new EnvOverlayLoader($base, $map, []);
    $data = $loader->load();

    expect($data['app']['name'])->toBe('MyApp');
});

it('creates nested keys from dot notation', function (): void {
    $base = [];
    $env = ['DB_HOST' => 'localhost'];
    $map = ['DB_HOST' => 'database.host'];

    $loader = new EnvOverlayLoader($base, $map, $env);
    $data = $loader->load();

    expect($data['database']['host'])->toBe('localhost');
});
