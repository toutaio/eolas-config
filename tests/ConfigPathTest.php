<?php

declare(strict_types=1);

use Touta\Eolas\ConfigPath;

// Scenario: wrap a file path string for config loading
it('wraps a file path string', function (): void {
    $path = new ConfigPath('/etc/app/config.php');

    expect($path->value)->toBe('/etc/app/config.php');
});

// Scenario: two ConfigPaths with the same value are equal
it('is equal to another ConfigPath with the same value', function (): void {
    $a = new ConfigPath('/etc/config.yaml');
    $b = new ConfigPath('/etc/config.yaml');

    expect($a)->toEqual($b);
});
