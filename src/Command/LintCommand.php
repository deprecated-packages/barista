<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Exception\ShouldNotHappenException;
use Latte\Engine;
use Latte\Loaders\StringLoader;
use Latte\Tools\Linter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Engine aware extension of native Linter:
 * https://github.com/nette/latte/blob/master/src/Tools/Linter.php
 */
final class LintCommand extends AbstractBaristaCommand
{
    public function __construct(private string $latteProviderFile)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('lint');
        $this->setDescription('Lint your Latte files with your own Latte\Engine. Provide it via "barista.neon" > "parameters" > "latteProviderFile" parameter');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $latteFileInfos = $this->findLatteFileInfos($input);

        $noteMessage = sprintf('Linting %d files...', count($latteFileInfos));
        $this->symfonyStyle->note($noteMessage);

        $latteEngine = $this->provideCustomLatteEngine();

        // this allows to pass directly latte string content
        $latteEngine->setLoader(new StringLoader());

        $errorCount = $this->lintFileInfos($latteEngine, $latteFileInfos);

        if ($errorCount !== 0) {
            $errorMessage = sprintf('Found %d errors', $errorCount);
            $this->symfonyStyle->error($errorMessage);
            return self::FAILURE;
        }

        $this->symfonyStyle->success('Your Latte files are clean!');
        return self::SUCCESS;
    }

    private function provideCustomLatteEngine(): Engine
    {
        if (! file_exists($this->latteProviderFile)) {
            $errorMessage = sprintf('File "%s" provided in "latteProviderFile" parameter', $this->latteProviderFile);
            throw new ShouldNotHappenException($errorMessage);
        }

        $latteEngine = require_once $this->latteProviderFile;
        if (! $latteEngine instanceof Engine) {
            $errorMessage = sprintf('The "%s" file must provide "%s". The "%s" given', $this->latteProviderFile, Engine::class, get_debug_type($latteEngine));
            throw new ShouldNotHappenException($errorMessage);
        }

        return $latteEngine;
    }

    /**
     * @param \SplFileInfo[] $latteFileInfos
     */
    private function lintFileInfos(Engine $latteEngine, array $latteFileInfos): int
    {
        $linter = new Linter($latteEngine);

        $errorCount = 0;

        foreach ($latteFileInfos as $latteFileInfo) {
            $isFileClean = $linter->lintLatte($latteFileInfo->getRealPath());
            if ($isFileClean === false) {
                ++$errorCount;
            }
        }

        return $errorCount;
    }
}
