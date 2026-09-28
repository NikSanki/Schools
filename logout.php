<?php
session_start();
session_unset();
session_destroy(); //  student session finish

// logaout ke bad go to login.php 
header("Location: /Login/login.php");
exit();
?>
http://localhost/Login/dashbord.php