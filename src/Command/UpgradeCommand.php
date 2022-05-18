<?php

declare(strict_types=1);

namespace Barista\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class UpgradeCommand extends Command
{
    // 1) @take paths
    // 2) run upgrader
    // 3) dump or dry-run :)
    protected function configure(): void
    {
        $this->setName('upgrade');
        $this->setDescription('Upgrade from Latte 2 to 3');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return self::SUCCESS;
    }
}
