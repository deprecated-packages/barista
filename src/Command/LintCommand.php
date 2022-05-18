<?php

declare(strict_types=1);

namespace Barista\Command;

use Barista\Configuration\Option;
use Barista\Exception\ShouldNotHappenException;
use Barista\FileSystem\LatteFilesFinder;
use Latte\Engine;
use Latte\Tools\Linter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Engine aware extension of native Linter:
 * https://github.com/nette/latte/blob/master/src/Tools/Linter.php
 */
final class LintCommand extends Command
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
        private LatteFilesFinder $latteFilesFinder,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('lint');
        $this->setDescription('Lint your Latte files with your own Latte\Engine');
        $this->addArgument(Option::PATHS, InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Path to your Latte files or directories');
        $this->addOption(Option::LATTE_PROVIDER, null, InputOption::VALUE_REQUIRED, 'Path to file that provides Latte engine for linter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $latteEngine = $this->provideCustomLatteEngine($input);

        $paths = (array) $input->getOption(Option::PATHS);
        $latteFileInfos = $this->latteFilesFinder->find($paths);

        $linter = new Linter($latteEngine);

        foreach ($latteFileInfos as $latteFileInfo) {
            $linter->lintLatte($latteFileInfo->getRealPath());
        }

        return self::SUCCESS;
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
}
