<!-- Side Bar -->
<div class="four wide column">
    <?php
        $comNameQuery = "SELECT c.community_name AS comname, c.description as comdesc
                         FROM `communities` c
                         WHERE c.community_id = $communityID";

        $communityName = mysqli_query( $connection, $comNameQuery )
            or die("Failed to fetch community data.");

        $currentUserisFollowerQuery = " SELECT
                                            (SELECT u.user_id FROM `users` u WHERE u.username='$username')
                                                IN
                                            (SELECT f.follower_id FROM `followed_communities` f WHERE f.community_id = $communityID) AS follow";
        $following =  mysqli_query( $connection, $currentUserisFollowerQuery ) or die("Failed to fetch info");

        if ( $following->fetch_row()[0] == 0 ) {
            $followButtonTag = "bell outline";
            $followStatus = "Follow";
        }
        else{
            $followButtonTag = "bell slash outline";
            $followStatus = "Unfollow";
        }

        extract( $communityName->fetch_array() );

        echo "<h3 class=\"header row\">$comname</h3>";
        echo "<div class=\"ui raised segment row\">
                <a class=\"ui orange tiny ribbon label\" '>About this Community</a> 
                <br>
                <p>$comdesc</p>
                <a class=\"ui orange label\" href=\"../controllers/updates/follower.php?uname=$username&comid=$communityID&stat=$followStatus\"><i class=\"$followButtonTag icon\"></i>$followStatus</a>
            </div>";
    ?>

    <div class="ui fluid button orange row" onclick="location.href='./forms/post.php?uname=<?php echo $username; ?>&comid=<?php echo $communityID; ?>'"><i class="edit icon"></i> Create New Post</div>

    <br>
    <div class="ui segments raised row">
        <div class="ui inverted segment header">Followers</div>

        <div class="ui segment attached divided list fluid">
            <?php 

                $followerQuery = "  SELECT (SELECT u.username
                                            FROM `users` u
                                            WHERE u.user_id = f.follower_id) as follower
                                    FROM `followed_communities` f
                                    WHERE f.community_id = $communityID";

                $followers = mysqli_query( $connection, $followerQuery )
                    or die("failed to fetch moderator list");

                if ( mysqli_num_rows( $followers ) > 0 ) {
                    while ( $rows = $followers->fetch_array() ) {
                        echo "<div class=\"item\">
                                <div class=\"content\">
                                        <div class=\"header\">".$rows["follower"]."</div>
                                </div>
                                </div>";
                    }
                }
                else {
                    echo "There are no Followers in this community";
                }
            ?>
        </div>
        <br>
    </div>

    <div class="ui segments raised row">
        <div class="ui inverted segment header">Moderators</div>

        <div class="ui segment attached divided list fluid">
            <?php 
                $moderatorQuery = "SELECT (SELECT u.username FROM `users` u WHERE u.user_id = m.moderator_id) as moderator
                                    FROM `moderators` m
                                    WHERE m.moderated_community = $communityID";
                $moderators = mysqli_query( $connection, $moderatorQuery )
                    or die("failed to fetch moderator list");

                $currentUserIsMod = false;

                if ( mysqli_num_rows( $moderators ) > 0 ) {
                    while ( $rows = $moderators->fetch_array() ) {
                        if ( $rows["moderator"] == $username ) $currentUserIsMod = true;
                        echo "<div class=\"item\">
                                <div class=\"content\">
                                    <div class=\"header\">".$rows["moderator"]."</div>
                                </div>
                                </div>";
                    }
                }
                else {
                    echo "There are no moderators in this community";
                }
            ?>
        </div>
        <br>
    </div>
    <?php
    
        if ( $currentUserIsMod ) {
            echo "<button class=\"ui button row fluid orange\" onclick=\"location.href='./forms/moderator.php?uname=$username&comid=$communityID'\">
                    <i class=\"plus square outline icon\"></i>
                    Add a new moderator
                </button>";
            echo "<br>";
            echo "<button class=\"ui button row fluid orange\" onclick=\"location.href='./forms/managecommunity.php?uname=$username&comid=$communityID'\">
                    <i class=\"wrench icon\"></i>
                    Change Community Settings
                </button>";
        }
    ?>
</div>