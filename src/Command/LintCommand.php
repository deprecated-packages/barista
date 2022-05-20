<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Configuration\Option;
use Barista\Exception\ShouldNotHappenException;
use Latte\Engine;
use Latte\Tools\Linter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Engine aware extension of native Linter:
 * https://github.com/nette/latte/blob/master/src/Tools/Linter.php
 */
final class LintCommand extends AbstractBaristaCommand
{
    protected function configure(): void
    {
        $this->setName('lint');
        $this->setDescription('Lint your Latte files with your own Latte\Engine');
        $this->addOption(Option::LATTE_PROVIDER, null, InputOption::VALUE_REQUIRED, 'Path to file that provides Latte engine for linter');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $latteFileInfos = $this->findLatteFileInfos($input);

        $noteMessage = sprintf('Linting %d files...', count($latteFileInfos));
        $this->symfonyStyle->note($noteMessage);

        $latteEngine = $this->provideCustomLatteEngine($input);
        $hasFoundErrors = $this->lintFileInfos($latteEngine, $latteFileInfos);

        return $hasFoundErrors ? self::FAILURE : self::SUCCESS;
    }

    private function provideCustomLatteEngine(InputInterface $input): Engine
    {
        $latteProviderFilePath = (string) $input->getOption(Option::LATTE_PROVIDER);
        if (! file_exists($latteProviderFilePath)) {
            $errorMessage = sprintf('File "%s" provided in "--%s" was not found.', $latteProviderFilePath, Option::LATTE_PROVIDER);
            throw new ShouldNotHappenException($errorMessage);
        }

        $latteEngine = require_once $latteProviderFilePath;
        if (! $latteEngine instanceof Engine) {
            $errorMessage = sprintf('The "%s" file must provide "%s". The "%s" given', $latteProviderFilePath, Engine::class, get_debug_type($latteEngine));
            throw new ShouldNotHappenException($errorMessage);
        }

        return $latteEngine;
    }

    /**
     * @param \SplFileInfo[] $latteFileInfos
     */
    private function lintFileInfos(Engine $latteEngine, array $latteFileInfos): bool
    {
        $linter = new Linter($latteEngine);

        $hasFoundErrors = false;

        foreach ($latteFileInfos as $latteFileInfo) {
            $isFileClean = $linter->lintLatte($latteFileInfo->getRealPath());
            if ($isFileClean === false) {
                $hasFoundErrors = true;
            }
        }

        return $hasFoundErrors;
    }
}
