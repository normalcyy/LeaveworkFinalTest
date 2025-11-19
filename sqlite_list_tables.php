<?php
$db = __DIR__ . '/database/database.sqlite';
if (!file_exists($db)) {
    echo "Database file not found: $db\n";
    exit(1);
}
try {
    $pdo = new PDO('sqlite:' . $db);
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (empty($tables)) {
        echo "No tables in $db\n";
    } else {
        echo "Tables:\n";
        foreach ($tables as $t) {
            echo "- $t\n";
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
