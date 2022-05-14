<?php

declare(strict_types=1);

namespace Barista;

use Latte\Compiler\Nodes\Php\Expression\ArrayNode;
use Latte\Compiler\TemplateLexer;
use Latte\Compiler\TemplateParser;
use Latte\Essential\CoreExtension;
use Latte\Sandbox\SandboxExtension;
use Nette\Utils\FileSystem;

final class Analyze
{
    public function run()
    {
        $filepath = __DIR__ . '/../fixture/a-with-attributes.latte';
        $fileContent = FileSystem::read($filepath);

        $arrayNode = $this->parseCode($fileContent);
        dump($arrayNode);

        // @todo add latte node visitor
    }

    private function parseCode(string $code): ArrayNode
    {
        $templateLexer = new TemplateLexer();
        $templateParser = new TemplateParser();

        $extensions = [
            new CoreExtension(),
            new SandboxExtension(),
        ];

        foreach ($extensions as $extension) {
            $templateParser->addTags($extension->getTags());
        }

        return $templateParser->parse($code, $templateLexer);
    }

}

require __DIR__ . '/../vendor/autoload.php';
(new Analyze())->run();
