<?php
$page_title = "Dashboard";
include 'header.php';
?>

<h4 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <h5>Create Camp</h5>
            <a href="createcamp.php" class="btn btn-success mt-2">Open</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <h5>Camp List</h5>
            <a href="camplist.php" class="btn btn-success mt-2">Open</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <h5>Camp Registration</h5>
            <a href="campuser.php" class="btn btn-success mt-2">Open</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>