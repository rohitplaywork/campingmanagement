<?php
include 'config.php';
$page_title = "Camp List";
include 'header.php';

$error = "";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deletesql = "DELETE FROM camps WHERE id = $id";

    try {
        if (mysqli_query($conn, $deletesql)) {
            header("Location: camplist.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        $error = "Cannot delete this camp because registrations are linked to it.";
    }
}

$sql = "SELECT * FROM camps ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $error = "Error: " . mysqli_error($conn);
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="mb-1">Camp List</h4>
        <p class="text-muted mb-0">All available camps</p>
    </div>
    <a href="createcamp.php" class="btn btn-success px-4">+ Create Camp</a>
</div>

<?php if ($error != "") { ?>
    <div id="errorMsg" class="alert alert-danger">
        <?php echo $error; ?>
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

<div class="card shadow-sm border-0 rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-success">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Camp Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Fees</th>
                    <th class="pe-4">Description</th>
                    <th class="pe-4">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($camp = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td class="ps-4"><?php echo $i++; ?></td>
                            <td class="fw-semibold"><?php echo $camp['camp_name']; ?></td>
                            <td><?php echo $camp['camp_date']; ?></td>
                            <td><?php echo $camp['location']; ?></td>
                            <td><?php echo $camp['fees'] > 0 ? '₹' . $camp['fees'] : 'Free'; ?></td>
                            <td class="pe-4 text-muted"><?php echo $camp['description']; ?></td>

                            <td class="pe-4 text-nowrap">
                                <a href="editcamp.php?id=<?php echo $camp['id']; ?>"
                                    class="btn btn-sm btn-outline-success">Edit</a>

                                <a href="camplist.php?delete=<?php echo $camp['id']; ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this camp?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No camps available.
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>