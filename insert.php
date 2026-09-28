<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    
    // पासवर्ड एन्क्रिप्ट करना
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Database में सेव करने के लिए Query
    $stmt = $conn->prepare("INSERT INTO student_registration (first_name, last_name, date_of_birth, gender, email, password, phone_number, course) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $dob, $gender, $email, $password, $phone, $course);

    if ($stmt->execute()) {
        // डेटा सेव होने के बाद सीधा लॉगिन पेज पर भेज देगा
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
