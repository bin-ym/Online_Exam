<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for creating or updating exam templates
    $template_name = $_POST['template_name'];
    // Add more fields as necessary

    $stmt = $conn->prepare('INSERT INTO exam_templates (template_name) VALUES (?)');
    $stmt->bind_param('s', $template_name);
    $stmt->execute();
    $stmt->close();

    header('Location: exam_templates.php?success=1');
    exit;
}

// Fetch existing templates
$templates = [];
$stmt = $conn->prepare('SELECT * FROM exam_templates');
$stmt->execute();
$result = $stmt->get_result();
$templates = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Admin - Exam Templates</title>
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
        <h2>Exam Templates</h2>
        <form action="exam_templates.php" method="post">
            <div class="form-group">
                <label for="template_name">Template Name:</label>
                <input type="text" class="form-control" id="template_name" name="template_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Template</button>
        </form>
        <h3>Existing Templates</h3>
        <ul class="list-group">
            <?php foreach ($templates as $template): ?>
                <li class="list-group-item"><?php echo htmlspecialchars($template['template_name']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
