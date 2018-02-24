<?php

namespace Merkle\Tree;

use Merkle\Node\Node;
use PHPUnit\Framework\TestCase;

/**
 * Class MerkleTreeTest
 * @package Merkle\Tree
 */
class MerkleTreeTest extends TestCase
{

    public function testTreeDepthIsCorrect()
    {
        $root = new Node(1);
        $node = $root;
        for ($i = 0; $i < 10; ++$i) {
            $newNode = new Node($i);
            $node->setChildren([$newNode]);
            $node = current($node->getChildren());
        }
        $tree = new MerkleTree($root);
        $this->assertEquals(10, $tree->getTreeDepth());
    }
}