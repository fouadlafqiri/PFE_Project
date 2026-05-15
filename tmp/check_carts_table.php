<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_NUM);
$names = array_map(fn($r) => $r[0], $tables);

echo in_array("carts", $names, true) ? "carts_exists\n" : "carts_missing\n";
?>
