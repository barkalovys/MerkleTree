<?php


namespace Merkle\Tree;

use Merkle\Builder\MerkleTreeBuilder;
use Merkle\Node\INode;

/**
 * Class MerkleTree
 * @package Merkle\Tree
 */
class MerkleTree extends \RecursiveIteratorIterator
{
    /**
     * @var INode
     */
    protected $root;

    /**
     * @var int
     */
    protected $depth;

    /**
     * MerkleTree constructor.
     * @param array $data
     * @param callable $hashAlgorithm
     */
    public function __construct(array $data, callable $hashAlgorithm)
    {
        parent::__construct($this->root = MerkleTreeBuilder::buildRoot($data, $hashAlgorithm));
        $this->depth = $this->getTreeDepth();
    }

    /**
     * @return INode
     */
    public function getRoot(): INode
    {
        return $this->root;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->getRoot()->hasChildren();
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->getRoot()->getChildren();
    }

    /**
     * @return int
     */
    public function getTreeDepth(): int
    {
        if (is_null($this->depth)){
            $depth = 0;
            $children = $this->getRoot()->getChildren();
            while ($children) {
                ++$depth;
                $nextLevelNodes = [];
                /** @var \Merkle\Node\INode $node */
                foreach ($children as $node) {
                    $nextLevelNodes = array_merge($nextLevelNodes, $node->getChildren());
                }
                $children = $nextLevelNodes;
            }
            $this->depth = $depth;
        }
        return $this->depth;
    }
}