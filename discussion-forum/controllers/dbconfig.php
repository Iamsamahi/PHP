<?php

    // db config info
    $db[ "SERVERNAME"] = "localhost";
    $db[ "DBNAME"    ] = "forum";
    $db[ "USERNAME"  ] = "root";
    $db[ "PASSWORD"  ] = "";

    // connection to db
    $connection = mysqli_connect( $db["SERVERNAME"], $db["USERNAME"], $db["PASSWORD"], $db["DBNAME"] )
        or die("FAILED TO CONNECT TO DATABASE. CHECK DATABASE & SERVER CONFIGURATIONS");
?>
