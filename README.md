# MerkleTree
PHP class implementing Merkle tree data structure.
https://en.wikipedia.org/wiki/Merkle_tree

## Example:
    <?php
    $data = [
        'Lorem',
        'ipsum',
        'dolor',
        'sit',
    ];
    
    $hashAlgorithm = function($value){
        return hash('sha256', hash('sha256', $value));
    };
    
    $tree = MerkleTree($data, $hashAlgorithm);
    
    echo "Tree depth: " . $tree->getTreeDepth() . PHP_EOL;
    
    echo "Root: " . $tree->getRoot()->getValue() . PHP_EOL;
    
    /** @var INode $node */
    foreach ($tree as $node) {
        echo $node->getValue() . PHP_EOL;
    }
