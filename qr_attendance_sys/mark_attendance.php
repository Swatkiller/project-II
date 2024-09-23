<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your database username
$password = "mysql"; // replace with your database password
$dbname = "attendance_sys"; // replace with your database name

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
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO attendance (sid, date, status) VALUES (?, CURDATE(), 'Present')");
    $stmt->bind_param("i", $sid);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php?message=Attendance marked successfully.");
        exit();
    } else {
        // Redirect to error page
        header("Location: error.php?message=Error marking attendance: " . urlencode($stmt->error));
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect to error page
    header("Location: error.php?message=Invalid data received.");
    exit();
}

// Close the database connection
$conn->close();
?>
