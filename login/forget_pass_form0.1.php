<?php
session_start();

@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['submit'])) {
      $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
      $new_pass = isset($_POST['new_password']) ? md5($_POST['new_password']) : '';
      $c_new_pass = isset($_POST['confirm_new_password']) ? md5($_POST['confirm_new_password']) : '';
      $slct = isset($_POST['select']) ? $_POST['select'] : '';
      $ans = isset($_POST['answer']) ? mysqli_real_escape_string($conn, $_POST['answer']) : '';

      $select = "SELECT * FROM user_form WHERE email = '$email'";
      $result = mysqli_query($conn, $select);

      if (mysqli_num_rows($result) > 0) {
         if ($new_pass == $c_new_pass) {
            $update = "UPDATE user_form SET password = '$new_pass' WHERE email = '$email' AND answer = '$ans' AND question = '$slct'";
            $res = mysqli_query($conn, $update);
            if ($res) {
               $success = "Password reset successful";
               // Redirect to login page
               header('Location: login_form.php');
               exit();
            } else {
               $error = "Password reset failed, try again";
            }
         } else {
            $error = "New password and confirm new password do not match";
         }
      } else {
         $error = "Email does not exist, please register";
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
   <title>Reset Password</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>Reset Password</h3>
      <?php
      if(isset($error)){
         echo '<span class="error-msg">'.$error.'</span>';
      };
      if(isset($success)){
         echo '<span class="success-msg">'.$success.'</span>';
      };
      ?>
      <input type="email" name="email" required autocomplete="off" placeholder="Enter your email">
      <input type="password" name="new_password" required autocomplete="off" placeholder="Enter your new password">
      <input type="password" name="confirm_new_password" required autocomplete="off" placeholder="Confirm your new password">
      <select name="select" id="">
                                <option disabled selected>Select the question</option>
                                <option>What was your first car?</option>
                                <option>What elementary school did you attend?</option>
                                <option>What is the name of your first pet?</option>
      </select>
      <input type="text" name="answer" required autocomplete="off" placeholder="Enter your answer">
      <input type="submit" name="submit" value="Reset password" class="form-btn">

   </form>

</div>

</body>
</html>
