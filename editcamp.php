<?php
include 'config.php';

$error = "";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (isset($_POST['update_camp'])) {
    $camp_name   = $_POST['camp_name'];
    $camp_date   = $_POST['camp_date'];
    $location    = $_POST['location'];
    $fees        = $_POST['fees'];
    $description = $_POST['description'];

    if ($camp_name == "" || $camp_date == "" || $location == "" || $fees == "" || $description == "") {
        $error = "Please fill all fields.";
    } elseif (!is_numeric($fees) || $fees < 0) {
        $error = "Fees must be a valid number.";
    } else {
        $fees = (int)$fees;

        $sql = "UPDATE camps SET camp_name = '$camp_name', camp_date = '$camp_date', location = '$location',
        fees = '$fees', description = '$description' WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header("Location: camplist.php");
            exit;
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

$result = mysqli_query($conn, "SELECT * FROM camps WHERE id = $id");
$camp = mysqli_fetch_assoc($result);

if (!$camp) {
    header("Location: camplist.php");
    exit;
}

include 'header.php';
?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <h4 class="mb-4">Edit Camp</h4>

        <?php if ($error != "") { ?>
            <div id="errorMsg" class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <script>
            setTimeout(function() {
                var errorMsg = document.getElementById("errorMsg");

                if (errorMsg) {
                    errorMsg.style.display = "none";
                }
            }, 10000);
        </script>

        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="camp_name" class="form-label">Camp Name</label>
                    <input type="text" class="form-control" id="camp_name" name="camp_name" placeholder="Enter camp name" value="<?php echo htmlspecialchars($camp['camp_name']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="camp_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="camp_date" name="camp_date" value="<?php echo htmlspecialchars($camp['camp_date']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" value="<?php echo htmlspecialchars($camp['location']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="fees" class="form-label">Fees</label>
                    <input type="number" class="form-control" id="fees" name="fees" placeholder="Enter fees" min="0" value="<?php echo htmlspecialchars($camp['fees']); ?>" required>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description" required><?php echo htmlspecialchars($camp['description']); ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" name="update_camp" class="btn btn-success px-4">Update Camp</button>
                    <a href="camplist.php" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>