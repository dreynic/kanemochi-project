<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Display all errors for debugging (only use in development)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confpass = $_POST['confpass'];

    // Validate form data
    if (empty($username) || empty($password) || empty($confpass)) {
        echo "<script>
                alert('All fields are required.');
                window.history.back();  // Redirect back to the registration page
              </script>";
        exit();
    }

    if ($password !== $confpass) {
        echo "<script>
                alert('Passwords do not match.');
                window.history.back();  // Redirect back to the registration page
              </script>";
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection parameters
    $dsn = "mysql:host=localhost;dbname=kanemochi_admin"; // Change `order_db` to your database name
    $dbusername = "root";                           // Change to your database username
    $dbpassword = "";                               // Change to your database password

    try {
        // Create a new PDO instance and set error mode to exception
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username already exists
        $checkQuery = "SELECT COUNT(*) FROM admin WHERE username = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$username]);
        $userExists = $checkStmt->fetchColumn();

        if ($userExists) {
            // If username exists, show alert and redirect back
            echo "<script>
                    alert('Username already exists.');
                    window.history.back();  // Redirect back to the registration page
                  </script>";
        } else {
            // If username does not exist, proceed with the registration
            $query = "INSERT INTO admin (username, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username, $hashed_password]);

            // Return a success message using JavaScript alert
            echo "<script>
                    alert('Registration successful!');
                    window.location.href = '../../login.html';
                  </script>";
        }

    } catch (PDOException $e) {
        // Handle any other database connection or query errors
        echo "<script>
                alert('Connection or query failed: " . htmlspecialchars($e->getMessage()) . "');
                window.history.back();  // Redirect back to the registration page
              </script>";
    } finally {
        // Clean up
        $pdo = null; // Close the database connection
        $stmt = null; // Close the statement
        $checkStmt = null; // Close the check statement
    }

    exit();
} else {
    // Handle invalid request method
    echo "<script>
            alert('Invalid request.');
            window.history.back();  // Redirect back to the registration page
          </script>";
    exit();
}
