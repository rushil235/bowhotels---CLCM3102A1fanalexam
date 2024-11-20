<?php
// Replace with your RDS database credentials
$servername = "g4lab8.czptxhzjxjrt.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Melburn3$";
$dbname = "g4lab8";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// SQL query to insert data
$sql = "INSERT INTO contacts (name, phone, email, subject, message) VALUES ('$name', '$phone', '$email', '$subject', '$message')";

// Execute the query and check for success
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
