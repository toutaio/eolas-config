<?php

declare(strict_types=1);

namespace Touta\Eolas;

final readonly class ConfigValue
{
    public function __construct(
        public mixed $value,
    ) {}
}
