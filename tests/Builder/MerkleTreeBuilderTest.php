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
        $root = MerkleTreeBuilder::buildRoot($data, $hashFunction);
        $this->assertEquals('d37a60fb7556c542502509dfe4d93928', $root->getValue());
    }

    public function testBuildedRootIsBinary()
    {
        $data = [1, 2, 3];
        $hashFunction = function (string $val){
            return md5($val);
        };
        $root = MerkleTreeBuilder::buildRoot($data, $hashFunction);
        $children = $root->getChildNodes();
        $this->assertEquals(2, count($children));
        do {
            $nextLevelNodes = [];
            /** @var INode $currentNode */
            $currentNode = current($children);
            $expectedChildrenCount = $currentNode->getChildNodes() ? 2 : 0;
            /** @var INode $node */
            foreach ($children as $node) {
                $this->assertEquals($expectedChildrenCount, count($node->getChildNodes()));
                $nextLevelNodes = array_merge($nextLevelNodes, $node->getChildNodes());
            }
            $children = $nextLevelNodes;
        } while ($children);
    }

}