<?php


namespace Merkle\Tree;

use Merkle\Node\INode;

class MerkleTree extends \RecursiveIteratorIterator
{
    /**
     * @var INode
     */
    protected $root;

    public function __construct(INode $root)
    {
        parent::__construct($root);
        $this->root = $root;
    }

    /**
     * @return INode
     */
    public function getRoot(): INode
    {
        return $this->root;
    }

    public function hasChildren(): bool
    {
        return $this->getRoot()->hasChildren();
    }

    public function getChildren(): array
    {
        return $this->getRoot()->getChildren();
    }

    public function getLeafs(): array
    {
        return [];
    }

}