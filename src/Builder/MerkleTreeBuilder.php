<?php

namespace Merkle\Builder;


use Merkle\Node\INode;
use Merkle\Node\Node;
use Merkle\Tree\MerkleTree;

/**
 * Class MerkleTreeBuilder
 * @package Merkle\Builder
 */
class MerkleTreeBuilder
{
    /**
     * @param array $data
     * @param callable $hashAlgorithm
     * @return MerkleTree
     */
    public static function build(array $data, callable $hashAlgorithm)
    {
        $leafs = array_map(function ($value) use ($hashAlgorithm) {
            return (new Node($hashAlgorithm($value)))
                ->setIsRoot(false)
                ->setIsLeaf(true);
        }, $data);
        $rootNode = self::buildLevel($leafs, $hashAlgorithm);
        return new MerkleTree($rootNode);
    }

    /**
     * @param array $childNodes
     * @param callable $hashAlgorithm
     * @return INode
     * @throws \InvalidArgumentException
     */
    protected static function buildLevel(array $childNodes, callable $hashAlgorithm)
    {
        if (!$childNodes) {
            throw new \InvalidArgumentException('Empty nodes list passed to method ' . __METHOD__);
        }
        $countNodes = count($childNodes);
        if (count($childNodes) === 1) {
            /** @var INode $rootNode */
            $rootNode = array_pop($childNodes);
            $rootNode->setIsRoot(true);
            return $rootNode;
        }
        $parentNodes = [];
        $currentPair = [];
        for ($i = 0; $i < $countNodes; ++$i) {
            $currentPair[] = $childNodes[$i];
            if ($i % 2 === 0) {
                if ($i !== $countNodes-1) {
                    continue;
                }
                $currentPair[] = $childNodes[$i];
            }
            $parentNode = new Node(
                $hashAlgorithm(
                    $currentPair[0]->getValue() . $currentPair[1]->getValue()
                )
            );
            $currentPair[0]->setParent($parentNode);
            $currentPair[1]->setParent($parentNode);
            $parentNode->setChildren($currentPair);
            $currentPair = [];
            $parentNodes[] = $parentNode;
        }
        return self::buildLevel($parentNodes, $hashAlgorithm);
    }

}