<?php

use MerkleTreePhp\Buffer;
use MerkleTreePhp\MerkleTree;
use MerkleTreePhp\Options;

require __DIR__ . '/vendor/autoload.php';

$whitelistAddress = [
    '0x6dC0c0be4c8B2dFE750156dc7d59FaABFb5B923D',
    '0xa8d17cc9caf29af964d19267ddeb4dff122697b0'
];

$leafNodes = array_map(function ($address) {
    return \Web3\Utils::sha3($address);
}, $whitelistAddress);

$options = new Options();
$options->sortPairs = true;

$hashFn = function (Buffer $bf) {
    $hash = \Web3\Utils::sha3('0x' . $bf->toHex());
    return Buffer::fromHex($hash);
};

$merkleTree = new MerkleTree($leafNodes, $hashFn, $options);

$root = $merkleTree->getHexRoot();
echo "root:" . $root . PHP_EOL;

$leaf = $whitelistAddress[0];
echo "leaf:" . $leaf . PHP_EOL;

$proof = $merkleTree->getHexProof(\Web3\Utils::sha3($leaf));
echo "proof:" . json_encode($proof) . PHP_EOL;
