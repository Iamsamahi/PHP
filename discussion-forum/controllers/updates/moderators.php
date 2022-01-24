<?php

require_once("../dbconfig.php");

$changeType = $_GET["type"];
$username = $_GET["uname"];
$userid = $_GET["userid"];
$communityID = $_GET["comid"];

$modAddQuery = "INSERT INTO `moderators` VALUES ($userid, $communityID)";
$modRemQuery = "DELETE FROM `moderators` WHERE moderator_id = $userid AND moderated_community = $communityID";

if ( $changeType == "add" ) {
    mysqli_query( $connection, $modAddQuery );
}
else {
    mysqli_query( $connection, $modRemQuery );
}

header("Location: ../../view/forms/moderator.php?uname=$username&comid=$communityID");

?>