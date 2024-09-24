<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = "mysql"; 
$dbname = "attendance_sys";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the data from the POST request
$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
$grade = isset($_POST['grade']) ? $_POST['grade'] : '';
$section = isset($_POST['section']) ? $_POST['section'] : '';

// Validate input
if ($sid > 0 && !empty($grade) && !empty($section)) {
    // Check if attendance has already been marked for this student today
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM attendance WHERE sid = ? AND date = CURDATE()");
    $stmt->bind_param("i", $sid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Attendance already marked for today, redirect to error page
        header("Location: error.php?message=Attendance already marked for today.");
        exit();
    }

    // Prepare and bind the insert statement if attendance is not already marked
    $stmt = $conn->prepare("INSERT INTO attendance (sid, date, status) VALUES (?, CURDATE(), 'Present')");
    $stmt->bind_param("i", $sid);

    // Execute the insert statement
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php?message=Attendance marked successfully.");
        exit();
    } else {
        // Redirect to error page with SQL error message
        header("Location: error.php?message=Error marking attendance: " . urlencode($stmt->error));
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect to error page for invalid input data
    header("Location: error.php?message=Invalid data received.");
    exit();
}

$conn->close();
?>
