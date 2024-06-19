<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";

    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $token);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $new_password, $token);

        if ($stmt->execute()) {
            echo "Your password has been reset successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid or expired token.";
    }
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    echo "Invalid request.";
    exit;
}
?>
