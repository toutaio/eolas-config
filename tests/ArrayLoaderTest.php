<?php

declare(strict_types=1);

use Touta\Eolas\ArrayLoader;

// Scenario: load flat config array via ArrayLoader
it('loads configuration from a flat array', function (): void {
    $loader = new ArrayLoader(['app' => ['name' => 'MyApp']]);

    $data = $loader->load();

    expect($data)->toBe(['app' => ['name' => 'MyApp']]);
});

// Scenario: load nested config array via ArrayLoader
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

// Scenario: load empty config array via ArrayLoader
it('loads empty configuration', function (): void {
    $loader = new ArrayLoader([]);

    $data = $loader->load();

    expect($data)->toBe([]);
});
