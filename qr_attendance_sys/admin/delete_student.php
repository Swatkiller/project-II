<?php
// Database connection details
$servername = "localhost";
$username = "root"; // replace with your database username
$password = "mysql"; // replace with your database password
$dbname = "attendance_sys"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the student ID (sid) from the URL
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';

if (!empty($sid)) {
    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM student_details WHERE sid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sid);

    if ($stmt->execute()) {
        // Redirect back to the student list with a success message
        header("Location: manage_students.php?message=Student%20deleted%20successfully");
        exit();
    } else {
        echo "Error deleting student: " . $conn->error;
    }
} else {
    echo "Invalid student ID.";
}

// Close connection
$conn->close();
?>
