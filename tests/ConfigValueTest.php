<?php

declare(strict_types=1);

use Touta\Eolas\ConfigValue;

// Scenario: wrap a string config value
it('wraps a string value', function (): void {
    $val = new ConfigValue('hello');

    expect($val->value)->toBe('hello');
});

// Scenario: wrap an integer config value
it('wraps an integer value', function (): void {
    $val = new ConfigValue(42);

    expect($val->value)->toBe(42);
});

// Scenario: wrap an array config value
it('wraps an array value', function (): void {
    $val = new ConfigValue(['a' => 1]);

    expect($val->value)->toBe(['a' => 1]);
});

// Scenario: wrap a null config value
it('wraps null', function (): void {
    $val = new ConfigValue(null);

    expect($val->value)->toBeNull();
});
