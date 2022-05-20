<?php

// example for custom latte-provider.php for "lint" command
// see README.md for more

declare(strict_types=1);

use Latte\Engine;
use Latte\Essential\CoreExtension;

$customLatteEngine = new Engine();
$customLatteEngine->addExtension(new CoreExtension());

return $customLatteEngine;
