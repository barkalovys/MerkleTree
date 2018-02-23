<?php

define('APP_NAME', 'Merkle');

/**
 * @param string $className
 */
function __autoload(string $className)
{
    $parts = explode('\\', $className);
    if (isset($parts[0]) && $parts[0] === APP_NAME) {
        $includePath = 'src';
        array_shift($parts);
        foreach ($parts as $part) {
            $includePath .= DIRECTORY_SEPARATOR . $part;
        }
        require_once $includePath . '.php';
    }
}

$tree = \Merkle\Builder\MerkleTreeBuilder::build([1,2,3,4,5], 'sha256');
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