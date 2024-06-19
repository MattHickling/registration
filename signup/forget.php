<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";

    $email = $_POST["email"];
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $sql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('sss', $token, $expiry, $email);

    if ($stmt->execute()) {
        $resetLink = "http://localhost/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click on the following link to reset your password: $resetLink";
        $headers = "From: no-reply@localhost";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email address.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
