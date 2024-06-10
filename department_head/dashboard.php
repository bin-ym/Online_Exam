<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'department_head') {
    header('Location: ../login.php');
    exit;
}

$headName = '';
$stmt = $conn->prepare('SELECT head_name FROM department_heads WHERE email = ?');
$stmt->bind_param('s', $_SESSION['email']);
$stmt->execute();
$stmt->bind_result($headName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Department Head Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="manage_accounts.php">Manage Accounts</a></li>
                    <li class="nav-item"><a class="nav-link" href="assign_exams.php">Assign Exams</a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="activities.php">Activities</a></li>
                    <li class="nav-item logout-link"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-9 content">
                <h2>Welcome, <?php echo $headName; ?>!</h2>
                <p>Use the navigation menu to manage accounts and exams.</p>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
