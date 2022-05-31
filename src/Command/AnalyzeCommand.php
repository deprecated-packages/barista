<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Analyzer\LatteAnalyzer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AnalyzeCommand extends AbstractBaristaCommand
{
    public function __construct(
        private LatteAnalyzer $latteAnalyzer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('analyze');
        $this->setDescription('Analyze your Latte files using node visitors');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $latteFileInfos = $this->findLatteFileInfos($input);

        $noteMessage = sprintf('Analyzing %d files...', count($latteFileInfos));
        $this->symfonyStyle->title($noteMessage);

        $this->latteAnalyzer->run($latteFileInfos);

        $this->symfonyStyle->success('Done');

        return self::SUCCESS;
    }
}
