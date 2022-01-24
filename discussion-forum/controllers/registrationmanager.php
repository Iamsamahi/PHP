<?php

    require_once("./dbconfig.php");

    $username = $_POST["USERNAME"];
    $password = $_POST["PASSWORD"];
    $email    = $_POST["MAIL"    ];
    $dob      = $_POST["DOB"     ];

    $userCheckQuery = "SELECT u.user_id FROM `users` u WHERE u.username = '$username'";
    $emailCheckQuery = "SELECT u.usermail FROM `users` u WHERE u.usermail = '$email'";

    $user = mysqli_query( $connection, $userCheckQuery )
        or die("Could not execute query");

    $mail = mysqli_query( $connection, $emailCheckQuery )
        or die("Failed to execute query");

    if( mysqli_num_rows( $user ) > 0 ) {
        $redirect_url = "../view/register.php?msg=unameerror";
    }
    else if( mysqli_num_rows( $mail ) > 0 ) {
        $redirect_url = "../view/register.php?msg=mailerror";
    }
    else {
        $redirect_url = "../view/login.php?msg=regsuccess";

        $userInsertQuery = "INSERT INTO `users`  VALUES (NULL, '$username', '$email', '$dob', CURDATE());";
        mysqli_query( $connection, $userInsertQuery ) or die("Insertion Failed");
    }

    header ("Location: $redirect_url");
?>
