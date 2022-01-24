<?php
  require_once("./dbconfig.php");
  $title = $_POST['title'];
  $content = $_POST['content'];
  $postid = $_POST['postid'];
  $uname = $_POST['uname'];
  $comid = $_POST['comid'];


  $sql = "UPDATE posts SET post_title = '$title', post_content = '$content' WHERE post_id = $postid";
  
  
  $connection->query($sql)
  or die('Error! Unable to execute query!');

  header("Location: ../view/community.php?uname=$uname&comid=$comid");
  exit;
?>