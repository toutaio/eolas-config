<?php

declare(strict_types=1);

namespace Touta\Eolas;

final readonly class ConfigError
{
    public const KEY_NOT_FOUND = 'CONFIG.KEY_NOT_FOUND';
    public const LOADER_FAILED = 'CONFIG.LOADER_FAILED';
    public const INVALID_FORMAT = 'CONFIG.INVALID_FORMAT';
    public const MERGE_FAILED = 'CONFIG.MERGE_FAILED';

    public function __construct(
        public string $code,
        public string $message,
        /** @var array<string, mixed> */
        public array $context = [],
    ) {}

    public function withMessage(string $message): self
    {
        return new self($this->code, $message, $this->context);
    }

    /** @param array<string, mixed> $context */
    public function withContext(array $context): self
    {
        return new self($this->code, $this->message, array_merge($this->context, $context));
    }
}
