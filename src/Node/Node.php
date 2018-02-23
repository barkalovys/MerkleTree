<?php

namespace Merkle\Node;

class Node extends \RecursiveArrayIterator implements INode
{
    /**
     * @var INode
     */
    protected $parent;

    /**
     * @var array
     */
    protected $children = [];

    /**
     * @var string
     */
    protected $value;


    /**
     * @var bool
     */
    protected $isRoot = false;

    /**
     * @var bool
     */
    protected $isLeaf = false;

    /**
     * @var INode
     */
    protected $nextSibling;


    /**
     * Node constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    function getValue(): string
    {
        return $this->value;
    }

    function isRoot(): bool
    {
        return $this->isRoot;
    }

    function setIsRoot(bool $isRoot): INode
    {
        $this->isRoot = $isRoot;
        return $this;
    }

    function isLeaf(): bool
    {
        return $this->isLeaf;
    }

    function setIsLeaf(bool $isLeaf): INode
    {
        $this->isLeaf = $isLeaf;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    function setParent(INode $parent): INode
    {
        $this->parent = $parent;
        return $parent;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    function setChildren(array $children): INode
    {
        $this->children = $children;
        return $this;
    }

}