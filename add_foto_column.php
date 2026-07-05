<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=inventory_dinsos', 'root', '');
try {
    $pdo->exec("ALTER TABLE barangs ADD COLUMN foto VARCHAR(255) NULL AFTER keterangan");
    echo "✅ Column 'foto' berhasil ditambahkan ke tabel barangs\n";
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "⚠️  Column 'foto' sudah ada\n";
    } else {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}
?>
