<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - CampCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-success">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="student-dashboard.php">CampCare</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?php echo htmlspecialchars($_SESSION['student_name']); ?></span>
                <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">


            <div class="col-md-3 col-lg-2 bg-white border-end min-vh-100 p-3">
                <div class="nav flex-column nav-pills">
                    <a class="nav-link <?php echo ($current == 'student-dashboard.php') ? 'active' : ''; ?>" href="student-dashboard.php">Dashboard</a>
                    <a class="nav-link <?php echo ($current == 'camplist.php') ? 'active' : ''; ?>" href="camplist.php">Camp List</a>
                    <a class="nav-link <?php echo ($current == 'userslist.php') ? 'active' : ''; ?>" href="userslist.php">Camp Users</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">