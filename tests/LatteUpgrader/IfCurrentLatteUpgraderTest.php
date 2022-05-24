<?php

declare(strict_types=1);

namespace Barista\Tests\LatteUpgrader;

final class IfCurrentLatteUpgraderTest extends AbstractLatteUpgraderTest
{
    public function provideConfig(): string
    {
        return __DIR__ . '/config/if_current.neon';
    }

    public function provideFixtureDirectory(): string
    {
        return __DIR__ . '/Fixture/if_current';
    }
}
