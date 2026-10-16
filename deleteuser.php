<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = "DELETE FROM registrations WHERE id = $id";
    mysqli_query($conn, $delete);
}

header("Location: userslist.php");
exit;
