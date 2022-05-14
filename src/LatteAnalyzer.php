<?php

declare(strict_types=1);

namespace Barista;

use Barista\LatteParser\LatteParser;
use Barista\NodeTraverser\LatteNodeTraverser;
use Barista\NodeVisitor\AttributeLatteNodeVisitor;

final class LatteAnalyzer
{
    public function __construct(
        private readonly LatteParser $latteParser,
        private readonly LatteNodeTraverser $latteNodeTraverser = new LatteNodeTraverser([new AttributeLatteNodeVisitor()])
    ) {
    }

    /**
     * @param string[] $filePaths
     */
    public function run(array $filePaths)
    {
        foreach ($filePaths as $filePath) {
            $templateNode = $this->latteParser->parseFile($filePath);
            $this->latteNodeTraverser->traverseNode($templateNode);
        }

        // @todo add latte node visitor
    }
}
