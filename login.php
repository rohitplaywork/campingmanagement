<?php
session_start();
include 'config.php';

$emailerror = '';
$emailvalidat = '';
$passworderror = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['email'])) {
        $emailerror = "Email field is required";
        $email = '';
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['password'])) {
        $passworderror = "Password field is required";
        $pass = '';
    } else {
        $pass = $_POST['password'];
    }

    if (!empty($email) && !empty($pass)) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailvalidat = "Invalid email format";
        } else {

            $pass = md5($pass);

            $sql = "SELECT * FROM student_registration
                    WHERE email = '$email' AND password = '$pass'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $student = mysqli_fetch_assoc($result);

                $_SESSION['student_id'] = $student['id'];
                $_SESSION['student_email'] = $student['email'];
                $_SESSION['student_name'] = $student['name'];

                header("Location: student-dashboard.php");
                exit;
            } else {
                $error = "Invalid Email or Password";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - CampCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">

        <div class="card shadow border-0 rounded-4 w-100" style="max-width: 600px;">
            <div class="card-body p-4 p-md-5">

                <h4 class="text-center mb-2">Student Login</h4>

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

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input type="text" class="form-control" id="email"
                            name="email" placeholder="Enter your email">

                        <div class="text-danger">
                            <?php
                            echo !empty($emailerror) ? $emailerror : $emailvalidat;
                            ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input type="password" class="form-control" id="password"
                            name="password" placeholder="Enter your password">

                        <div class="text-danger">
                            <?php echo $passworderror; ?>
                        </div>

                        <div class="text-danger">
                            <?php echo $error; ?>
                        </div>
                    </div>

                    <button type="submit" name="login"
                        class="btn btn-success w-100 py-2">
                        Login
                    </button>

                    <p class="text-center mt-4 mb-0">
                        Don't have an account?
                        <a href="registration.php"
                            class="text-success text-decoration-none fw-semibold">
                            Register Here
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>