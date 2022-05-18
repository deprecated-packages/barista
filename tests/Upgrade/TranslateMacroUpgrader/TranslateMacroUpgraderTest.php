<?php

declare(strict_types=1);

namespace Barista\Tests\Upgrade\TranslateMacroUpgrader;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteUpgrader;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\TestCase;

final class TranslateMacroUpgraderTest extends TestCase
{
    private LatteUpgrader $latteUpgrader;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create();

        $this->latteUpgrader = $container->getByType(LatteUpgrader::class);
    }

    public function test(): void
    {
        $fileContents = FileSystem::read(__DIR__ . '/Fixture/old_file.latte');
        [$oldContent, $expectedContent] = explode("-----\n", $fileContents);

        $upgradedContent = $this->latteUpgrader->upgradeFileContent($oldContent);

        $this->assertSame($expectedContent, $upgradedContent);
    }
}