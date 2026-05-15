<?php
$pdo = new PDO(
  "mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4",
  "root",
  "",
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$name = "Hicham OUADDATE";
$email = "hichamouaddate_test_" . rand(1000, 9999) . "@gmail.com";
$phone = "0660194559";
$subject = "sdfsd";
$message = "fsdfsd";

$stmt = $pdo->prepare(
  "INSERT INTO contacts (name, email, phone, subject, message, created_at, updated_at)
   VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
);
$stmt->execute([$name, $email, $phone, $subject, $message]);

echo "contact inserted id=" . $pdo->lastInsertId() . PHP_EOL;
