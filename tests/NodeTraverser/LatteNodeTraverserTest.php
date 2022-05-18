<?php

declare(strict_types=1);

namespace Barista\Tests\NodeTraverser;

use Barista\LatteParser\LatteParser;
use Barista\NodeTraverser\LatteNodeTraverser;
use Barista\Tests\NodeTraverser\NodeVisitor\DummyLatteNodeVisitor;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use PHPUnit\Framework\TestCase;

final class LatteNodeTraverserTest extends TestCase
{
    private LatteParser $latteParser;

    protected function setUp(): void
    {
        $this->latteParser = new LatteParser(
            new TemplateLexer(),
            new TemplateParser(),
        );
    }

    public function test(): void
    {
        $templateNode = $this->latteParser->parseCode('<a href="..."></a>');

        $dummyLatteNodeVisitor = new DummyLatteNodeVisitor();
        $latteNodeTraverser = new LatteNodeTraverser([$dummyLatteNodeVisitor]);
        $latteNodeTraverser->traverseNode($templateNode);

        $this->assertCount(1, $dummyLatteNodeVisitor->getAttributeNodes());
    }
}