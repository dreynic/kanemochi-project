<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Generate the current timestamp
    date_default_timezone_set('Asia/Jakarta'); // Set timezone as needed
    $submit = date("Y-m-d H:i:s"); // Generate current timestamp

    // Retrieve form data
    $order_id = $_POST["order_id"];
    $shipment_date = $_POST["shipment_date"];
    $shipment_method = $_POST["shipment_method"];
    $provider = $_POST["provider"];
    $shipment_id = $_POST["shipment_id"];

    // Validate the form data (additional validation can be added as needed)
    if (empty($order_id) || empty($shipment_date) || empty($shipment_method) || empty($provider) || empty($shipment_id)) {
        echo "<script>
            alert('Please fill all the fields.');
            window.location.href = '../../index.php';
        </script>";
        exit();
    }

    try {
        // Database connection details
        $dsn = "mysql:host=localhost;dbname=order_db"; // Replace with your actual database host and name
        $dbusername = "root"; // Replace with your actual database username
        $dbpassword = ""; // Replace with your actual database password

        // Create a new PDO instance
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query to insert data
        $query = "INSERT INTO shipment3 (order_id, shipment_date, shipment_method, provider, shipment_id, submit) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);

        // Execute the query with form data and timestamp
        if ($stmt->execute([$order_id, $shipment_date, $shipment_method, $provider, $shipment_id, $submit])) {
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
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home page if the request is not POST
    header("Location: ../../index.php");
    exit();
}
?>
