# The Barista makes Your Perfectly Tasty Latte

Do you drink [Latte](https://latte.nette.org/en/) with your templates?

Get it from Barista that knows his job:

* explore Latte via node visitors
* upgrade Latte 2 to 3
* lint your Latte files with context of your project


## Lint Your Files with Custom Macros and Filters

Native latte linter does not understand the context of your project. If you use custom macros or filters, it will be falsely reported as missing. The Barista Linter fixes this.

To get context aware Latte, we have to provide it via custom PHP file. This file must return the `Latte\Engine` from your project. Create e.g. `tests/latte-provider.php` with following content:

```php
use App\DI\ContainerFactory;
use Nette\Bridges\ApplicationLatte\LatteFactory

$containerFactory = new ContainerFactory();
$container = $containerFactory->create();

/** @var LatteFactory $latteFactory */
$latteFactory = $container->getByType(LatteFactory::class);
return $latteFactory->create();
```

Create `barista.neon` in your root and configure parameter:

```yaml
parameters:
    latteProviderFile: "tests/latte-provider.php"
```

Then run linting command on your paths:

```bash
vendor/bin/barista lint templates/some-file.latte
```

Then linter knows about all your macros and functions and reports only real bugs!
