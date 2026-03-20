<?php

declare(strict_types=1);

use Touta\Eolas\ConfigKey;

// Scenario: construct branded ConfigKey from valid dot-notation string
it('wraps a config key string', function (): void {
    $key = new ConfigKey('db.host');

    expect($key->value)->toBe('db.host');
});

// Scenario: ConfigKey preserves simple key without dots
it('accepts a simple key without dots', function (): void {
    $key = new ConfigKey('name');

    expect($key->value)->toBe('name');
});

// Scenario: two ConfigKeys with the same value are equal
it('is equal to another ConfigKey with the same value', function (): void {
    $a = new ConfigKey('db.host');
    $b = new ConfigKey('db.host');

    expect($a)->toEqual($b);
});
