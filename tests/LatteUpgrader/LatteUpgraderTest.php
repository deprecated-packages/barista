<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteUpgrader;
use Iterator;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\TestCase;

final class LatteUpgraderTest extends TestCase
{
    private LatteUpgrader $latteUpgrader;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create();

        $this->latteUpgrader = $container->getByType(LatteUpgrader::class);
    }

    /**
     * @dataProvider provideData()
     */
    public function test(string $oldContent, string $expectedContent): void
    {
        $upgradedContent = $this->latteUpgrader->upgradeFileContent($oldContent);

        $this->assertSame($expectedContent, $upgradedContent);
    }

    public function provideData(): Iterator
    {
        $fileContents = FileSystem::read(__DIR__ . '/Fixture/bare_underscore_translate.latte');
        yield explode("-----\n", $fileContents);

        $fileContents = FileSystem::read(__DIR__ . '/Fixture/if_current.latte');
        yield explode("-----\n", $fileContents);
    }
}