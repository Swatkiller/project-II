<?php
// Database connection
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

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['qr_code_data'])) {
    // Example: The decrypted QR code data contains the student ID, grade, and section
    $qr_code_data = $data['qr_code_data'];
    
    // Assuming your QR code contains: ID, Grade, and Section separated by newlines
    list($id_line, $grade_line, $section_line) = explode("\n", $qr_code_data);

    // Extract student ID from the first line (e.g., "ID: 12345")
    $student_id = trim(str_replace("ID:", "", $id_line));

    // Set the current date
    $current_date = date('Y-m-d');

    // Mark attendance as "present" for this student for today's date
    $sql = "INSERT INTO attendance (student_id, date, status) 
            VALUES ('$student_id', '$current_date', 'present')
            ON DUPLICATE KEY UPDATE status='present'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Attendance marked successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error marking attendance: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
}

// Close the database connection
$conn->close();
?>
