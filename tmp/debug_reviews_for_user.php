<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$userId = 1;

$rows = $pdo->query("
  SELECT idReview, product_id, rating, is_approved, comment, created_at
  FROM reviews
  WHERE user_id = {$userId}
  ORDER BY idReview DESC
  LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
  echo "No reviews found for user_id={$userId}\n";
  exit;
}

echo "Reviews for user_id={$userId}:\n";
foreach ($rows as $r) {
  echo "- idReview={$r['idReview']} product_id={$r['product_id']} rating={$r['rating']} is_approved={$r['is_approved']} created_at={$r['created_at']}\n";
}
?>
