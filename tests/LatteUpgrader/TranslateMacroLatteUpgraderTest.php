<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

final class TranslateMacroLatteUpgraderTest extends AbstractLatteUpgraderTest
{
    public function provideConfig(): string
    {
        return __DIR__ . '/config/translate_dual.neon';
    }

    public function provideFixtureDirectory(): string
    {
        return __DIR__ . '/Fixture/translate';
    }
}
