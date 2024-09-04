<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $cust_id = $_POST["cust_id"];

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

        $query = "INSERT INTO cust_order (name, phone, cust_id) VALUES (?, ?, ?);";

        $stmt = $pdo->prepare($query);

        if (!$stmt) {
            echo "Query preparation failed.";
        }

        if ($stmt->execute([$name, $phone, $cust_id])) {
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
        echo "Query failed: ". $e->getMessage();
        die();
    }
} else {
    header("Location: ../../index.php");
    exit();
}