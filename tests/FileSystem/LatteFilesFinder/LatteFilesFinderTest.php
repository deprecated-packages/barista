<?php

declare(strict_types=1);

namespace Barista\Tests\FileSystem\LatteFilesFinder;

use Barista\DI\BaristaContainerFactory;
use Barista\FileSystem\LatteFilesFinder;
use PHPUnit\Framework\TestCase;

final class LatteFilesFinderTest extends TestCase
{
    private LatteFilesFinder $latteFilesFinder;

    protected function setUp(): void
    {
        $baristaContainerFactory = new BaristaContainerFactory();
        $container = $baristaContainerFactory->create();

        $this->latteFilesFinder = $container->getByType(LatteFilesFinder::class);
    }

    public function test(): void
    {
        $foundLatteFiles = $this->latteFilesFinder->find([
            __DIR__ . '/Fixture/bare-file.latte',
            __DIR__ . '/Fixture/another-dir',
        ]);

        $this->assertCount(2, $foundLatteFiles);
        $this->assertContainsOnlyInstancesOf(\SplFileInfo::class, $foundLatteFiles);
    }
}
