<?php

    require_once("./dbconfig.php");

    $username= $_GET["uname"];
    $comid = $_GET["comid"];

    $sql = "DELETE FROM `communities` WHERE `community_id` = $comid";
    $connection->query($sql) or die($sql);

    header("Location: ../view/browse-communities.php?uname=$username");

?>