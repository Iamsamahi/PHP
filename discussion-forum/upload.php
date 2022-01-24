<?php
    require_once("./controllers/dbconfig.php");

    if (isset($_FILES['img'])) {
        $filename = $_FILES['img']['name'];

        $sql = "INSERT INTO (`image_id`, `post_id`, `image_description`, `image`)
                VALUES      (NULL, '16', 'hello','"  . file_get_contents( $_FILES['img']['tmp_name'] ). "')";

        mysqli_query( $connection, $sql ) or die("Failed");
    }
    else {
        printf("Something is wrong");
    }
?>
