<?php

declare(strict_types=1);

namespace Touta\Eolas;

final readonly class EnvOverlayLoader implements ConfigLoaderInterface
{
    /**
     * @param array<string, mixed> $base
     * @param array<string, string> $envMap Maps env var names to dot-notation config paths
     * @param array<string, string> $envValues Environment variable values (defaults to getenv() if empty)
     */
    public function __construct(
        private array $base,
        private array $envMap,
        private array $envValues = [],
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function load(): array
    {
        $data = $this->base;

        foreach ($this->envMap as $envKey => $configPath) {
            $value = $this->envValues[$envKey] ?? null;

            if ($value === null) {
                continue;
            }

            $data = self::setNested($data, explode('.', $configPath), $value);
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @param list<string> $keys
     *
     * @return array<string, mixed>
     */
    private static function setNested(array $data, array $keys, mixed $value): array
    {
        $key = array_shift($keys);

        if ($keys === []) {
            $data[$key] = $value;

            return $data;
        }

        /** @var array<string, mixed> $nested */
        $nested = isset($data[$key]) && is_array($data[$key]) ? $data[$key] : [];
        $data[$key] = self::setNested($nested, $keys, $value);

        return $data;
    }
}
