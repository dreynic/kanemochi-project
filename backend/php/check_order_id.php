<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $order_id = $_POST["order_id"];

    try {
        $dsn = "mysql:host=localhost;dbname=order_db";
        $dbusername = "root";
        $dbpassword = "";

        try {
            $pdo = new PDO($dsn, $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
            die();
        }

        $query = "SELECT COUNT(*) FROM item_order WHERE order_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$order_id]);

        $exists = $stmt->fetchColumn() > 0;

        echo json_encode(['exists' => $exists]);

        $pdo = null;
        $stmt = null;

        exit();
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
        die();
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}