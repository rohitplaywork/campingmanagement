<?php
include 'config.php';

$nameerror = "";
$emailerror = "";
$phoneerror = "";
$gendererror = "";
$passworderror = "";
$cpassworderror = "";
$metchpasserror = "";

if (isset($_POST['register'])) {

if (empty($_POST['name'])) {
    $nameerror = "Name field is required";
    $name = '';
} else {
    $name = $_POST['name'];
}

if (empty($_POST['email'])) {
    $emailerror = "Email field is required";
    $email = '';
} else {
    $email = $_POST['email'];
}

if (empty($_POST['phone'])) {
    $phoneerror = "Phone field is required";
    $phone = '';
} else {
    $phone = $_POST['phone'];
}

if (empty($_POST['gender'])) {
    $gendererror = "Gender field is required";
    $gender = '';
} else {
    $gender = $_POST['gender'];
}

if (empty($_POST['password'])) {
    $passworderror = "Password field is required";
    $password = '';
} else {
    $password = $_POST['password'];
}

if (empty($_POST['confirm_password'])) {
    $cpassworderror = "Confirm password field is required";
    $confirmPassword = '';
} else {
    $confirmPassword = $_POST['confirm_password'];
}

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
} else {
    $emailerror = "Invalid email address";
}

    if ($password === $confirmPassword) {

        if (!empty($name) && !empty($email) && !empty($phone) && !empty($gender)) {

    if (empty($emailerror)) {

        $checkemail = "SELECT id FROM student_registration WHERE email = '$email'";
        $emailresult = mysqli_query($conn, $checkemail);

            if (mysqli_num_rows($emailresult) > 0) {
                $emailerror = "Email already registered. Please use another email.";
            } else {

            $password = md5($password);

                    $insertdata = "INSERT INTO student_registration (name, email, phone, gender, password)
                    VALUES ('$name', '$email', '$phone', '$gender', '$password')";

                    if (mysqli_query($conn, $insertdata)) {
                        header("Location: login.php");
                        exit;
                    }
                }
            }
        }
    } else {
        $metchpasserror = "Not metch";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - CampCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">

        <div class="card shadow border-0 rounded-4 w-100" style="max-width: 600px;">
            <div class="card-body p-4 p-md-5">

                <h4 class="text-center mb-2">Create Account</h4>
                <p class="text-muted text-center mb-4">
                    Register to explore and book camps.
                </p>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your full name">
                        <div class="text-danger"><?php echo $nameerror; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email">
                        <div class="text-danger">
                            <?php echo $emailerror; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            placeholder="Enter your phone number">
                        <div class="text-danger"><?php echo $phoneerror; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="text-danger"><?php echo $gendererror; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Create password">
                        <div class="text-danger"><?php echo $passworderror; ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password"
                            name="confirm_password" placeholder="Confirm password">
                        <div class="text-danger">
                            <?php
                            echo !empty($cpassworderror) ? $cpassworderror : $metchpasserror;
                            ?>
                        </div>
                    </div>

                    <input type="submit" name="register" class="btn btn-success w-100 py-2" value="Register Now">

                    <p class="text-center mt-4 mb-0">
                        Already have an account?
                        <a href="studentlogin.php"
                            class="text-success text-decoration-none fw-semibold">
                            Login Here
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>