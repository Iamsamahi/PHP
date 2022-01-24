<div class="eleven wide column">
    <div class="ui header">Remove Followed Communities</div>
    <div class="ui row grid container">
        <?php
            $sql = "SELECT 
                        c.community_name  as comname, c.community_id as comid
                    FROM `communities` c 
                    INNER JOIN `followed_communities` f 
                        ON ( c.community_id = f.community_id ) 
                    WHERE f.follower_id = ( SELECT u.user_id 
                                            FROM `users` u 
                                            WHERE u.username = '$username')";
            $follows = mysqli_query( $connection, $sql ) or die("Failed to execute query");

            if ( mysqli_num_rows( $follows ) > 0 ) {
                while ($rows = $follows->fetch_array()) {
                    echo "<button class=\"ui button\" onclick='location.href=\"../controllers/updates/followprofile.php?uname=$username&comid=$rows[comid]&stat=Unfollow\"'> $rows[comname] </button>";
                }
            }
        ?>
    </div>
</div>