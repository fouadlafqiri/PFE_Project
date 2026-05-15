<?php
require __DIR__ . '/../vendor/autoload.php';

$dsn = 'mysql:host=127.0.0.1;dbname=ecommercepfe;charset=utf8mb4';
$user = 'root';
$pass = '';

$pdo = new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Checking tables...\n";

$tablesStmt = $pdo->query("SHOW TABLES LIKE 'orders'");
$ordersRow = $tablesStmt->fetch();

if (!$ordersRow) {
  echo "orders table: MISSING\n";
  exit(0);
}

echo "orders table: PRESENT\n";

$descStmt = $pdo->query("DESCRIBE orders");
$desc = $descStmt->fetchAll(PDO::FETCH_ASSOC);

echo "orders columns:\n";
foreach ($desc as $col) {
  echo "- {$col['Field']} ({$col['Type']}) null=" . ($col['Null'] === 'YES' ? 'YES' : 'NO') . "\n";
}

$pkStmt = $pdo->query("SHOW KEYS FROM orders WHERE Key_name = 'PRIMARY'");
$pkRows = $pkStmt->fetchAll(PDO::FETCH_ASSOC);
echo "orders PRIMARY KEY:\n";
if (count($pkRows) === 0) {
  echo "(none)\n";
} else {
  foreach ($pkRows as $k) {
    echo "- {$k['Column_name']}\n";
  }
}

echo "\nChecking order_items existing table/columns...\n";
$orderItemsStmt = $pdo->query("SHOW TABLES LIKE 'order_items'");
$orderItemsRow = $orderItemsStmt->fetch();

if ($orderItemsRow) {
  $descItems = $pdo->query("DESCRIBE order_items")->fetchAll(PDO::FETCH_ASSOC);
  echo "order_items columns:\n";
  foreach ($descItems as $col) {
    echo "- {$col['Field']} ({$col['Type']}) null=" . ($col['Null'] === 'YES' ? 'YES' : 'NO') . "\n";
  }

  $fkStmt = $pdo->query("SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA='ecommercepfe' AND TABLE_NAME='order_items' AND REFERENCED_TABLE_NAME IS NOT NULL");
  $fks = $fkStmt->fetchAll(PDO::FETCH_ASSOC);
  echo "order_items foreign keys (resolved):\n";
  if (count($fks) === 0) {
    echo "(none)\n";
  } else {
    foreach ($fks as $fk) {
      echo "- {$fk['CONSTRAINT_NAME']}: {$fk['COLUMN_NAME']} -> {$fk['REFERENCED_TABLE_NAME']}({$fk['REFERENCED_COLUMN_NAME']})\n";
    }
  }
} else {
  echo "order_items table: MISSING\n";
}
?>
