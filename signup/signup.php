<?php
$user = 0;
$success = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";

    $username = $_POST["username"];
    $password = trim($_POST["password"]);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $user = 1; 
        } else {
            $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $sql_insert)) {
                $success = 1; 
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
    <title>Signup page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

<?php
    if($user){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>On No!</strong> this user already exists.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        };
    if($success){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Great!</strong> your signup has been successful.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        };
  ?>
<div class="login btn btn-outline-succes">
    <a href="login.php" class="btn btn-outline-succes">Login</a>
</div>
    <div class="container-fluid">
        <h1 class="text-center">Signup</h1>
        <form action="signup.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary width-auto w-100">Signup</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>