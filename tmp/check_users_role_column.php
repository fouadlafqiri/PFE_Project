<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$cols = $pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
  if (($c["Field"] ?? null) === "role") {
    echo "role column exists (type=" . ($c["Type"] ?? "") . ", default=" . ($c["Default"] ?? "") . ")\n";
    exit(0);
  }
}
echo "role column NOT found\n";
