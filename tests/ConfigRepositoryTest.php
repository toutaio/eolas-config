<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Success;
use Touta\Eolas\ArrayLoader;
use Touta\Eolas\ConfigRepository;

it('retrieves a top-level value', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['name' => 'MyApp']));

    $result = $config->get('name');

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe('MyApp');
});

it('retrieves a nested value using dot notation', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([
        'database' => ['host' => 'localhost', 'port' => 3306],
    ]));

    $result = $config->get('database.host');

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe('localhost');
});

it('returns failure for missing key', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'MyApp']]));

    $result = $config->get('app.missing');

    expect($result)->toBeInstanceOf(Failure::class);
});

it('returns failure for deeply missing path', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([]));

    $result = $config->get('a.b.c');

    expect($result)->toBeInstanceOf(Failure::class);
});

it('returns a sub-array as value', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([
        'database' => ['host' => 'localhost', 'port' => 3306],
    ]));

    $result = $config->get('database');

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe(['host' => 'localhost', 'port' => 3306]);
});

it('checks existence of a key', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'MyApp']]));

    expect($config->has('app.name'))->toBeTrue()
        ->and($config->has('app.missing'))->toBeFalse();
});

it('merges additional loader data', function (): void {
    $base = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'Base']]));
    $merged = $base->merge(new ArrayLoader(['app' => ['debug' => true]]));

    expect($merged->get('app.name'))->toBeInstanceOf(Success::class)
        ->and($merged->get('app.name')->value())->toBe('Base')
        ->and($merged->get('app.debug'))->toBeInstanceOf(Success::class)
        ->and($merged->get('app.debug')->value())->toBeTrue();
});

it('returns all config data', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['a' => 1, 'b' => 2]));

    expect($config->all())->toBe(['a' => 1, 'b' => 2]);
});
