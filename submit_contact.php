<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Replace with your RDS database credentials
$servername = "g4lab8.czptxhzjxjrt.us-east-1.rds.amazonaws.com";
$username = "rushilshahfainalexam";
$password = "Rushilshah$";
$dbname = "hotelfainalexam";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $email = $_POST['email'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $message = $_POST['message'] ?? null;

    // Validate input data
    if (!$name || !$phone || !$email || !$subject || !$message) {
        throw new Exception("All fields are required.");
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $phone, $email, $subject, $message);

    // Execute the query and check for success
    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    echo "New record created successfully";

    // Close connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Log the error (you can also save it in a log file)
    error_log($e->getMessage());

    // Return a user-friendly error message
    echo "An error occurred. Please try again later.";
}
?>
