<?php

namespace Merkle\Builder;

use Merkle\Node\INode;
use PHPUnit\Framework\TestCase;

class MerkleTreeBuilderTest extends TestCase
{

    public function testBuildedTreeRootHashIsCorrect()
    {
        $data = [1, 2, 3];
        $hashFunction = function (string $val){
            return md5($val);
        };
        $tree = MerkleTreeBuilder::build($data, $hashFunction);
        $this->assertEquals('d37a60fb7556c542502509dfe4d93928', $tree->getRoot()->getValue());
    }

    public function testBuildedTreeIsBinary()
    {
        $data = [1, 2, 3];
        $hashFunction = function (string $val){
            return md5($val);
        };
        $tree = MerkleTreeBuilder::build($data, $hashFunction);
        $children = $tree->getRoot()->getChildren();
        $this->assertEquals(2, count($children));
        do {
            $nextLevelNodes = [];
            /** @var INode $currentNode */
            $currentNode = current($children);
            $this->assertInstanceOf(INode::class, $currentNode);
            $expectedChildrenCount = $currentNode->getChildren() ? 2 : 0;
            /** @var INode $node */
            foreach ($children as $node) {
                $this->assertInstanceOf(INode::class, $node);
                $this->assertEquals($expectedChildrenCount, count($node->getChildren()));
                $nextLevelNodes = array_merge($nextLevelNodes, $node->getChildren());
            }
            $children = $nextLevelNodes;
        } while ($children);
    }


}