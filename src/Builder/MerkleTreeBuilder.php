<?php

namespace Merkle\Builder;


use Merkle\Node\INode;
use Merkle\Node\Node;
use Merkle\Tree\MerkleTree;

class MerkleTreeBuilder
{

    const DEFAULT_HASH_ALGORITHM = 'sha256';

    /**
     * @param array $data
     * @param string $hashAlgorithm
     * @return MerkleTree
     */
    public static function build(array $data, string $hashAlgorithm = self::DEFAULT_HASH_ALGORITHM)
    {
        $leafs = array_map(function ($value) use ($hashAlgorithm) {
            return (new Node(hash($hashAlgorithm, $value)))
                ->setIsRoot(false)
                ->setIsLeaf(true);
        }, $data);
        $rootNode = self::buildLevel($leafs, $hashAlgorithm);
        return new MerkleTree($rootNode);
    }

    /**
     * @param array $childNodes
     * @param string $hashAlgorithm
     * @return INode
     * @throws \InvalidArgumentException
     */
    protected static function buildLevel(array $childNodes, string $hashAlgorithm)
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
                hash(
                    $hashAlgorithm,
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