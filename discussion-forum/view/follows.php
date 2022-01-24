<?php

    $PAGE_TITLE = "Followed Pages";
    $MY_STYLE_PATH = "../styles/saif/main.css";
    include_once("./templates/head.php");

    require_once("../controllers/dbconfig.php"); 

    $username = $_GET["uname"];


    $followedPostsQuery = " SELECT
	                            p.post_id as postid,
                                (SELECT u.username FROM `users` u WHERE u.user_id = p.poster_id) as poster,
                                p.post_title as title,
                                c.community_name as comname,
                                c.community_id as comid,
                                DATE(p.datetime_posted) as posttime,
                                p.upvotes as uvotes,
                                p.downvotes as dvotes
                            FROM `posts` p
                            INNER JOIN `communities` c ON (c.community_id = p.community_id)
                            WHERE p.community_id IN (SELECT f.community_id
                                                     FROM `followed_communities` f
                                                     WHERE f.follower_id = (SELECT u.user_id
                                                                            FROM `users` u
                                                                            WHERE u.username = '$username'));";

    $followedPosts = mysqli_query( $connection , $followedPostsQuery )
        or die("failed to retrieve posts");
?>


<?php  include_once("./templates/navbar.php"); ?>


<div class="ui grid stackable container">
    <div class="row">
        <!-- Post View -->
        <div class="eleven wide column">
            <h3 class="header row">Posts From Your Communities:</h3>

            <table class="ui table small">
                <thead>
                    <tr>
                        <th>Post Title</th>
                        <th>Posted By</th>
                        <th>Date Posted</th>
                        <th>Posted In</th>
                        <th>Upvotes</th>
                        <th>Downvotes</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        if ( $followedPosts ) {
                            while( $rows = mysqli_fetch_array( $followedPosts ) ) {
                                extract( $rows );
                                echo "<tr>" ;
                                    echo "<td>  <a href=\"../view/post.php?postid=$postid&uname=$username&comid=$comid\">$title</a></td>";
                                    echo "<td> $poster</td>" ;
                                    echo "<td> $posttime</td>" ;
                                    echo "<td> $comname</td>" ;
                                    echo "<td> $uvotes</td>" ;
                                    echo "<td> $dvotes</td>" ;
                                echo "</tr>" ;
                            }
                        }
                    ?>
                </tbody>
            </table>
            <button class = "ui orange button" onclick="location.href='./browse-communities.php?uname=<?php echo $username; ?>'">Browse All</button>
        </div>

        <!-- Followed Communities -->
        <div class="four wide right floated column">
            <h5 class="header">Your  Communities</h5>
            <table class="ui table">
                <?php
                    $followComsQuery = "SELECT c.community_name as comname, c.community_id as comid
                                        FROM `communities` c
                                        INNER JOIN `followed_communities` f ON (f.community_id = c.community_id)
                                        INNER JOIN `users` u ON (f.follower_id = u.user_id)
                                        WHERE u.username = '$username'";

                    $followedComs = mysqli_query( $connection, $followComsQuery ) or die("Failed to fetch follow data");

                    if ( $followedComs ) {
                        while ( $rows = $followedComs->fetch_array() ) {
                            echo "<tr><td><a href='./community.php?uname=$username&comid=".$rows["comid"]."'>".$rows["comname"]."</a></td></tr>";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>

<?php
    include_once("./templates/foot.php");
?>
