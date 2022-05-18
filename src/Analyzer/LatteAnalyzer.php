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
     * @param string[] $filePaths
     */
    public function run(array $filePaths): int
    {
        foreach ($filePaths as $filePath) {
            $templateNode = $this->latteParser->parseFile($filePath);
            $this->latteNodeTraverser->traverseNode($templateNode);
        }

        // success
        return 0;
    }
}
