<?php
session_start();
include 'config.php';

// सुरक्षा जाँच: अगर OTP वेरीफाई नहीं हुआ है तो इस पेज पर न आने दें
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: forgot_password.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['reset_email'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // पासवर्ड को सुरक्षित तरीके से Encrypt (Hash) करना
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // डेटाबेस में नया पासवर्ड अपडेट करना
        $stmt = $conn->prepare("UPDATE student_registration SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            $success = "Password updated successfully! Redirecting to login...";
            
            // काम पूरा होने के बाद सेशन क्लियर करना
            session_unset();
            session_destroy();
            
            // 3 सेकंड बाद वापस लॉगिन पेज पर भेजें
            header("refresh:3;url=signin.php");
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #FF5722; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
        .success { color: green; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create New Password</h2>
    <?php if(!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
    <?php if(!empty($success)) { echo "<div class='success'>$success</div>"; } ?>
    
    <form action="reset_password.php" method="POST">
        <label>New Password</label>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
        
        <button type="submit">Update Password</button>
    </form>
</div>
</body>
</html>
