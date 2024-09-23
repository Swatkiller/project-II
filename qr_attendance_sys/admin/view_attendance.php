<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "attendance_sys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the student ID (sid) from the URL or session
$sid = isset($_GET['sid']) ? trim($_GET['sid']) : '';
if (empty($sid)) {
    echo "Invalid student ID.";
    exit();
}

// Fetch student name from student_details table
$sql_student = "SELECT first_name, last_name FROM student_details WHERE sid = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("s", $sid);
$stmt_student->execute();
$result_student = $stmt_student->get_result();

if ($result_student->num_rows === 0) {
    echo "No student found with the provided ID: " . htmlspecialchars($sid);
    exit();
}

$student = $result_student->fetch_assoc();
$student_name = $student['first_name'] . ' ' . $student['last_name'];

// Fetch attendance records for the student
$sql_attendance = "SELECT date, status FROM attendance WHERE sid = ? ORDER BY date DESC";
$stmt_attendance = $conn->prepare($sql_attendance);
$stmt_attendance->bind_param("s", $sid);
$stmt_attendance->execute();
$result_attendance = $stmt_attendance->get_result();

// Calculate total present days
$sql_present_count = "SELECT COUNT(*) as total_present FROM attendance WHERE sid = ? AND status = 'Present'";
$stmt_present_count = $conn->prepare($sql_present_count);
$stmt_present_count->bind_param("s", $sid);
$stmt_present_count->execute();
$result_present_count = $stmt_present_count->get_result();
$total_present = $result_present_count->fetch_assoc()['total_present'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="text-center">Attendance for <?php echo htmlspecialchars($student_name); ?></h1>
    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($sid); ?></p>
    <p><strong>Total Present Days:</strong> <?php echo $total_present; ?></p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_attendance->num_rows > 0): ?>
                <?php while ($row = $result_attendance->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="manage_students.php" class="btn btn-primary">Back to Manage Students</a>
</div>
</body>
</html>
