<?php

declare(strict_types=1);

namespace Barista;

use Latte\Compiler\Node;
use Latte\Compiler\NodeTraverser;

final class NodeFinder
{
    /**
     * @template TNode as Node
     * @param class-string<TNode> $nodeType
     * @return TNode[]
     */
    public function findByType(Node $node, string $nodeType): array
    {
        $foundNodes = [];

        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->traverse($node, function (Node $node) use (&$foundNodes, $nodeType) {
            if (! is_a($node, $nodeType, true)) {
                return null;
            }

            $foundNodes[] = $node;
        });

        return $foundNodes;
    }
}
