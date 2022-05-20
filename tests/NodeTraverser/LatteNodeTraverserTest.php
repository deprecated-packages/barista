<?php

declare(strict_types=1);

namespace Barista\Tests\NodeTraverser;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteParser\LatteParser;
use Barista\NodeTraverser\LatteNodeTraverser;
use Barista\Tests\NodeTraverser\NodeVisitor\DummyLatteNodeVisitor;
use PHPUnit\Framework\TestCase;

final class LatteNodeTraverserTest extends TestCase
{
    private LatteParser $latteParser;

    private LatteNodeTraverser $latteNodeTraverser;

    private DummyLatteNodeVisitor $dummyLatteNodeVisitor;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create([
            __DIR__ . '/config/custom_node_visitor.neon',
        ]);

        $this->latteParser = $container->getByType(LatteParser::class);
        $this->latteNodeTraverser = $container->getByType(LatteNodeTraverser::class);

        $this->dummyLatteNodeVisitor = $container->getByType(DummyLatteNodeVisitor::class);
    }

    public function test(): void
    {
        $templateNode = $this->latteParser->parseCode('<a href="..."></a>');
        $this->latteNodeTraverser->traverseNode($templateNode);

        $this->assertCount(1, $this->dummyLatteNodeVisitor->getAttributeNodes());
    }
}
