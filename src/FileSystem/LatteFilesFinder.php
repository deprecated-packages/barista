<?php

declare(strict_types=1);

namespace Barista\FileSystem;

use Nette\Utils\Finder;
use Symplify\SmartFileSystem\FileSystemFilter;

/**
 * @see \Barista\Tests\FileSystem\LatteFilesFinder\LatteFilesFinderTest
 */
final class LatteFilesFinder
{
    public function __construct(
        private FileSystemFilter $fileSystemFilter
    ) {
    }

    /**
     * @param string[] $filesOrDirectories
     * @return \SplFileInfo[]
     */
    public function find(array $filesOrDirectories): array
    {
        $directories = $this->fileSystemFilter->filterDirectories($filesOrDirectories);
        $files = $this->fileSystemFilter->filterFiles($filesOrDirectories);

        $foundFileInfos = [];

        if ($directories !== []) {
            $finder = Finder::findFiles('*.latte')
                ->from(...$directories);

            $foundFileInfos = iterator_to_array($finder);
        }

        foreach ($files as $file) {
            $foundFileInfos[] = new \SplFileInfo($file);
        }

        return $foundFileInfos;
    }
}
