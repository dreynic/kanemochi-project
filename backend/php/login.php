<?php
session_start();

// Check if user is already logged in via session
if (isset($_SESSION['username'])) {
    header('Location: ../../index.php'); // Redirect to dashboard
    exit();
}

// Check if "Remember Me" cookie exists
if (isset($_COOKIE['remember_me'])) {
    // Automatically log in the user
    $_SESSION['username'] = $_COOKIE['remember_me'];
    header('Location: ../../index.php'); // Redirect to dashboard
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Display all errors for debugging (only use in development)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate form data
    if (empty($username) || empty($password)) {
        echo "<script>
                alert('Both username and password are required.');
                window.history.back();  // Redirect back to the login page
              </script>";
        exit();
    }

    // Database connection parameters
    $dsn = "mysql:host=localhost;dbname=kanemochi_admin"; // Change `order_db` to your database name
    $dbusername = "root";                           // Change to your database username
    $dbpassword = "";                               // Change to your database password

    try {
        // Create a new PDO instance and set error mode to exception
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare an SQL statement to select the user with the given username
        $query = "SELECT username, password FROM admin WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password using the password hash stored in the database
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a session and redirect to a secured page
                $_SESSION['username'] = $user['username'];

                if ($rememberMe) {
                    // Set cookie for 30 days
                    setcookie('remember_me', $user['username'], time() + (30 * 24 * 60 * 60), "/");
                }

                echo "<script>
                        alert('Login successful!');
                        window.location.href = '../../index.php'; // Redirect to the dashboard or secured page
                      </script>";
            } else {
                // Password is incorrect
                echo "<script>
                        alert('Incorrect password.');
                        window.history.back();  // Redirect back to the login page
                      </script>";
            }
        } else {
            // Username does not exist
            echo "<script>
                    alert('Username not found. Please register first.');
                    window.location.href = 'register.html';  // Redirect to the registration page
                  </script>";
        }

    } catch (PDOException $e) {
        // Handle any other database connection or query errors
        echo "<script>
                alert('Connection or query failed: " . htmlspecialchars($e->getMessage()) . "');
                window.history.back();  // Redirect back to the login page
              </script>";
    } finally {
        // Clean up
        $pdo = null; // Close the database connection
        $stmt = null; // Close the statement
    }

    exit();
} else {
    // Handle invalid request method
    echo "<script>
            alert('Invalid request.');
            window.history.back();  // Redirect back to the login page
          </script>";
    exit();
}
