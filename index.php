<?php

require_once 'vendor/autoload.php';

$data = [
    'Lorem',
    'ipsum',
    'dolor',
    'sit',
    'amet',
];
$hashAlgorithm = function($value){
    return hash('sha256', hash('sha256', $value));
};
$tree = new \Merkle\Tree\MerkleTree($data, $hashAlgorithm);

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