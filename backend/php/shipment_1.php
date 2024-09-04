<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Retrieve form data
    $order_id = $_POST["order_id"];
    $merchant = $_POST["merchant"];
    $ordered_payment = $_POST["ordered_payment"];
    $ordered_price = $_POST["ordered_price"];

    // Generate the current timestamp
    date_default_timezone_set('Asia/Jakarta'); // Set timezone as needed
    $submit_timestamp = date("Y-m-d H:i:s"); // This will be used instead of the button value

    try {
        // Database connection details
        $dsn = "mysql:host=localhost;dbname=order_db";
        $dbusername = "root";
        $dbpassword = "";

        // Create a new PDO instance
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query
        $query = "INSERT INTO shipment1 (order_id, merchant, ordered_payment, ordered_price, submit) 
                  VALUES (?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);

        // Execute the query with form data and generated timestamp
        if ($stmt->execute([$order_id, $merchant, $ordered_payment, $ordered_price, $submit_timestamp])) {
            echo "<script>
                alert('Data Submitted Successfully');
                window.location.href = '../../index.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to Submit Data');
                window.location.href = '../../index.php';
            </script>";
        }

        // Close the database connection
        $pdo = null;
        $stmt = null;

        exit();
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home page if the request is not POST
    header("Location: ../../index.php");
    exit();
}
?>
