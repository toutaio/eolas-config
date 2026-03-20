<?php

declare(strict_types=1);

namespace Touta\Eolas;

final readonly class ArrayLoader implements ConfigLoaderInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private array $data,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function load(): array
    {
        return $this->data;
    }
}
