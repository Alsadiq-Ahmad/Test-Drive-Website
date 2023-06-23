<?php
session_start();

$_SESSION['submit'] = true;

@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['submit'])) {
      $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
      $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
      $pass = isset($_POST['password']) ? md5($_POST['password']) : '';
      $cpass = isset($_POST['cpassword']) ? md5($_POST['cpassword']) : '';
      $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

      $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";

      $result = mysqli_query($conn, $select);

      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);

         if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('Location: ../Admin/AddCar.php');
            exit();
         } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('Location: ../index.php');
            exit();
         }
      } else {
         $error[] = 'Incorrect email or password!';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="shortcut icon" type="x-icon" href="img/jeep2.png">
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>Login</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            }
         }
         ?>
         <input type="email" name="email" required autocomplete="off" placeholder="Enter your email">
         <input type="password" name="password" required autocomplete="off" placeholder="Enter your password">
         <input type="submit" name="submit" value="Login now" class="form-btn">
         <p>Don't have an account? <a href="register_form.php">Register now</a></p>
         <p><a href="forget_pass_form0.1.php">Forgot your password?</a></p>
      </form>
   </div>
</body>
</html>
