<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Process the form data (e.g., save to database, send email, etc.)
    // For now, let's just output the data to the screen
    echo "Form submitted successfully!";
} else {
    echo "Invalid request method.";
}
?>
