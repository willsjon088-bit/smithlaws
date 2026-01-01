<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.html");
    exit;
}

// Sanitize input
$name = htmlspecialchars(strip_tags(trim($_POST["name"])));
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($_POST["message"])));

// Validate input
if (empty($name) || empty($email) || empty($message)) {
    die("Error: All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Invalid email address.");
}

// Email settings
$to = "willsjon088@gmail.com"; // CHANGE THIS
$subject = "New Legal Inquiry from Website";
$headers = "From: Website Contact <no-reply@robinsonslaw.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

// Email body
$emailBody = "New Contact Form Submission\n\n";
$emailBody .= "Name: $name\n";
$emailBody .= "Email: $email\n\n";
$emailBody .= "Message:\n$message\n\n";
$emailBody .= "NOTICE: This message does not create an attorney-client relationship.";

// Send email
if (mail($to, $subject, $emailBody, $headers)) {
    echo "
    <h2>Thank You</h2>
    <p>Your message has been sent successfully.</p>
    <p><strong>Disclaimer:</strong> Submission of this form does not create an attorney-client relationship.</p>
    <a href='index.html'>Return to Home</a>
    ";
} else {
    echo "Error: Message could not be sent. Please try again later.";
}
?>
