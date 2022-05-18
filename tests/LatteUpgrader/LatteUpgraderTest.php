<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteUpgrader;
use Iterator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;

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
    public function test(SplFileInfo $fileInfo): void
    {
        [$oldContent, $expectedContent] = explode("-----\n", $fileInfo->getContents());

        $upgradedContent = $this->latteUpgrader->upgradeFileContent($oldContent);
        $this->assertSame($expectedContent, $upgradedContent);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectoryExclusively(__DIR__ . '/Fixture', '*.latte');
    }
}