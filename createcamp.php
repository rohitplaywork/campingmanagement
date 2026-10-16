<?php

$page_title = "Create Camp";
include 'config.php';
include 'header.php';

$campnameerror = "";
$campdateerror = "";
$locationerror = "";
$feeserror = "";
$descriptionerror = "";

if (isset($_POST['create_camp'])) {

    if (empty($_POST['camp_name'])) {
        $campnameerror = "Camp name field is required";
        $camp_name = '';
    } else {
        $camp_name = $_POST['camp_name'];
    }

    if (empty($_POST['camp_date'])) {
        $campdateerror = "Camp date field is required";
        $camp_date = '';
    } else {
        $camp_date = $_POST['camp_date'];
    }

    if (empty($_POST['location'])) {
        $locationerror = "Location field is required";
        $location = '';
    } else {
        $location = $_POST['location'];
    }

    if (empty($_POST['fees']) && $_POST['fees'] !== '0') {
        $feeserror = "Fees field is required";
        $fees = '';
    } else {
        $fees = $_POST['fees'];
    }

    if (empty($_POST['description'])) {
        $descriptionerror = "Description field is required";
        $description = '';
    } else {
        $description = $_POST['description'];
    }

    if (!empty($camp_name) && !empty($camp_date) && !empty($location) && $fees !== '' && !empty($description)) {

        if (!is_numeric($fees) || $fees < 0) {
            $feeserror = "Fees must be a valid number";
        } elseif (strtotime($camp_date) === false) {
            $campdateerror = "Invalid camp date";
        } else {

            $sql = "INSERT INTO camps (camp_name, camp_date, location, fees, description)
                    VALUES ('$camp_name', '$camp_date', '$location', '$fees', '$description')";

            if (mysqli_query($conn, $sql)) {
                header("Location: camplist.php");
                exit;
            }
        }
    }
}

?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <h4 class="mb-4">Create Camp</h4>
        <form action="createcamp.php" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="camp_name" class="form-label">Camp Name</label>
                    <input type="text" class="form-control" id="camp_name" name="camp_name"
                        placeholder="Enter camp name">
                    <div class="text-danger"><?php echo $campnameerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="camp_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="camp_date" name="camp_date">
                    <div class="text-danger"><?php echo $campdateerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location"
                        placeholder="Enter location">
                    <div class="text-danger"><?php echo $locationerror; ?></div>
                </div>

                <div class="col-md-6">
                    <label for="fees" class="form-label">Fees</label>
                    <input type="number" class="form-control" id="fees" name="fees"
                        placeholder="Enter fees" min="0">
                    <div class="text-danger"><?php echo $feeserror; ?></div>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3" placeholder="Enter description"></textarea>
                    <div class="text-danger"><?php echo $descriptionerror; ?></div>
                </div>

                <div class="col-12">
                    <button type="submit" name="create_camp" class="btn btn-success px-4">
                        Create Camp
                    </button>
                    <a href="camplist.php" class="btn btn-secondary px-4">Back</a>
                </div>
            </div>
        </form>

        <?php include 'footer.php'; ?>