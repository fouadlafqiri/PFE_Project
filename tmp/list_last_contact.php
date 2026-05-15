<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$row = $pdo->query("SELECT id,name,email,phone,subject,created_at FROM contacts ORDER BY id DESC LIMIT 1")
  ->fetch(PDO::FETCH_ASSOC);

print_r($row);
?>
