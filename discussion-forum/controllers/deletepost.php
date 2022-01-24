<?php
    require_once("./dbconfig.php");
    $uname = $_GET['uname'];
    $comid = $_GET['comid'];
    $postid = $_GET['postid'];

    $sql = "DELETE FROM posts WHERE post_id = '$postid'";

    $connection->query($sql)
        or die('Error! Unable to execute query!');

    header("Location: ../view/community.php?uname=$uname&comid=$comid");
?>
