<?php

declare(strict_types=1);

use Touta\Eolas\ConfigError;

// Scenario: construct ConfigError with code and message
it('holds code and message', function (): void {
    $error = new ConfigError(ConfigError::KEY_NOT_FOUND, 'Key "db.host" not found');

    expect($error->code)->toBe('CONFIG.KEY_NOT_FOUND')
        ->and($error->message)->toBe('Key "db.host" not found')
        ->and($error->context)->toBe([]);
});

// Scenario: construct ConfigError with context
it('holds optional context', function (): void {
    $error = new ConfigError(
        ConfigError::LOADER_FAILED,
        'File not found',
        ['path' => '/etc/config.php'],
    );

    expect($error->context)->toBe(['path' => '/etc/config.php']);
});

// Scenario: create new ConfigError with different message via withMessage
it('creates a new instance with a different message', function (): void {
    $original = new ConfigError(ConfigError::KEY_NOT_FOUND, 'original');
    $updated = $original->withMessage('updated');

    expect($updated->message)->toBe('updated')
        ->and($updated->code)->toBe(ConfigError::KEY_NOT_FOUND)
        ->and($original->message)->toBe('original');
});

// Scenario: merge additional context via withContext
it('merges additional context', function (): void {
    $original = new ConfigError(ConfigError::MERGE_FAILED, 'fail', ['a' => 1]);
    $updated = $original->withContext(['b' => 2]);

    expect($updated->context)->toBe(['a' => 1, 'b' => 2])
        ->and($original->context)->toBe(['a' => 1]);
});

// Scenario: all error code constants are defined
it('defines all error code constants', function (): void {
    expect(ConfigError::KEY_NOT_FOUND)->toBe('CONFIG.KEY_NOT_FOUND')
        ->and(ConfigError::LOADER_FAILED)->toBe('CONFIG.LOADER_FAILED')
        ->and(ConfigError::INVALID_FORMAT)->toBe('CONFIG.INVALID_FORMAT')
        ->and(ConfigError::MERGE_FAILED)->toBe('CONFIG.MERGE_FAILED');
});
