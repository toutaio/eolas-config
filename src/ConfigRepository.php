<?php

declare(strict_types=1);

namespace Touta\Eolas;

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Result;
use Touta\Aria\Runtime\StructuredFailure;
use Touta\Aria\Runtime\Success;

final readonly class ConfigRepository
{
    /**
     * @param array<string, mixed> $data
     */
    private function __construct(
        private array $data,
    ) {}

    public static function fromLoader(ConfigLoaderInterface $loader): self
    {
        return new self($loader->load());
    }

    /**
     * @return Success<mixed>|Failure<StructuredFailure>
     */
    public function get(string $key): Result
    {
        $segments = explode('.', $key);
        $current = $this->data;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return Failure::from(new StructuredFailure(
                    'CONFIG_KEY_NOT_FOUND',
                    "Configuration key \"{$key}\" not found",
                    ['key' => $key],
                ));
            }

            $current = $current[$segment];
        }

        return Success::of($current);
    }

    public function has(string $key): bool
    {
        return $this->get($key)->isSuccess();
    }

    public function merge(ConfigLoaderInterface $loader): self
    {
        /** @var array<string, mixed> $merged */
        $merged = array_replace_recursive($this->data, $loader->load());

        return new self($merged);
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->data;
    }
}
