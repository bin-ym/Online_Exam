<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for creating or updating user accounts
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $email, $password, $role);
    $stmt->execute();
    $stmt->close();

    header('Location: user_accounts.php?success=1');
    exit;
}

// Fetch existing users
$users = [];
$stmt = $conn->prepare('SELECT * FROM users');
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Admin - User Accounts</title>
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
        <h2>User Accounts</h2>
        <form action="user_accounts.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                    <option value="department_head">Department Head</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        
