<?php
$page_title = "Camprer List";
include 'config.php';
include 'header.php';

$users = "SELECT * FROM registrations ORDER BY id DESC";
$result = mysqli_query($conn, $users);
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="mb-1">User List</h4>
        <p class="text-muted mb-0">All registered users</p>
    </div>
    <a href="campuser.php" class="btn btn-success px-4">+ Add User</a>
</div>

<?php if (mysqli_num_rows($result) > 0) { ?>
    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Full Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th class="pe-4">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    while ($user = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td class="ps-4"><?php echo $i++; ?></td>
                            <td class="fw-semibold"><?php echo $user['name']; ?></td>
                            <td><?php echo $user['mobile']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['age']; ?></td>
                            <td class="text-muted"><?php echo $user['address']; ?></td>
                            <td class="pe-4">
                                <a href="edituser.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="deleteuser.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No users available.
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>