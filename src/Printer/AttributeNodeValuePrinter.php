<?php

declare(strict_types=1);

namespace Barista\Printer;

use Latte\Compiler\Nodes\FragmentNode;
use Latte\Compiler\Nodes\Html\AttributeNode;
use Latte\Compiler\Nodes\Html\QuotedValue;
use Latte\Compiler\Nodes\Php\Expression\VariableNode;
use Latte\Compiler\Nodes\TextNode;
use Latte\Essential\Nodes\PrintNode;

final class AttributeNodeValuePrinter
{
    public function print(AttributeNode $attributeNode): ?string
    {
        if (! $attributeNode->value instanceof QuotedValue) {
            return null;
        }

        $quotedValue = $attributeNode->value;
        if (! $quotedValue->value instanceof FragmentNode) {
            return null;
        }

        $fragmentNode = $quotedValue->value;

        $attributeContent = '';

        foreach ($fragmentNode->children as $childNode) {
            if ($childNode instanceof TextNode) {
                $attributeContent .= $childNode->content;
                continue;
            }

            if ($childNode instanceof PrintNode) {
                if($childNode->expression instanceof VariableNode) {
                    $attributeContent .= '{$' . $childNode->expression->name . '}';
                }
            }

        }

        return $attributeContent;
    }
}
