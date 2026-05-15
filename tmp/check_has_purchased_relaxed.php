<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$userId = 1;
$productId = 1;

$row = $pdo->query("
  SELECT EXISTS (
    SELECT 1
    FROM orders o
    WHERE o.user_id = {$userId}
      AND EXISTS (
        SELECT 1
        FROM order_items oi
        WHERE oi.order_id = o.idOrder
          AND oi.product_id = {$productId}
      )
  ) AS hasPurchased
")->fetch(PDO::FETCH_ASSOC);

echo "hasPurchased=" . (($row['hasPurchased'] ?? 0) ? "true" : "false") . PHP_EOL;
?>
