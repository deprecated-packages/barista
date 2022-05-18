<?php

declare(strict_types=1);

namespace Barista\Tests\LatteParser;

use Barista\LatteParser\LatteParser;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use Nette\Bridges\ApplicationLatte\Nodes\TranslateNode;
use PHPUnit\Framework\TestCase;

final class LatteParserTest extends TestCase
{
    private LatteParser $latteParser;

    protected function setUp(): void
    {
        $this->latteParser =  new LatteParser(
            new TemplateLexer(),
            new TemplateParser(),
        );
    }

    public function test(): void
    {
        $templateNode = $this->latteParser->parseFile(__DIR__ . '/Fixture/translate_tag.latte');

        $this->assertCount(2, $templateNode->main->children);
        $this->assertInstanceOf(TranslateNode::class, $templateNode->main->children[0]);
    }
}
