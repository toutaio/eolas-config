<?php

declare(strict_types=1);

namespace Touta\Eolas;

final readonly class ConfigKey
{
    public function __construct(
        public string $value,
    ) {}
}
