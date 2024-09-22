<?php
require "./db_connection.php";

// Get the QR code data from the request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['qr_code_data'])) {
    $qr_code_data = $data['qr_code_data'];

    // Parse the QR code data
    list($id_str, $student_id, $grade_str, $grade, $section_str, $section) = explode("\n", $qr_code_data);
    
    // Extract student ID
    $student_id = str_replace('ID: ', '', $student_id);

    // Prepare attendance data
    $status = "Present";
    $date = date('Y-m-d'); // Current date

    // Insert or update attendance record
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status=?");
    if ($stmt) {
        $stmt->bind_param("isss", $student_id, $date, $status, $status);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating attendance: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "No QR code data received."]);
}
?>
