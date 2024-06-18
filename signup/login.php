<?php

$login = 0;
$invalid = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $login = 1;
            session_start();
            $_SESSION['username'] = $username;
            header('location:home.php');
        } else {
            $invalid = 1;
        }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <?php
    if($invalid){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error</strong> Please check your login details.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        };

    if($login){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Great!</strong> you are logged in.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        };

  ?>
<div class="login">
    <a href="signup.php" class="btn btn-succes">Signup</a>
</div>    
<div class="container-fluid">
        <h1 class="text-center">Login</h1>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-outline-primary w-100">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>