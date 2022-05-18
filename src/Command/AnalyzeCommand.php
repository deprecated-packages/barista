<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Analyzer\LatteAnalyzer;
use Barista\Configuration\Option;
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
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $paths = (array) $input->getOption(Option::PATHS);
        $latteFileInfos = $this->latteFilesFinder->find($paths);

        $noteMessage = sprintf('Analying %d files...', count($latteFileInfos));
        $this->symfonyStyle->note($noteMessage);

        $this->latteAnalyzer->run($latteFileInfos);

        return self::SUCCESS;
    }
}
