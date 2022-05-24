<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

final class DoubleToSingleTranslateLatteUpgraderTest extends AbstractLatteUpgraderTest
{
    public function provideConfig(): string
    {
        return __DIR__ . '/config/double_to_single_latte.neon';
    }

    public function provideFixtureDirectory(): string
    {
        return __DIR__ . '/Fixture/translate_to_single';
    }
}
