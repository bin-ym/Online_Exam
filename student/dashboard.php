<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

$studentName = '';
$stmt = $conn->prepare('SELECT student_name FROM students WHERE email = ?');
$stmt->bind_param('s', $_SESSION['email']);
$stmt->execute();
$stmt->bind_result($studentName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Student Dashboard</title>
    <style>
        footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="exam_selection.php">Exam Selection</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_results.php">View Results</a></li>
                    <li class="nav-item"><a class="nav-link" href="study_materials.php">Study Materials</a></li>
                    <li class="nav-item logout-link"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-9 content">
                <h2>Welcome, <?php echo $studentName; ?>!</h2>
                <p>Use the navigation menu to take exams and view results.</p>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
