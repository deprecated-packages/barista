<?php

declare(strict_types=1);

namespace Barista;

use Barista\LatteParser\LatteParser;
use Latte\Compiler\Node;
use Latte\Compiler\Nodes\Html\AttributeNode;
use Latte\Compiler\Nodes\Html\ElementNode;
use Latte\Compiler\Nodes\TextNode;
use Latte\Compiler\NodeTraverser;
use Nette\Utils\FileSystem;

final class LatteAnalyzer
{
    public function __construct(
        private LatteParser $latteParser,
    ) {
    }

    /**
     * @param string[] $filePaths
     */
    public function run(array $filePaths)
    {
        foreach ($filePaths as $file) {
            $fileContent = FileSystem::read($file);
            $templateNode = $this->latteParser->parseCode($fileContent);

            $nodeTraverser = new NodeTraverser();
            $nodeTraverser->traverse($templateNode, function (Node $node) {
                if (! $node instanceof ElementNode) {
                    return null;
                }

                if ($node->name !== 'a') {
                    return null;
                }

                foreach ($node->attributes?->children as $attribute) {
                    if (! $attribute instanceof AttributeNode) {
                        continue;
                    }

                    if (! $attribute->name instanceof TextNode) {
                        continue;
                    }

                    $attributeName = $attribute->name->content;
                    if (! str_starts_with($attributeName, 'data-')) {
                        continue;
                    }

                    dump($attribute->value);
                }
            });
        }

        // @todo add latte node visitor
    }
}
