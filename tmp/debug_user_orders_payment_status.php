<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$userId = 1;
$productId = 1;

echo "Orders/payment_status for user {$userId}:\n";
$rows = $pdo->query("
  SELECT o.idOrder, o.order_number, o.payment_status, o.status, o.total_amount
  FROM orders o
  WHERE o.user_id = {$userId}
  ORDER BY o.idOrder DESC
  LIMIT 20
")->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $r) {
  echo "- idOrder={$r['idOrder']} payment_status={$r['payment_status']} status={$r['status']} total={$r['total_amount']}\n";
}

echo "\nOrder_items for product {$productId}:\n";
$rows2 = $pdo->query("
  SELECT o.idOrder, o.payment_status, oi.quantity, oi.price
  FROM order_items oi
  JOIN orders o ON o.idOrder = oi.order_id
  WHERE oi.product_id = {$productId}
  ORDER BY o.idOrder DESC
  LIMIT 20
")->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows2 as $r) {
  echo "- idOrder={$r['idOrder']} payment_status={$r['payment_status']} quantity={$r['quantity']} price={$r['price']}\n";
}
?>
