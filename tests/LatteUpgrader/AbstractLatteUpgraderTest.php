<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

use Barista\DI\BaristaContainerFactory;
use Barista\LatteUpgrader;
use Iterator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;

abstract class AbstractLatteUpgraderTest extends TestCase
{
    private LatteUpgrader $latteUpgrader;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create([
            $this->provideConfig(),
        ]);

        $this->latteUpgrader = $container->getByType(LatteUpgrader::class);
    }

    abstract public function provideConfig(): string;

    abstract public function provideFixtureDirectory(): string;

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
        return StaticFixtureFinder::yieldDirectoryExclusively($this->provideFixtureDirectory(), '*.latte');
    }
}
