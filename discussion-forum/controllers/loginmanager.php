<?php

    require_once('./dbconfig.php');

    $username = $_POST["USERNAME"];
    $password = $_POST["PASSWORD"];

    // TODO: implement a persistent user login system
    // $remember = $_POST["REMEMBER"];

    $login_query = "SELECT u.user_id FROM `users` u WHERE u.username = '$username'";

    $result = $connection->query( $login_query )
        or die("FAILED TO EXECUTE SQL QUERY ON THE DB.");

    if ( mysqli_num_rows( $result ) > 0 ) {
       $redirect_url = "../view/follows.php?uname=$username";
    }
    else {
        $redirect_url = "../view/login.php?msg=loginerror";
    }
    // redirect after login attempt
    header ("Location: $redirect_url");
?>
