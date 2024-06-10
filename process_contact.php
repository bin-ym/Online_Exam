<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare('INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    header('Location: contact.php?success=1');
    exit;
} else {
    header('Location: contact.php');
    exit;
}
?>
