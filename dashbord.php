<?php
session_start();

//check security: login.php, aagar koi bina login kiye sedhe is page pr aane ke kosis kare to wapas login page pr jaye
if (!isset($_SESSION['student'])) {
    header("Location: register.html");
    exit();
}

// login student ka data section nikalna
$student = $_SESSION['student'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Desktop Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; }
        .navbar { background-color: #007bff; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar h2 { margin: 0; font-size: 22px; }
        .logout-btn { background-color: #dc3545; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: bold; transition: 0.2s; }
        .logout-btn:hover { background-color: #c82333; }
        
        .main-container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .welcome-msg { font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        
        .details-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .details-table th, .details-table td { padding: 14px; text-align: left; border-bottom: 1px solid #e0e0e0; font-size: 16px; }
        .details-table th { background-color: #f8f9fa; color: #555; width: 35%; font-weight: 600; }
        .details-table td { color: #333; }
        
        /* कोर्स को हाइलाइट करने के लिए */
        .course-badge { background-color: #e2f0fd; color: #007bff; padding: 4px 10px; border-radius: 4px; font-weight: bold; display: inline-block; }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <div class="navbar">
        <h2>💻 Student Portal</h2>
        <!-- सुरक्षित तरीके से बाहर निकलने के लिए logout.php पर जाएगा -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Desktop Dashboard -->
    <div class="main-container">
        <div class="welcome-msg">
            Welcome back, <strong><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></strong>!
        </div>

        <table class="details-table">
            <tr>
                <th>Student ID</th>
                <td>#<?php echo $student['id']; ?></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?php echo htmlspecialchars($student['first_name']); ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?php echo htmlspecialchars($student['last_name']); ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?php echo date("d-M-Y", strtotime($student['date_of_birth'])); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($student['gender']); ?></td>
            </tr>
            <tr>
                <th>Email Id</th>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
            </tr>
            <tr>
                <th>Enrolled Course</th>
                <td><span class="course-badge"><?php echo htmlspecialchars($student['course']); ?></span></td>
            </tr>
        </table>
    </div>

</body>
</html>
