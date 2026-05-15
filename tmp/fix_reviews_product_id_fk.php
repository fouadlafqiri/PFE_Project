<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$pdo->exec("ALTER TABLE reviews MODIFY product_id bigint(20) unsigned NOT NULL");

$hasFk = $pdo->query("
  SELECT COUNT(*) as c
  FROM information_schema.KEY_COLUMN_USAGE
  WHERE TABLE_SCHEMA = 'ecommercepfe'
    AND TABLE_NAME = 'reviews'
    AND COLUMN_NAME = 'product_id'
")->fetch(PDO::FETCH_ASSOC);

if ((int)($hasFk["c"] ?? 0) === 0) {
  // Add foreign key (use a deterministic name)
  $pdo->exec("
    ALTER TABLE reviews
    ADD CONSTRAINT reviews_product_id_foreign
    FOREIGN KEY (product_id) REFERENCES products (idProduct)
    ON DELETE CASCADE
  ");
}

echo "reviews.product_id fixed\n";
?>
