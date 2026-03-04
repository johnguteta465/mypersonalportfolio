<?php
include 'db.php';
header('Content-Type: text/plain; charset=utf-8');

echo "DB Host: $host\n";
echo "DB Name: $db\n";
if (isset($mysqli) && $mysqli instanceof mysqli) {
    echo "Connected: " . $mysqli->host_info . "\n";
    $safe_db = $mysqli->real_escape_string($db);
    $res = $mysqli->query("SELECT COUNT(*) AS cnt FROM information_schema.tables WHERE table_schema = '$safe_db'");
    $row = $res->fetch_assoc();
    echo "Tables in $db: " . ($row['cnt'] ?? '0') . "\n";

    $tables = ['projects', 'messages', 'admin'];
    foreach ($tables as $table) {
        $result = $mysqli->query("SHOW TABLES LIKE '$table'");
        echo "Table '$table': " . ($result->num_rows > 0 ? "✓ Exists" : "✗ Missing") . "\n";
    }
} else {
    echo "No mysqli connection available.\n";
}
