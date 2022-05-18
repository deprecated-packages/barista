<?php

declare(strict_types=1);

namespace Barista\Tests\LatteParser;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteParser\LatteParser;
use Nette\Bridges\ApplicationLatte\Nodes\TranslateNode;
use PHPUnit\Framework\TestCase;

final class LatteParserTest extends TestCase
{
    private LatteParser $latteParser;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create();

        $this->latteParser = $container->getByType(LatteParser::class);
    }

    public function test(): void
    {
        $templateNode = $this->latteParser->parseFile(__DIR__ . '/Fixture/translate_tag.latte');

        $this->assertCount(2, $templateNode->main->children);
        $this->assertInstanceOf(TranslateNode::class, $templateNode->main->children[0]);
    }
}
