<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Configuration\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

final class AnalyzeCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('analyze');
        $this->setDescription('Analyze your Latte files using node visitors');
        $this->addArgument(Option::PATHS, InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Path to your Latte files or directories');
    }
}
