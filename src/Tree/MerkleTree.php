<?php


namespace Merkle\Tree;

use Merkle\Builder\MerkleTreeBuilder;
use Merkle\Node\INode;
use Traversable;

/**
 * Class MerkleTree
 * @package Merkle\Tree
 */
class MerkleTree implements \IteratorAggregate
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
        $this->root = MerkleTreeBuilder::buildRoot($data, $hashAlgorithm);
        $this->depth = $this->getTreeDepth();
    }

    /**
     * @return INode|Traversable
     */
    public function getIterator()
    {
        return new \RecursiveIteratorIterator($this->getRoot(), \RecursiveIteratorIterator::SELF_FIRST);
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
        return $this->getRoot()->getChildNodes();
    }

    /**
     * @return int
     */
    public function getTreeDepth(): int
    {
        if (is_null($this->depth)){
            $depth = 0;
            $children = $this->getRoot()->getChildNodes();
            while ($children) {
                $depth++;
                $children = current($children)->getChildNodes();
            }
            $this->depth = $depth;
        }
        return $this->depth;
    }
}