<?php

declare(strict_types=1);

namespace Barista\Tests;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteParser\LatteParser;
use Barista\NodeFinder;
use Latte\Compiler\Nodes\TextNode;
use PHPUnit\Framework\TestCase;

final class NodeFinderTest extends TestCase
{
    private LatteParser $latteParser;

    private NodeFinder $nodeFinder;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create();

        $this->latteParser = $container->getByType(LatteParser::class);
        $this->nodeFinder = $container->getByType(NodeFinder::class);
    }

    public function test(): void
    {
        $templateNode = $this->latteParser->parseCode('<span><div>content</div></span>');

        $foundNodes = $this->nodeFinder->findByType($templateNode, TextNode::class);
        $this->assertCount(1, $foundNodes);

        $textNode = $foundNodes[0];
        $this->assertInstanceOf(TextNode::class, $textNode);

        /** @var TextNode $textNode */
        $this->assertSame('content', $textNode->content);
    }
}
