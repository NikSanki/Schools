<?php
session_start();
include 'config.php'; // databases connection file

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    //   database se student ka email check karna
    $stmt = $conn->prepare("SELECT * FROM student_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        
        //password check (Verify encrypted password)
        if (password_verify($password, $student['password'])) {
            // (Session)  student ka data store karna
            $_SESSION['student'] = $student;
            
            //  login hone ke bad darect dashbord pr jana
            header("Location: dashboard.php"); 
            exit();
        } else {
            $error = "Wrong password! Please try again.";
        }
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
    <title>Student Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #45a049; }
        .error-msg { color: red; text-align: center; margin-bottom: 15px; font-size: 14px; }
        .links-container { text-align: center; margin-top: 15px; font-size: 14px; }
        .links-container a { text-decoration: none; display: inline-block; margin: 5px 0; }
        .reg-link { color: #007BFF; }
        .forgot-link { color: #dc3545; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Student Login</h2>
    
    <!--   wrong password and email hone pr error dekhana-->
    <?php if(!empty($error)) { ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php } ?>

    <!-- action khale rakne se login.php pr submit hoga -->
    <form action="" method="POST">
        <label>Email ID</label>
        <input type="email" name="email" placeholder="Enter your Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your Password" required>

        <button type="submit">Login</button>
    </form>

    <!--   dodno link ko set kara-->
    <div class="links-container">
        Create New account? <a href="register.html" class="reg-link">Register Here</a>
        <br>
        <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
    </div>

</div>

</body>
</html>
