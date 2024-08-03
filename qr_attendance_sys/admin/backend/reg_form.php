<?php
require "./db_connection.php";
require "../header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $address = $_POST['address'];
    $fathers_name = $_POST['fathers_name'];
    $mothers_name = $_POST['mothers_name'];
    $section = $_POST['section'];
    $grade = $_POST['grade'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
    $dob = isset($_POST['dob']) ? $_POST['dob'] : NULL;
    $mobile_no = $_POST['mobile_no'];
    $email = $_POST['email'];

    // Handle image upload
    if ($_FILES['profile_image']['name']) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "<script>alert('Error uploading file.'); window.location.href='../registration.php';</script>";
            exit();
        }
    } else {
        $image_path = NULL;
    }

    $section = ucwords($section); //capitalize section input

    // insert statement for student details
    $stmt = $conn->prepare("INSERT INTO student_details (first_name, last_name, address, image, fathers_name, mothers_name, section, grade, gender, dob, mobileno, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssssssss", $first_name, $last_name, $address, $image_path, $fathers_name, $mothers_name, $section, $grade, $gender, $dob, $mobile_no, $email);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        // Generate QR code
        $command = escapeshellcmd("python3 \"./generate_qr.py\" $last_id " . escapeshellarg($section) . " " . escapeshellarg($grade));
        $output = shell_exec($command . " 2>&1"); 

        $log_data = "Command: $command\nOutput: $output\n";
        file_put_contents(__DIR__ . '/qrcodes/log.txt', $log_data, FILE_APPEND);

        $qr_code_file_name = 'student_' . $last_id . '.png';
        $qr_code_location = __DIR__ . '/qrcodes/' . $qr_code_file_name;

        // Check for QR code file 
        if (!file_exists($qr_code_location)) {
            echo "<script>alert('QR code file not found at: $qr_code_location'); window.location.href = '../registration.php';</script>";
            exit();
        }

        // Inserting into the `students` table
        $stmt2 = $conn->prepare("INSERT INTO students (student_id, name, email, qr_code, section, grade, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if (!$stmt2) {
            die("Prepare failed: " . $conn->error);
        }

        $full_name = $first_name . ' ' . $last_name;

        // Bind parameters
        $stmt2->bind_param("isssss", $last_id, $full_name, $email, $qr_code_file_name, $section, $grade);

        if ($stmt2->execute()) {
            if (strpos($output, 'QR code generated and saved at') !== false) {

                header("Location: ../reg_success.php?id=$last_id&full_name=" . urlencode($full_name));
                exit();
            } else {
                echo "<script>alert('Error generating QR code. See log for details.'); window.location.href = '../registration.php';</script>";
            }
        } else {
            echo "<script>alert('Error: " . $stmt2->error . "'); window.location.href = '../registration.php';</script>";
        }

        $stmt2->close();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = '../registration.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
