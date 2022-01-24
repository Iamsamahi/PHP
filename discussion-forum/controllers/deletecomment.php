<?php
    require_once("./dbconfig.php");
    $uname = $_GET['uname'];
    $comid = $_GET['comid'];
    $postid = $_GET['postid'];
    $commentid = $_GET['commentid'];

    $sql = "DELETE FROM comments WHERE comment_id = '$commentid'";

    $connection->query($sql)
    or die('Error! Unable to execute query!');

    header("Location: ../view/post.php?postid=$postid&uname=$uname&comid=$comid");
?>
