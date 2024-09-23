<?php
$last_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$full_name = isset($_GET['full_name']) ? $_GET['full_name'] : 'Student';

require './db_connection.php';

$stmt = $conn->prepare("SELECT image, qr_code, first_name, last_name, grade, section, fathers_name, mobileno FROM student_details WHERE sid = ?");
$stmt->bind_param("i", $last_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Student not found.";
    exit();
}

$photo_path = $student['image']; 
$qr_code_path = './qrcodes/' . $student['qr_code']; 

// Student details
$full_name = $student['first_name'] . ' ' . $student['last_name'];
$grade = $student['grade'];
$section = $student['section'];
$fathers_name = $student['fathers_name'];
$mobile_no = $student['mobileno'];

if (!file_exists($photo_path)) {
    echo "<script>alert('Profile image not found at: $photo_path');</script>";
}
if (!file_exists($qr_code_path)) {
    echo "<script>alert('QR code not found at: $qr_code_path');</script>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Show QR Code</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .id-card {
        width: 350px;
        height: 500px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
    }

    .id-card img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .id-card h2 {
        font-size: 24px;
        margin: 8px 50px;
        color: #333;
        text-align: left;
    }

    .id-card p {
        font-size: 16px;
        color: #777;
        margin: 5px 0;
    }

    .id-card .qr-code img {
        width: 150px;
        height: 150px;
    }
</style>
</head>

<body>

    <div class="id-card">
        <!-- Student's Photo -->
        <img src="<?php echo htmlspecialchars($photo_path); ?>" alt="Student Photo">

        <div class="id-details">

            <h2>Student ID:
                <?php echo htmlspecialchars($last_id)?>
            </h2>
            <!-- Student's Name -->
            <h2>Name:
                <?php echo htmlspecialchars($full_name); ?>
            </h2>

            <!-- Grade and Section -->
            <h2>Grade:
                <?php echo htmlspecialchars($grade) . ' ' . htmlspecialchars($section); ?>
            </h2>

            <!-- Father's Name -->
            <h2>Father's Name:
                <?php echo htmlspecialchars($fathers_name); ?>
            </h2>

            <!-- Mobile Number -->
            <h2>Contact:
                <?php echo htmlspecialchars($mobile_no); ?>
            </h2>

        </div>
        <!-- QR Code -->
        <div class="qr-code">
            <img src="<?php echo htmlspecialchars($qr_code_path); ?>" alt="QR Code">
        </div>
    </div>

</body>

</html>