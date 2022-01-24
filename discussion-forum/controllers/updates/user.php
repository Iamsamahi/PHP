<?php
    require_once("../dbconfig.php");

    $username = $_POST["USERNAME"];
    // $password = $_POST["PASSWORD"];
    $userid   = $_POST["USERID"  ];
    $email    = $_POST["EMAIL"    ];
    $updateQueryString = "UPDATE `users`
                          SET
                            username='$username',
                            usermail='$email'
                          WHERE user_id = $userid";

    $message = "updatefailed";
    if (mysqli_query( $connection, $updateQueryString )) {
        $message = "updatesuccess";
    }

    header("Location: ../../view/profile.php?uname=$username");
?>
