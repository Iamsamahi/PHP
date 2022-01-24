<?php
    require_once("../../controllers/dbconfig.php");

    $username = $_GET["uname"];
    $communityID = $_GET["comid"];

    $MY_STYLE_PATH = "../styles/saif/saif.css";
    $PAGE_TITLE = "Community Post";
    include_once("../templates/head.php");
?>

<div class="ui borderless top inverted secondary menu menu" style="background-color: black;">
    <div class="ui container">
        <a class='item' href="../follows.php?uname=<?php echo $username; ?>">
            <i class="home icon"></i>
            Home
        </a>

        <a class='item' href="../follows.php?uname=<?php echo $username; ?>">
            <i class="tasks icon"></i>
            Follows
        </a>

        <a class='item' href="../browse-communities.php?uname=<?php echo $username; ?>">
            <i class="rss icon"></i>
            Browse All
        </a>
        <a class='item'>
            <i class="info circle icon"></i>
            About
        </a>
        <a class="right item" href="../profile.php?uname=<?php echo $username; ?>">
            <i class="user icon"></i>
            Profile
        </a>
    </div>
</div>
<br>

<!-- QUERY AND GET ALL USER NAMES AND THEN ADD THEM BY CHECK BOXES -->
<div class="ui grid stackable container">
    <div class="row">

        <div class="eleven wide column">
            <div class="ui header">Add Moderators</div>
            <div class="ui row grid container">
                <?php 
                    $nonModsQuery = "SELECT
                                        u.username as uname, u.user_id as userid
                                    FROM `users` u
                                    WHERE u.user_id NOT IN (SELECT m.moderator_id FROM `moderators` m WHERE m.moderated_community = $communityID)";
                    $nonMods = mysqli_query( $connection, $nonModsQuery ) or die("failed to load non moderators");

                    if ( mysqli_num_rows( $nonMods ) > 0 ) {
                        while ($rows = $nonMods->fetch_array()) {
                            echo "<button class=\"ui button\" onclick='location.href=\"../../controllers/updates/moderators.php?userid=$rows[userid]&uname=$username&comid=$communityID&type=add\"'> $rows[uname] </button>";
                        }
                    }
                    else {
                        printf("No Available users for new moderators.");
                    }
                ?>
            </div>

                <div class="ui row header">Remove Moderators</div>

                <div class="ui row grid container">
                    <?php 
                        $nonModsQuery = "SELECT
                                            u.username as uname, u.user_id as userid
                                        FROM `users` u
                                        WHERE u.user_id IN (SELECT m.moderator_id FROM `moderators` m WHERE m.moderated_community = $communityID)";
                        $nonMods = mysqli_query( $connection, $nonModsQuery ) or die("failed to load non moderators");

                        if ( mysqli_num_rows( $nonMods ) > 0 ) {
                            while ($rows = $nonMods->fetch_array()) {
                                echo "<button class=\"ui button\" onclick='location.href=\"../../controllers/updates/moderators.php?userid=$rows[userid]&uname=$username&comid=$communityID&type=delete\"'> $rows[uname] </button>";
                            }
                        }
                        else {
                            printf("No Available Moderators.");
                        }
                    ?>
                </div>
            </div>

            <div class="four wide column">
                <?php
                    $comNameQuery = "SELECT c.community_name AS comname, c.description as comdesc
                                    FROM `communities` c
                                    WHERE c.community_id = $communityID";

                    $communityName = mysqli_query($connection, $comNameQuery)
                    or die("Failed to fetch community data.");

                    $currentUserisFollowerQuery = " SELECT
                                                    (SELECT u.user_id FROM `users` u WHERE u.username='$username')
                                                    IN
                                                    (SELECT f.follower_id FROM `followed_communities` f WHERE f.community_id = $communityID) AS follow";
                    $following =  mysqli_query($connection, $currentUserisFollowerQuery) or die("Failed to fetch info");

                    if ($following->fetch_row()[0] == 0) {
                    $followButtonTag = "bell outline";
                    $followStatus = "Follow";
                    } else {
                    $followButtonTag = "bell slash outline";
                    $followStatus = "Unfollow";
                    }


                    extract($communityName->fetch_array());

                    echo "<h3 class=\"header row\">$comname</h3>";
                    echo "<div class=\"ui raised segment row\"><a class=\"ui orange tiny ribbon label\">About this Community</a> <br> <p>$comdesc</p> <a class=\"ui orange label\"><i class=\"$followButtonTag icon\"></i>$followStatus</a></div>";
                ?>

            <div class="ui fluid button orange row" onclick="location.href='./forms/post.php?uname=<?php echo $username; ?>&comid=<?php echo $communityID; ?>'"><i class="edit icon"></i> Create New Post</div>

            <br>
            <div class="ui segments raised row">
                <div class="ui inverted segment header">Followers</div>

                <div class="ui segment attached divided list fluid">
                    <?php
                    $followerQuery = "  SELECT (SELECT u.username FROM `users` u WHERE u.user_id = f.follower_id) as follower
                                            FROM `followed_communities` f
                                            WHERE f.community_id = $communityID";

                    $followers = mysqli_query($connection, $followerQuery)
                        or die("failed to fetch followers list");

                    if (mysqli_num_rows($followers) > 0) {
                        while ($rows = $followers->fetch_array()) {
                            echo "<div class=\"item\"> <div class=\"content\"><div class=\"header\">" . $rows["follower"] . "</div> </div> </div>";
                        }
                    } else {
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
                    $moderators = mysqli_query($connection, $moderatorQuery)
                        or die("failed to fetch moderator list");

                    $currentUserIsMod = false;

                    if (mysqli_num_rows($moderators) > 0) {
                        while ($rows = $moderators->fetch_array()) {
                            if ($rows["moderator"] == $username) $currentUserIsMod = true;
                            echo "<div class=\"item\"> <div class=\"content\"><div class=\"header\">" . $rows["moderator"] . "</div> </div> </div>";
                        }
                    } else {
                        echo "There are no moderators in this community";
                    }
                    ?>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
