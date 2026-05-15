<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$prod = $pdo->query('SHOW COLUMNS FROM products WHERE Field="idProduct"')->fetch(PDO::FETCH_ASSOC);
$rev = $pdo->query('SHOW COLUMNS FROM reviews WHERE Field="product_id"')->fetch(PDO::FETCH_ASSOC);

echo "products.idProduct Type: " . ($prod["Type"] ?? "NULL") . PHP_EOL;
echo "reviews.product_id Type: " . ($rev["Type"] ?? "NULL") . PHP_EOL;
?>
