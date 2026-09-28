<?php
session_start();
include 'config.php'; //  your databases connection file

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    //  check database email ablevel yes or not
    $stmt = $conn->prepare("SELECT * FROM student_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        //  password reset logic set
        $message = "Password reset link has been sent to your email ID!";
    } else {
        $error = "This email ID is not registered!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        input[type="email"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error-msg { color: red; text-align: center; margin-bottom: 15px; font-size: 14px; }
        .success-msg { color: green; text-align: center; margin-bottom: 15px; font-size: 14px; }
        .back-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .back-link a { color: #4CAF50; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>
    
    <?php if(!empty($error)) { ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php } ?>
    
    <?php if(!empty($message)) { ?>
        <div class="success-msg"><?php echo $message; ?></div>
    <?php } ?>

    <form action="forgot_password.php" method="POST">
        <label>Enter your Registered Email</label>
        <input type="email" name="email" placeholder="example@gmail.com" required>

        <button type="submit">Send Reset Link</button>
    </form>

    <div class="back-link">
        <!-- login.php  go to login page -->
        <a href="login.php">← Back to Login</a>
    </div>
</div>

</body>
</html>
