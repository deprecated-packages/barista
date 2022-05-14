<?php

declare(strict_types=1);

namespace Barista\NodeVisitor;

use Barista\Contract\LatteNodeVisitorInterface;
use Barista\Printer\AttributeNodeValuePrinter;
use Latte\Compiler\Node;
use Latte\Compiler\Nodes\Html\AttributeNode;
use Latte\Compiler\Nodes\TextNode;

final class AttributeLatteNodeVisitor implements LatteNodeVisitorInterface
{
    public function __construct(
        private AttributeNodeValuePrinter $attributeNodeValuePrinter = new AttributeNodeValuePrinter()
    ) {
    }

    public function getNodeType(): string
    {
        return AttributeNode::class;
    }

    /**
     * @param AttributeNode $node
     */
    public function enterNode(Node $node): void
    {
        if (! $node->name instanceof TextNode) {
            return;
        }

        $attributeName = $node->name->content;
        if (! str_starts_with($attributeName, 'data-')) {
            return;
        }

        $attributeContent = $this->attributeNodeValuePrinter->print($node);

        // @todo analyse here
        dump($attributeContent);
        die;
    }
}
