<?php

declare(strict_types=1);

namespace Barista\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class UpgradeCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('upgrade');
        $this->setDescription('Upgrade what you can from Latte 2 to 3');
        $this->addArgument('paths', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Add description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 1) @take paths
        // 2) run upgrader
        // 3) dump or dry-run :)
        return self::SUCCESS;
    }
}
