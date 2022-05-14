<?php

declare(strict_types=1);

namespace Barista\NodeTraverser;

use Barista\Contract\LatteNodeVisitorInterface;
use Latte\Compiler\Node;
use Latte\Compiler\Nodes\TemplateNode;
use Latte\Compiler\NodeTraverser;

/**
 * Same as native one, just object oriented
 */
final class LatteNodeTraverser
{
    /**
     * @param LatteNodeVisitorInterface[] $latteNodeVisitors
     */
    public function __construct(
        private array $latteNodeVisitors,
        private NodeTraverser $nodeTraverser = new NodeTraverser(),
    ) {
    }

    public function traverseNode(TemplateNode $templateNode): void
    {
        foreach ($this->latteNodeVisitors as $latteNodeVisitor) {
            $this->nodeTraverser->traverse($templateNode, function (Node $node) use ($latteNodeVisitor) {
                if (! is_a($node, $latteNodeVisitor->getNodeType(), true)) {
                    return null;
                }

                $latteNodeVisitor->enterNode($node);
                return null;
            });
        }
    }
}
