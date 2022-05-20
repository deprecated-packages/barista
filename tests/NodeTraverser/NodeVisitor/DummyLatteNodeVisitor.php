<?php

declare(strict_types=1);

namespace Barista\Tests\NodeTraverser\NodeVisitor;

use Barista\Contract\LatteNodeVisitorInterface;
use Latte\Compiler\Node;
use Latte\Compiler\Nodes\Html\AttributeNode;

/**
 * @implements LatteNodeVisitorInterface<AttributeNode>
 */
final class DummyLatteNodeVisitor implements LatteNodeVisitorInterface
{
    /**
     * @var AttributeNode[]
     */
    private array $attributeNodes = [];

    public function getNodeType(): string
    {
        return AttributeNode::class;
    }

    public function enterNode(Node $node): int|null|Node
    {
        $this->attributeNodes[] = $node;
        return null;
    }

    /**
     * @return AttributeNode[]
     */
    public function getAttributeNodes(): array
    {
        return $this->attributeNodes;
    }
}
