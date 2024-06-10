<?php
session_start();
require_once '../db.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $role = '';
        $stmt = $conn->prepare('SELECT role FROM users WHERE email = ? AND password = ?');
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        if ($role) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            echo json_encode(['status' => 'success', 'role' => $role]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
?>
