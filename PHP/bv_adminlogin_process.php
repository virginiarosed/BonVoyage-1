<?php
include('../PHP/db_connection.php');

// Get user input
$email = $_POST['email'];
$password = $_POST['password'];

// Query to check credentials
$sql = "SELECT * FROM admin_users WHERE email = ? AND password = SHA2(?, 256)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Start the session and set session variables
    session_start();
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $email; // Store email or other relevant info
    
    // Redirect to the admin dashboard
    header("Location: /for_project/Admin_HTML/bv_adminhome.html");    // Redirect to admin dashboard
    exit();
} else {
    // Failure: Redirect back to login with an error message
    header("Location: /for_project/Admin_HTML/bv_adminhome.html?error=Invalid credentials");
    exit();
}

// Close the connection
$stmt->close();
$conn->close();
?>
