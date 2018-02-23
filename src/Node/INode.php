<?php

namespace Merkle\Node;

interface INode
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
     * @return bool
     */
    function isLeaf():bool;

    /**
     * @param bool $isLeaf
     * @return INode
     */
    function setIsLeaf(bool $isLeaf):INode;

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
     * @return array
     */
    function getChildren():array;

    /**
     * @param array $children
     * @return INode
     */
    function setChildren(array $children):INode;

}