<?php
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Send Email
        $to = "yourmail@example.com";   // CHANGE THIS TO YOUR EMAIL
        $mail_subject = "New Contact Message: $subject";
        $body = "You have received a new message from your website:\n\n".
                "Name: $name\n".
                "Email: $email\n".
                "Subject: $subject\n".
                "Message:\n$message";

        $headers = "From: $email";

        if (mail($to, $mail_subject, $body, $headers)) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
        } else {
            echo "<script>alert('Message stored but email could not be sent.'); window.location.href='contact.html';</script>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
