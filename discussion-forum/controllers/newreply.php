<?php
  require_once("./dbconfig.php");

  $uname = $_POST['uname'];
  $comid = $_POST['comid'];
  $postid = $_POST['postid'];
  $commentID = $_POST['commentid'];
  $reply = $_POST['REPLY'];


  $sql = "INSERT INTO `replies` (comment_id, replier_id, reply_datetime, reply_content) 
            VALUES($commentID, (SELECT user_id FROM `users` WHERE username='$uname'), now(), '$reply');";
  mysqli_query( $connection, $sql ) or die("$sql");

  header("Location: ../view/post.php?postid=$postid&uname=$uname&comid=$comid");
?>
