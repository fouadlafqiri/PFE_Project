<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$email = "admin@local.test";

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
  echo "admin already exists\n";
  exit(0);
}

$hash = password_hash("Password123!", PASSWORD_BCRYPT);

$insert = $pdo->prepare(
  "INSERT INTO users (name, email, password, role, created_at, updated_at)
   VALUES (?, ?, ?, ?, NOW(), NOW())"
);
$insert->execute(["Admin", $email, $hash, "admin"]);

echo "admin created\n";
