<?php
require 'vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

// Disable error display in production
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

try {
    // Fetch database credentials securely from AWS Secrets Manager
    $client = new SecretsManagerClient([
        'region' => 'us-east-1',
        'version' => 'latest'
    ]);

    $secretName = 'your-secret-name'; // Replace with actual AWS Secrets Manager secret name
    $result = $client->getSecretValue(['SecretId' => $secretName]);

    if (isset($result['SecretString'])) {
        $secret = json_decode($result['SecretString'], true);
    } else {
        throw new Exception("Could not retrieve database credentials.");
    }

    $servername = $secret['host'];
    $username = $secret['username'];
    $password = $secret['password'];
    $dbname = $secret['dbname'];

    // Establish database connection securely
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate input data
    if (!$name || !$phone || !$email || !$subject || !$message) {
        throw new Exception("All fields are required and email must be valid.");
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $phone, $email, $subject, $message);

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    echo "New record created successfully";

    // Close resources
    $stmt->close();
    $conn->close();
} catch (AwsException $e) {
    error_log("AWS Error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}
?>
