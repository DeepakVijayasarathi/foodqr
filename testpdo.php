<?php
try {
    $pdo = new PDO('mysql:host=195.35.7.84;port=3306;dbname=client_food', 'client_food', 'Deepakiucs@2025', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "OK";
} catch (Exception $e) {
    echo "ERR: " . $e->getMessage();
}
