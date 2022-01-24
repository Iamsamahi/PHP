<?php
    require_once("./dbconfig.php");

    $uname = $_POST['uname'];
    $comid = $_POST['comid'];
    $postid = $_POST['postid'];
    $replyid = $_POST['replyid'];
    $reply = $_POST['REPLY'];

    $sql = "UPDATE `replies` SET `reply_content`='$reply' WHERE `reply_id`=$replyid";

    $connection->query($sql)
      or die("$sql");

    header("Location: ../view/post.php?uname=$uname&comid=$comid&postid=$postid");
?>
