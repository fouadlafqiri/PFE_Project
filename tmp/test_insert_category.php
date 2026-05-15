<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$name = "testcat_" . rand(1000, 9999);
$slug = strtolower(str_replace(" ", "-", $name));

$stmt = $pdo->prepare("INSERT INTO categories (nameCategory, slug, descriptionCategory, imageCategory, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
$stmt->execute([$name, $slug, "desc", null]);

echo "Inserted category id=" . $pdo->lastInsertId() . "\n";
echo "name=" . $name . "\n";
echo "slug=" . $slug . "\n";
?>
