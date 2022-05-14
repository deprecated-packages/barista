<?php

declare(strict_types=1);

namespace Barista\LatteParser;

use Latte\Compiler\Nodes\TemplateNode;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use Latte\Essential\CoreExtension;
use Latte\Sandbox\SandboxExtension;

final class LatteParser
{
    public function __construct(
        private $templateLexer = new TemplateLexer(),
        private $templateParser = new TemplateParser(),
    ) {
        $extensions = [
            new CoreExtension(),
            new SandboxExtension(),
        ];

        foreach ($extensions as $extension) {
            $this->templateParser->addTags($extension->getTags());
        }
    }

    public function parseCode(string $code): TemplateNode
    {
        return $this->templateParser->parse($code, $this->templateLexer);
    }
}
