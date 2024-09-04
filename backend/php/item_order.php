<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $order_date = $_POST["order_date"];
    $brand = $_POST["brand"];
    $type1 = $_POST["type1"];
    $type2 = $_POST["type2"];
    $details = $_POST["details"];
    $order_id = $_POST["order_id"];
    $customer_id = $_POST['customer_id'];

    try {
        $dsn = "mysql:host=localhost;dbname=order_db";
        $dbusername = "root";
        $dbpassword = "";

        try {
            $pdo = new PDO($dsn, $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: ". $e->getMessage();
            die();
        }

        $query = "INSERT INTO item_order (order_date, brand, type1, type2, details, order_id, customer_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute([$order_date, $brand, $type1, $type2, $details, $order_id, $customer_id])) {
            echo "<script>
                alert('Data Submitted');
                window.location.href = '../../index.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to submit data');
                window.location.href = '../../index.php';
            </script>";
        }

        $pdo = null;
        $stmt = null;
        
        exit();
    } catch (PDOException $e) {
        die("Query failed: ". $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    exit();
}