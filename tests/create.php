<?php
// create.php <name>
require_once "../bootstrap.php";

use src\GameResult;

$newName = $argv[1];

$product = new GameResult();
$product->setName($newProductName);

$entityManager->persist($product);
$entityManager->flush();

echo "Created record with ID " . $product->getId() . "\n";