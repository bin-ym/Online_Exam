<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Fetch necessary data for reports
$examReports = [];
$stmt = $conn->prepare('SELECT * FROM exams');
$stmt->execute();
$result = $stmt->get_result();
$examReports = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Admin - Reports</title>
   
