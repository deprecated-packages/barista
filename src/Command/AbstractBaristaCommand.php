<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Configuration\Option;
use Barista\FileSystem\LatteFilesFinder;
use Nette\DI\Attributes\Inject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractBaristaCommand extends Command
{
    #[Inject]
    public SymfonyStyle $symfonyStyle;

    #[Inject]
    public LatteFilesFinder $latteFilesFinder;

    protected function configure(): void
    {
        $this->addArgument(Option::PATHS, InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Path to your Latte files or directories');
    }
}
