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
            $successMessage = "A password reset link has been sent to your email address.";
        } else {
            $errorMessage = "Failed to send email.";
        }
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgotten Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Forgotten Password</h1>
        
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
<div>
    <a href="login.php" class="btn btn-success mb-4">Login</a>
    <a href="signup.php" class="btn btn-success mb-4">Signup</a>
</div>
        <form action="forget.php" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
