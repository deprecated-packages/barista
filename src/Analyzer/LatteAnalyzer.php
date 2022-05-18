<?php

declare(strict_types=1);

namespace Barista\Analyzer;

use Barista\LatteParser\LatteParser;
use Barista\NodeTraverser\LatteNodeTraverser;

final class LatteAnalyzer
{
    public function __construct(
        private LatteParser $latteParser,
        private LatteNodeTraverser $latteNodeTraverser,
    ) {
    }

    /**
     * @param \SplFileInfo[] $latteFileInfos
     */
    public function run(array $latteFileInfos): void
    {
        foreach ($latteFileInfos as $latteFileInfo) {
            $templateNode = $this->latteParser->parseFile($latteFileInfo->getRealPath());

            $this->latteNodeTraverser->traverseNode($templateNode);
        }
    }
}
