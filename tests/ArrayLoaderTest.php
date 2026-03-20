<?php

declare(strict_types=1);

use Touta\Eolas\ArrayLoader;

it('loads configuration from a flat array', function (): void {
    $loader = new ArrayLoader(['app' => ['name' => 'MyApp']]);

    $data = $loader->load();

    expect($data)->toBe(['app' => ['name' => 'MyApp']]);
});

it('loads configuration from nested arrays', function (): void {
    $loader = new ArrayLoader([
        'database' => [
            'host' => 'localhost',
            'port' => 3306,
        ],
    ]);

    $data = $loader->load();

    expect($data)->toBe([
        'database' => [
            'host' => 'localhost',
            'port' => 3306,
        ],
    ]);
});

it('loads empty configuration', function (): void {
    $loader = new ArrayLoader([]);

    $data = $loader->load();

    expect($data)->toBe([]);
});
