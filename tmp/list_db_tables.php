<?php
require __DIR__ . '/../vendor/autoload.php';

$dsn = 'mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4';
$user = 'root';
$pass = '';

$pdo = new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_NUM);
echo "Tables in ecommercepfe:\n";
foreach ($tables as $row) {
  echo "- {$row[0]}\n";
}
?>
