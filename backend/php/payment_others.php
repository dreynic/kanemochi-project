<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $others_payment_date = $_POST["others_payment_date"];
    $payment_type = $_POST["payment_type"];
    $others_payment_in = $_POST["others_payment_in"];
    $amount = $_POST["amount"];
    $trx_others_id = $_POST["trx_others_id"];

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

        $query = "INSERT INTO payment_for_others (others_payment_date, payment_type, others_payment_in, amount, trx_others_id) 
        VALUES (?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute([$others_payment_date, $payment_type, $others_payment_in, $amount, $trx_others_id])) {
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