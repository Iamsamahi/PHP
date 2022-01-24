<?php
    require_once("../../controllers/dbconfig.php");

    $username = $_GET["uname"];
    $communityID = $_GET["comid"];

    $PAGE_TITLE = "Community Post" ;
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

<div class="ui grid stackable container">
    <div class="row">
        <div class="eleven wide column">
            <div class="ui row">
                <h3 class="ui header center aligned">
                    Manage Community Details
                </h3>
            </div>

            <div class="ui section divider"></div>

            <div class="ui row">
                <div class="column">
                    <form class="ui form" method="POST" action="../../controllers/updatecommunity.php">
                        <div class="field">
                            <label>Community Name</label>
                            <input type="text" name="NAME" placeholder="Name">
                        </div>

                        <div class="field">
                            <label>Community Description</label>
                            <textarea type="text" name="DESCRIPTION" placeholder="Description"></textarea>
                        </div>
                        <?php
                            $uname = $_GET['uname'];
                            $comid = $_GET['comid'];
                            echo "<input type='text' name='uname' value=$uname hidden>";
                            echo "<input type='text' name='comid' value=$comid hidden>";
                        ?>

                        <button class="ui button right floated large orange" type="submit">Update</button>
                    </form>
                    <button class="ui button left floated large" onclick="location.href='../community.php?uname=<?php echo $username; ?>&comid=<?php echo $communityID; ?>'">Go Back</button>
                    <?php
                        echo "<a href='../../controllers/deletecommunity.php?uname=$uname&comid=$comid'><button class='ui button red large right floated'>Delete</button></a>"
                    ?>
                </div>
            </div>
        </div>


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
                echo "<div class=\"ui raised segment row\"><a class=\"ui orange tiny ribbon label\">About this Community</a> <br> <p>$comdesc</p> <a class=\"ui orange label\"><i class=\"$followButtonTag icon\"></i>$followStatus</a></div>";
            ?>

            <div class="ui fluid button orange row"><i class="edit icon"></i> Create New Post</div>

            <br>
            <div class="ui segments raised row">
                <div class="ui inverted segment header">Followers</div>

                <div class="ui segment attached divided list fluid">
                    <?php 

                        $followerQuery = "  SELECT (SELECT u.username FROM `users` u WHERE u.user_id = f.follower_id) as follower
                                            FROM `followed_communities` f
                                            WHERE f.community_id = $communityID";

                        $followers = mysqli_query( $connection, $followerQuery )
                            or die("failed to fetch moderator list");

                        if ( mysqli_num_rows( $followers ) > 0 ) {
                            while ( $rows = $followers->fetch_array() ) {
                                echo "<div class=\"item\"> <div class=\"content\"><div class=\"header\">".$rows["follower"]."</div> </div> </div>";
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
                                echo "<div class=\"item\"> <div class=\"content\"><div class=\"header\">".$rows["moderator"]."</div> </div> </div>";
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
                    echo "<button class=\"ui button row fluid orange\"><i class=\"plus square outline icon\"></i>Add a new moderator</button>";
                }
            ?>
        </div>  
    </div>
</div>