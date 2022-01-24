<?php
    require_once("../dbconfig.php");

    $username = $_POST["USERNAME"];

    printf("$username");

    $deleteQuery = "DELETE FROM `users` WHERE username = '$username'";

    //mysqli_query( $connection, $deleteQuery ) or die("Failed to delete user from table");

    //header("Location: ../../view/login.php?msg=userdelete");

?>
