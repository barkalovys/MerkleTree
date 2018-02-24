<?php

namespace Merkle\Tree;

use PHPUnit\Framework\TestCase;

/**
 * Class MerkleTreeTest
 * @package Merkle\Tree
 */
class MerkleTreeTest extends TestCase
{

    public function testTreeDepthIsCorrect()
    {
        $data = range(1,9);
        $tree = new MerkleTree($data, function(string $val){
            return md5($val);
        });
        $this->assertEquals(4, $tree->getTreeDepth());
    }
}