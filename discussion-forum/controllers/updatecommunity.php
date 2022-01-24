<?php
    require_once("./dbconfig.php");

    $description = $_POST['DESCRIPTION'];
    $title = $_POST['NAME'];
    $uname = $_POST['uname'];
    $comid = $_POST['comid'];


    $sql = "UPDATE `communities` SET `community_name`='$title', `description`='$description' WHERE community_id=$comid";

    $connection->query($sql)
      or die("$sql");

    header("Location: ../view/community.php?uname=$uname&comid=$comid");
?>