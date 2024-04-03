<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <?php
    require('config.php');
    if(isset($_POST['login']))
    {
        $email= $_POST['email'];
        $pass= $_POST['password'];
        $sql = "SELECT * FROM users WHERE user_email='$email' AND user_password='$pass'";

       $result = $conn->query($sql);
        if ($result->num_rows === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['user_email'] === $email && $row['user_password'] === $pass) {
                echo "Logged in!";
                $_SESSION['name'] = $row['user_name'];
                $_SESSION['email'] = $row['user_email'];
                $_SESSION['id'] = $row['id'];
                header("Location: dashboard.php");
                exit();
            }
        }  
    }
?>

</head>
<body>
    <h2>Login</h2>
       <form method="POST">

      <label for="email">Email Address</label>

      <input type="email" id="email" name="email" required><br><br>

      <label for="password">Password</label>

      <input type="password" id="password" name="password" required><br><br>

      <input type="submit" value="Login" name="login">

    </form>
</body>
</html>