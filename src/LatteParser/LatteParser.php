<?php

declare(strict_types=1);

namespace Barista\LatteParser;

use Latte\Compiler\Nodes\TemplateNode;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use Latte\Essential\CoreExtension;
use Nette\Utils\FileSystem;

final class LatteParser
{
    public function __construct(
        private TemplateLexer $templateLexer,
        private TemplateParser $templateParser,
    ) {
        $extensions = [
            new CoreExtension(),
        ];

        if (class_exists('Nette\Bridges\ApplicationLatte\UIExtension')) {
            $extensions[] = new \Nette\Bridges\ApplicationLatte\UIExtension(null);
        }

        if (class_exists('Nette\Bridges\ApplicationLatte\TranslatorExtension')) {
            $extensions[] = new \Nette\Bridges\ApplicationLatte\TranslatorExtension(null);
        }

        if (class_exists('Nette\Bridges\CacheLatte\CacheExtension') && class_exists('Nette\Caching\Storages\DevNullStorage')) {
            $extensions[] = new \Nette\Bridges\CacheLatte\CacheExtension(new \Nette\Caching\Storages\DevNullStorage());
        }

        if (class_exists('Nette\Bridges\FormsLatte\FormsExtension')) {
            $extensions[] = new \Nette\Bridges\FormsLatte\FormsExtension();
        }

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
        // reset blocks to allow parsing new file with same blocks
        $this->templateParser->blocks = [];
        $this->templateParser->location = TemplateParser::LocationHead;

        return $this->templateParser->parse($code, $this->templateLexer);
    }
}
