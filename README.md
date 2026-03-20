# Eolas Config

Configuration loading, merging, and typed access for the Touta PHP ecosystem.

## Install

```bash
composer require touta/eolas-config
```

## Usage

```php
use Touta\Eolas\ConfigRepository;
use Touta\Eolas\ArrayLoader;

$loader = new ArrayLoader(['app' => ['name' => 'MyApp', 'debug' => true]]);
$config = ConfigRepository::fromLoader($loader);

$name = $config->get('app.name');    // Success('MyApp')
$missing = $config->get('app.foo');  // Failure(...)
```

## License

MIT
