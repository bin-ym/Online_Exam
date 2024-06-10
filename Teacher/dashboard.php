<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit;
}

$teacherName = '';
$stmt = $conn->prepare('SELECT teacher_name FROM teachers WHERE email = ?');
$stmt->bind_param('s', $_SESSION['email']);
$stmt->execute();
$stmt->bind_result($teacherName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Teacher Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="create_exam.php">Create Exam</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_exams.php">Manage Exams</a></li>
                    <li class="nav-item"><a class="nav-link" href="schedule_exams.php">Schedule Exams</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_students.php">Manage Students</a></li>
                    <li class="nav-item logout-link"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-9 content">
                <h2>Welcome, <?php echo $teacherName; ?>!</h2>
                <p>Use the navigation menu to manage your exams and students.</p>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
