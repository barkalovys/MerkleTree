<?php

namespace Merkle\Node;

class Node implements INode
{
    /**
     * @var INode
     */
    protected $parent;

    /**
     * @var array
     */
    protected $childNodes = [];

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

    private $position;

    /**
     * Node constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
        $this->position = 0;
    }

    public function current()
    {
        return $this->childNodes[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->childNodes[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
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

    public function getParent()
    {
        return $this->parent;
    }

    function setParent(INode $parent): INode
    {
        $this->parent = $parent;
        return $parent;
    }

    public function hasChildNodes()
    {
        return !empty($this->childNodes);
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->current()->hasChildNodes();
    }

    /**
     * @return \RecursiveIterator
     */
    public function getChildren(): \RecursiveIterator
    {
        return $this->childNodes[$this->position];
    }

    /**
     * @return array
     */
    public function getChildNodes():array
    {
        return $this->childNodes;
    }

    function setChildNodes(array $children): INode
    {
        $this->childNodes = $children;
        return $this;
    }

}