<?php

declare(strict_types=1);

namespace Touta\Eolas;

use Touta\Aria\Runtime\Failure;
use Touta\Aria\Runtime\Result;
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
     * @return Success<mixed>|Failure<ConfigError>
     */
    public function get(ConfigKey $key): Result
    {
        $raw = $key->value;
        $segments = explode('.', $raw);
        $current = $this->data;

        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return Failure::from(new ConfigError(
                    ConfigError::KEY_NOT_FOUND,
                    "Configuration key \"{$raw}\" not found",
                    ['key' => $raw],
                ));
            }

            $current = $current[$segment];
        }

        return Success::of($current);
    }

    public function has(ConfigKey $key): bool
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
