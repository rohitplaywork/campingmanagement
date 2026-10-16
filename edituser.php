<?php
$page_title = "Edit User";

include 'config.php';

$error = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM registrations WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    $campsql = "SELECT id, camp_name, camp_date FROM camps ORDER BY camp_date DESC";
    $campresult = mysqli_query($conn, $campsql);

    if (isset($_POST['update_user'])) {
        $camp_id = ($_POST['camp_id']);
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $address = $_POST['address'];

        if ($name != "" && $mobile != "" && $email != "" && $age != "" && $address != "") {

            if (!preg_match('/^[0-9]{10}$/', $mobile)) {
                $error = "Mobile number must be exactly 10 digits.";
            } else {
                $update = "UPDATE registrations SET  camp_id = $camp_id, name = '$name', mobile = '$mobile',
                email = '$email', age = '$age', address = '$address' WHERE id = $id";
                if (mysqli_query($conn, $update)) {
                    header("Location: userslist.php");
                    exit;
                } else {
                    $error = "updating user:" . mysqli_error($conn);
                }
            }
        } else {
            $error = "Please Fill All Fields";
        }
    }
}



include 'header.php';

?>




<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        <h4 class="mb-4">Edit User</h4>

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

                <div class="col-12">
                    <label for="camp_id" class="form-label">Select Camp</label>

                    <select class="form-select" id="camp_id" name="camp_id" required>
                        <option value="">Choose a camp</option>

                        <?php
                        $selected_camp = $_POST['camp_id'] ?? $user['camp_id'];

                        while ($camp = mysqli_fetch_assoc($campresult)) {
                        ?>
                            <option value="<?php echo $camp['id']; ?>"
                                <?php if ($selected_camp == $camp['id']) {
                                    echo 'selected';
                                } ?>>

                                <?php echo $camp['camp_name']; ?>
                                (<?php echo date('d M Y', strtotime($camp['camp_date'])); ?>)

                            </option>
                        <?php } ?>

                    </select>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name"
                        name="name" placeholder="Enter full name" value="<?php echo $_POST['name'] ?? $user['name']; ?>">
                </div>

                <div class="col-md-6">
                    <label for="mobile" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile"
                        name="mobile" placeholder="Enter 10 digit mobile number"
                        maxlength="10" value="<?php echo $_POST['mobile'] ?? $user['mobile']; ?>">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email"
                        name="email" placeholder="Enter email" value="<?php echo $_POST['email'] ?? $user['email']; ?>">
                </div>

                <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age"
                        name="age" placeholder="Enter age" min="1" max="120" value="<?php echo $_POST['age'] ?? $user['age']; ?>">
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address"
                        rows="3" placeholder="Enter address"><?php echo $_POST['address'] ?? $user['address']; ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" name="update_user"
                        class="btn btn-success px-4">Update</button>
                    <a href="userslist.php" class="btn btn-secondary px-4">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>