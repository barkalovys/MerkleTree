<?php

namespace Merkle\Node;

interface INode extends \RecursiveIterator
{
    /**
     * @return string
     */
    function getValue():string;

    /**
     * @return bool
     */
    function isRoot():bool;

    /**
     * @param bool $isRoot
     * @return INode
     */
    function setIsRoot(bool $isRoot):INode;

    /**
     * @return INode|null
     */
    function getParent();

    /**
     * @param INode $parent
     * @return INode
     */
    function setParent(INode $parent):INode;

    /**
     * @return bool
     */
    function hasChildren():bool;

    /**
     * @return \RecursiveIterator
     */
    function getChildren():\RecursiveIterator;

    /**
     * @return array
     */
    function getChildNodes():array;

    /**
     * @param array $children
     * @return INode
     */
    function setChildNodes(array $children):INode;

}