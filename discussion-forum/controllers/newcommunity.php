<?php
  require_once("./dbconfig.php");

  $name = $_POST['NAME'];
  $description = $_POST['description'];
  $uname = $_POST['uname'];

  $sql = "INSERT INTO communities(`community_name`, `description`)
                  VALUES('$name', '$description')";

  $connection->query($sql)
    or die($sql);

    $addFirstMod = "INSERT INTO `moderators` VALUES (
        (SELECT user_id FROM `users` WHERE username='$uname'),
        (SELECT community_id FROM `communities` WHERE community_name='$name')
    )";

    $connection->query($addFirstMod) or die("Failed to insert first moderator");

    header("Location: ../view/browse-communities.php?uname=$uname");
?>
