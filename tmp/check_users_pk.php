<?php
require __DIR__ . '/../vendor/autoload.php';

$dsn = 'mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4';
$user = 'root';
$pass = '';

$pdo = new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "users.id type:\n";
$descStmt = $pdo->query("DESCRIBE users");
$cols = $descStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($cols as $col) {
  if ($col['Field'] === 'id') {
    echo "- id: {$col['Type']} null=" . ($col['Null'] === 'YES' ? 'YES' : 'NO') . "\n";
  }
}

$pkStmt = $pdo->query("SHOW KEYS FROM users WHERE Key_name = 'PRIMARY'");
$pkRows = $pkStmt->fetchAll(PDO::FETCH_ASSOC);
echo "users PRIMARY KEY:\n";
if (count($pkRows) === 0) {
  echo "(none)\n";
} else {
  foreach ($pkRows as $k) {
    echo "- {$k['Column_name']} ({$k['Index_type']})\n";
  }
}

echo "\nengine/charset for users:\n";
$showCreate = $pdo->query("SHOW CREATE TABLE users")->fetch(PDO::FETCH_ASSOC);
if ($showCreate && isset($showCreate['Create Table'])) {
  echo $showCreate['Create Table'] . "\n";
}
?>
