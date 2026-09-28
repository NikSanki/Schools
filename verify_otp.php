<?php
session_start();

// अगर सीधे कोई इस पेज पर आए बिना ईमेल सबमिट किए, तो उसे वापस भेजें
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
    header("Location: forgot_password.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = trim($_POST['otp']);

    // सेशन वाले OTP से मैच करना
    if ($user_otp == $_SESSION['reset_otp']) {
        $_SESSION['otp_verified'] = true; // वेरिफिकेशन फ्लैग सेट करें
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "Invalid OTP! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        input[type="text"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; text-align: center; font-size: 18px; letter-spacing: 5px; }
        button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Enter OTP</h2>
    <p style="text-align: center; font-size: 14px; color: #666;">OTP sent to <?php echo $_SESSION['reset_email']; ?></p>
    <?php if(!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
    
    <form action="verify_otp.php" method="POST">
        <input type="text" name="otp" maxlength="6" placeholder="******" required>
        <button type="submit">Verify OTP</button>
    </form>
</div>
</body>
</html>
