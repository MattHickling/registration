<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";
    echo "Connected";

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            echo "This username already exists";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo "Signup successful";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

  <div class="container-fluid">
        <h1 class="text-center">Signup here</h1>
        <form action="signup.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-outline-primary width-auto">Submit</button>
        </form>
    </div>
  </body>
</html>