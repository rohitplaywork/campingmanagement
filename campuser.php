<?php
$page_title = "Camp Registration";

include 'config.php';
include 'header.php';

$campiderror = "";
$nameerror = "";
$mobileerror = "";
$emailerror = "";
$ageerror = "";
$addresserror = "";

$allcamps = "SELECT id, camp_name, camp_date FROM camps ORDER BY camp_date DESC";
$camps = mysqli_query($conn, $allcamps);

if (isset($_POST['register_camp'])) {

    if (empty($_POST['camp_id'])) {
        $campiderror = "Please select a camp";
        $camp_id = '';
    } else {
        $camp_id = $_POST['camp_id'];
    }

    if (empty($_POST['name'])) {
        $nameerror = "Name field is required";
        $name = '';
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['mobile'])) {
        $mobileerror = "Mobile number field is required";
        $mobile = '';
    } else {
        $mobile = $_POST['mobile'];
    }

    if (empty($_POST['email'])) {
        $emailerror = "Email field is required";
        $email = '';
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['age'])) {
        $ageerror = "Age field is required";
        $age = '';
    } else {
        $age = $_POST['age'];
    }

    if (empty($_POST['address'])) {
        $addresserror = "Address field is required";
        $address = '';
    } else {
        $address = $_POST['address'];
    }

    if (!empty($mobile) && !preg_match('/^[0-9]{10}$/', $mobile)) {
        $mobileerror = "Mobile number must be exactly 10 digits.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror = "Invalid email address";
    }

    if (!empty($age) && (!is_numeric($age) || $age < 1 || $age > 120)) {
        $ageerror = "Age must be between 1 and 120";
    }

    if ($campiderror == "" && $nameerror == "" && $mobileerror == "" && $emailerror == "" && $ageerror == "" && $addresserror == "") {
        $checkemail = "SELECT id FROM registrations WHERE email = '$email'";
        $emailresult = mysqli_query($conn, $checkemail);

        if (mysqli_num_rows($emailresult) > 0) {
            $emailerror = "Email already registered. Please use another email.";
        } else {
            $insertdata = "INSERT INTO registrations
                (camp_id, name, mobile, email, age, address)
                VALUES ('$camp_id', '$name', '$mobile', '$email', '$age', '$address')";

            if (mysqli_query($conn, $insertdata)) {
                header("Location: userslist.php");
                exit;
            }
        }
    }
}
?>
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        <h4 class="mb-4">Camp Registration</h4>

        <form action="" method="POST">
            <div class="row g-3">

                <div class="col-12">
                    <label for="camp_id" class="form-label">Select Camp</label>
                    <select class="form-select" id="camp_id" name="camp_id">
                        <option value="">Choose a camp</option>

                        <?php while ($camp = mysqli_fetch_assoc($camps)) { ?>
                            <option value="<?php echo $camp['id']; ?>"
                                <?php if (isset($camp_id) && $camp_id == $camp['id']) echo 'selected'; ?>>
                                <?php echo $camp['camp_name']; ?>
                                (<?php echo date('d M Y', strtotime($camp['camp_date'])); ?>)
                            </option>
                        <?php } ?>
                    </select>
                    <div class="text-danger"><?php echo $campiderror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name"
                        name="name" placeholder="Enter full name"
                        value="<?php echo htmlspecialchars($name ?? ''); ?>">
                    <div class="text-danger"><?php echo $nameerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="mobile" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile"
                        name="mobile" placeholder="Enter 10 digit mobile number"
                        maxlength="10"
                        value="<?php echo htmlspecialchars($mobile ?? ''); ?>">
                    <div class="text-danger"><?php echo $mobileerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email"
                        name="email" placeholder="Enter email"
                        value="<?php echo htmlspecialchars($email ?? ''); ?>">
                    <div class="text-danger"><?php echo $emailerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age"
                        name="age" placeholder="Enter age" min="1" max="120"
                        value="<?php echo htmlspecialchars($age ?? ''); ?>">
                    <div class="text-danger"><?php echo $ageerror; ?></div>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address"
                        rows="3" placeholder="Enter address"><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                    <div class="text-danger"><?php echo $addresserror; ?></div>
                </div>

                <div class="col-12">
                    <button type="submit" name="register_camp"
                        class="btn btn-success px-4">Register</button>
                    <a href="userslist.php" class="btn btn-secondary px-4">Back</a>
                </div>


            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>