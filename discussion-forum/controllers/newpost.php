<?php
    require_once("./dbconfig.php");
    $title = $_POST['title'];
    $content = $_POST['content'];
    $uname = $_POST['uname'];
    $comid = $_POST['comid'];


    $sql = "INSERT INTO posts(poster_id, community_id, post_title, post_content, datetime_posted, upvotes, downvotes)
            VALUES((SELECT user_id
            FROM users
            WHERE username='$uname'), $comid, '$title', '$content', now(), 0, 0)";


    $connection->query($sql)
    or die('Error! Unable to execute query!');

    header("Location: ../view/community.php?uname=$uname&comid=$comid");
?>
