<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$productId = 1;

$rows = $pdo->query("
  SELECT idReview, user_id, rating, is_approved, comment, created_at
  FROM reviews
  WHERE product_id = {$productId}
  ORDER BY idReview DESC
  LIMIT 20
")->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
  echo "No reviews found for product_id={$productId}\n";
  exit;
}

echo "Found ".count($rows)." reviews for product_id={$productId}:\n";
foreach ($rows as $r) {
  echo "- idReview={$r['idReview']} user_id={$r['user_id']} rating={$r['rating']} is_approved={$r['is_approved']} created_at={$r['created_at']}\n";
}
?>
