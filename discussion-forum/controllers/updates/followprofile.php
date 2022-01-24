<?php

    require_once("../dbconfig.php");

    $uname = $_GET["uname"];
    $communityID = $_GET["comid"];
    $followStatus = $_GET["stat"];


    $userID = mysqli_query( $connection, "SELECT user_id FROM `users`  WHERE username = '$uname'" ) or die("Failed to execute user query");

    $userid =  $userID->fetch_array()['user_id'];


    if ( $followStatus == "Follow" ) {
        $sql = "INSERT INTO `followed_communities` (`follower_id`, `community_id`) VALUES ('$userid', '$communityID');";
    }
    else {
        $sql = "DELETE FROM `followed_communities` WHERE `follower_id` = $userid AND `followed_communities`.`community_id` = $communityID";
    }

    mysqli_query( $connection, $sql ) or die("Failed to execute follow update");

    header("Location: ../../view/profile.php?uname=$uname");
?>