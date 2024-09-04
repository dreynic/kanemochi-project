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

    // Check if the file was uploaded without errors
    if (isset($_FILES["imageInput"]) && $_FILES["imageInput"]["error"] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES["imageInput"]["tmp_name"];
        $fileName = $_FILES["imageInput"]["name"];
        $fileSize = $_FILES["imageInput"]["size"];
        $fileType = $_FILES["imageInput"]["type"];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($fileExtension, $allowedExtensions)) {
            // Check file size (limit to 5MB)
            if ($fileSize < 5242880) {
                // Generate a unique file name to avoid overwriting existing files
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                
                // Set upload directory path
                $uploadFileDir = '../../uploads/';
                $dest_path = $uploadFileDir . $newFileName;

                // Move the file to the specified directory
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    try {
                        // Database connection details
                        $dsn = "mysql:host=localhost;dbname=order_db";
                        $dbusername = "root";
                        $dbpassword = "";

                        // Create a new PDO instance
                        $pdo = new PDO($dsn, $dbusername, $dbpassword);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Prepare the SQL query to insert data, including the timestamp
                        $query = "INSERT INTO shipment2 (order_id, image_path, submit) VALUES (?, ?, ?)";
                        $stmt = $pdo->prepare($query);

                        // Execute the query with form data, image path, and timestamp
                        if ($stmt->execute([$order_id, $newFileName, $submit])) {
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
                    echo "<script>
                        alert('There was an error moving the uploaded file.');
                        window.location.href = '../../index.php';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('File size exceeds 5MB limit.');
                    window.location.href = '../../index.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');
                window.location.href = '../../index.php';
            </script>";
        }
    } else {
        // Check if there was an error during file upload and handle it
        $error = $_FILES["imageInput"]["error"];
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "A PHP extension stopped the file upload.";
                break;
            default:
                $message = "Unknown upload error.";
                break;
        }
        echo "<script>
            alert('Error: $message');
            window.location.href = '../../index.php';
        </script>";
    }
} else {
    // Redirect to home page if the request is not POST
    header("Location: ../../index.php");
    exit();
}
?>
