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

    /**
     * @doesNotPerformAssertions
     */
    public function testFilesWithSameBlock(): void
    {
        $this->latteParser->parseFile(__DIR__ . '/Fixture/blocks/first_file.latte');
        $this->latteParser->parseFile(__DIR__ . '/Fixture/blocks/second_file.latte');
    }

    /**
     * @see https://github.com/TomasVotruba/barista/issues/5
     * @doesNotPerformAssertions
     */
    public function testLayoutSecondFile(): void
    {
        $this->latteParser->parseFile(__DIR__ . '/Fixture/layout/first_content.latte');
        $this->latteParser->parseFile(__DIR__ . '/Fixture/layout/second_layout_none.latte');
    }
}
