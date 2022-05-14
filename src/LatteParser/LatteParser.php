<?php

declare(strict_types=1);

namespace Barista\LatteParser;

use Latte\Compiler\Nodes\TemplateNode;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use Latte\Essential\CoreExtension;
use Latte\Sandbox\SandboxExtension;
use Nette\Utils\FileSystem;

final class LatteParser
{
    public function __construct(
        private readonly TemplateLexer $templateLexer = new TemplateLexer(),
        private readonly TemplateParser $templateParser = new TemplateParser(),
    ) {
        $extensions = [
            new CoreExtension(),
            new SandboxExtension(),
        ];

        foreach ($extensions as $extension) {
            $this->templateParser->addTags($extension->getTags());
        }
    }

    public function parseFile(string $filePath): TemplateNode
    {
        $fileContent = FileSystem::read($filePath);
        return $this->parseCode($fileContent);
    }

    public function parseCode(string $code): TemplateNode
    {
        return $this->templateParser->parse($code, $this->templateLexer);
    }
}
