<?php
require_once '../db.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'load_exams':
            $stmt = $conn->prepare('SELECT * FROM exams');
            $stmt->execute();
            $result = $stmt->get_result();
            $exams = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($exams);
            break;

        // Add more cases for other content loads as needed

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
}
?>
