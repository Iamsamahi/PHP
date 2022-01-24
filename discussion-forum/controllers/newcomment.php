<?php
  require_once("./dbconfig.php");

  $uname = $_POST['uname'];
  $postid = $_POST['postid'];
  $comment = $_POST['comment'];
  $comid = $_POST['comid'];
  

  $sql = "INSERT INTO `comments` (commenter_id, post_id, comment_datetime, comment_content, upvotes, downvotes) VALUES((SELECT user_id FROM `users` WHERE username='$uname'), $postid, now(), '$comment', 0, 0);";
  mysqli_query( $connection, $sql ) or die("$sql");

  header("Location: ../view/post.php?postid=$postid&uname=$uname&comid=$comid");
?>