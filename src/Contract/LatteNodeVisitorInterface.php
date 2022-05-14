<?php

declare(strict_types=1);

namespace Barista\Contract;

use Latte\Compiler\Node;

/**
 * @template TNode as Node
 */
interface LatteNodeVisitorInterface
{
    /**
     * @return class-string<TNode>
     */
    public function getNodeType(): string;

    /**
     * @param TNode $node
     */
    public function enterNode(Node $node): int|null|Node;
}
