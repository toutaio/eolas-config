<?php

declare(strict_types=1);

namespace Touta\Eolas;

interface ConfigLoaderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function load(): array;
}
