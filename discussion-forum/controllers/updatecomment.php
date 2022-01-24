<?php
    require_once("./dbconfig.php");
    $content = $_POST['content'];
    $postid = $_POST['postid'];
    $commentid = $_POST['commentid'];
    $uname = $_POST['uname'];
    $comid = $_POST['comid'];


    $sql = "UPDATE comments SET comment_content = '$content' WHERE comment_id = $commentid";


    $connection->query($sql)
      or die('Error! Unable to execute query!');

    header("Location: ../view/post.php?postid=$postid&uname=$uname&comid=$comid");
?>