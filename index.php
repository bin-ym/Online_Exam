<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['email'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: admin/dashboard.php');
            break;
        case 'department_head':
            header('Location: department_head/dashboard.php');
            break;
        case 'student':
            header('Location: student/dashboard.php');
            break;
        case 'teacher':
            header('Location: teacher/dashboard.php');
            break;
    }
    exit;
}

if (isset($_POST['submit'])) {
    require_once 'ajax/handle_login.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Online Exam System</title>
    <style>
        footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h1>Welcome to the Online Exam System</h1>
        <div id="content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                $filename = $page . '.php';
                if (file_exists($filename)) {
                    include($filename);
                } else {
                    echo '<h2>Page not found.</h2>';
                }
            }
            ?>
        </div>
        <div id="LoginForm">
            <h2>Login</h2>
            <form id="loginForm" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'ajax/handle_login.php',
                data: $(this).serialize(),
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        switch (data.role) {
                            case 'admin':
                                window.location.href = 'admin/dashboard.php';
                                break;
                            case 'student':
                                window.location.href = 'student/dashboard.php';
                                break;
                            case 'teacher':
                                window.location.href = 'teacher/dashboard.php';
                                break;
                            default:
                                window.location.href = 'default_dashboard.php';
                        }
                    } else {
                        $('#LoginForm').prepend('<div class="alert alert-danger">Invalid email or password</div>');
                    }
                }
            });
        });

        function loadContent(url) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    document.getElementById("LoginForm").style.display = 'none';
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    </script>
</body>
</html>
