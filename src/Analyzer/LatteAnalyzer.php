<?php

declare(strict_types=1);

namespace Barista\Analyzer;

use Barista\LatteParser\LatteParser;
use Barista\NodeTraverser\LatteNodeTraverser;
use Symfony\Component\Console\Style\SymfonyStyle;

final class LatteAnalyzer
{
    public function __construct(
        private LatteParser $latteParser,
        private LatteNodeTraverser $latteNodeTraverser,
        private SymfonyStyle $symfonyStyle,
    ) {
    }

    /**
     * @param \SplFileInfo[] $latteFileInfos
     */
    public function run(array $latteFileInfos): void
    {
        foreach ($latteFileInfos as $latteFileInfo) {
            $this->symfonyStyle->writeln($latteFileInfo->getRealPath());

            $templateNode = $this->latteParser->parseFile($latteFileInfo->getRealPath());

            $this->latteNodeTraverser->traverseNode($templateNode);
        }
    }
}
