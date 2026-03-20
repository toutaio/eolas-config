<?php

declare(strict_types=1);

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Success;
use Touta\Eolas\ArrayLoader;
use Touta\Eolas\ConfigError;
use Touta\Eolas\ConfigKey;
use Touta\Eolas\ConfigRepository;

// Scenario: retrieve top-level value by ConfigKey
it('retrieves a top-level value', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['name' => 'MyApp']));

    $result = $config->get(new ConfigKey('name'));

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe('MyApp');
});

// Scenario: retrieve nested value using dot-notation ConfigKey
it('retrieves a nested value using dot notation', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([
        'database' => ['host' => 'localhost', 'port' => 3306],
    ]));

    $result = $config->get(new ConfigKey('database.host'));

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe('localhost');
});

// Scenario: return Failure with ConfigError for missing key
it('returns failure for missing key', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'MyApp']]));

    $result = $config->get(new ConfigKey('app.missing'));

    expect($result)->toBeInstanceOf(Failure::class)
        ->and($result->error())->toBeInstanceOf(ConfigError::class)
        ->and($result->error()->code)->toBe(ConfigError::KEY_NOT_FOUND);
});

// Scenario: return Failure with ConfigError for deeply missing path
it('returns failure for deeply missing path', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([]));

    $result = $config->get(new ConfigKey('a.b.c'));

    expect($result)->toBeInstanceOf(Failure::class)
        ->and($result->error())->toBeInstanceOf(ConfigError::class)
        ->and($result->error()->code)->toBe(ConfigError::KEY_NOT_FOUND);
});

// Scenario: retrieve sub-array as value by ConfigKey
it('returns a sub-array as value', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader([
        'database' => ['host' => 'localhost', 'port' => 3306],
    ]));

    $result = $config->get(new ConfigKey('database'));

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->value())->toBe(['host' => 'localhost', 'port' => 3306]);
});

// Scenario: check key existence using ConfigKey
it('checks existence of a key', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'MyApp']]));

    expect($config->has(new ConfigKey('app.name')))->toBeTrue()
        ->and($config->has(new ConfigKey('app.missing')))->toBeFalse();
});

// Scenario: merge additional loader and query merged keys
it('merges additional loader data', function (): void {
    $base = ConfigRepository::fromLoader(new ArrayLoader(['app' => ['name' => 'Base']]));
    $merged = $base->merge(new ArrayLoader(['app' => ['debug' => true]]));

    expect($merged->get(new ConfigKey('app.name')))->toBeInstanceOf(Success::class)
        ->and($merged->get(new ConfigKey('app.name'))->value())->toBe('Base')
        ->and($merged->get(new ConfigKey('app.debug')))->toBeInstanceOf(Success::class)
        ->and($merged->get(new ConfigKey('app.debug'))->value())->toBeTrue();
});

// Scenario: return all config data as raw array
it('returns all config data', function (): void {
    $config = ConfigRepository::fromLoader(new ArrayLoader(['a' => 1, 'b' => 2]));

    expect($config->all())->toBe(['a' => 1, 'b' => 2]);
});
