<?php

require_once 'vendor/autoload.php';

$hashAlgorithm = function($value){
    return hash('sha256', hash('sha256', $value));
};

$tree = \Merkle\Builder\MerkleTreeBuilder::build([1,2,3,4,5], $hashAlgorithm);
echo "Tree depth: " . $tree->getTreeDepth() . PHP_EOL;
echo "Root: " . $tree->getRoot()->getValue() . PHP_EOL;
$i = 1;
$children = $tree->getRoot()->getChildren();
while ($children) {
    ++$i;
    $nextLevelNodes = [];
    echo "Level $i: ";
    /** @var \Merkle\Node\INode $node */
    foreach ($children as $node) {
        echo $node->getValue() . ' ';
        $nextLevelNodes = array_merge($nextLevelNodes, $node->getChildren());
    }
    $children = $nextLevelNodes;
    echo PHP_EOL;
}