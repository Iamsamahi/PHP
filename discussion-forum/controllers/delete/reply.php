<?php

require_once("../dbconfig.php");

// postid=4&uname=admin&comid=3

$replyid = $_GET["replyid"];
$uname = $_GET['uname'];
$postid = $_GET['postid'];
$comid = $_GET['comid'];

$replyRemoveQuery = "DELETE FROM `replies` WHERE reply_id = $replyid";
mysqli_query( $connection, $replyRemoveQuery ) or die("Failed to execute query");

header("Location: ../../view/post.php?postid=$postid&uname=$uname&comid=$comid");

?>