<?php
    require_once("../controllers/dbconfig.php");

    $username = $_GET["uname"];
    $communityID = $_GET["comid"];

    $MY_STYLE_PATH = "../styles/saif/saif.css";
    $PAGE_TITLE = "Community Post" ;
    include_once("./templates/head.php");

    $communityPosts = " SELECT
                            p.post_id as postid,
                            (SELECT u.username FROM `users` u WHERE u.user_id = p.poster_id) as poster,
                            p.post_title as title,
                            DATE(p.datetime_posted) as posttime,
                            p.upvotes as uvotes,
                            p.downvotes as dvotes
                        FROM `posts` p
                        WHERE p.community_id = $communityID";

    $allPosts = mysqli_query( $connection, $communityPosts )
        or die("Failed to fetch post data.");
?>

<?php include_once("./templates/navbar.php") ?>


<div class="ui grid stackable container">
    <div class="row">
        <div class="eleven wide column">
            <h3 class="header row">Posts</h3>

            <table class="ui table small">
                <thead>
                    <th>Post Title</th>
                    <th>Posted by</th>
                    <th>Date Posted</th>
                    <th>Upvotes</th>
                    <th>Downvotes</th>
                </thead>

                <tbody>
                    <?php
                        if ( $allPosts ) {
                            while( $rows = mysqli_fetch_array( $allPosts ) ) {
                                echo"<tr>" ;
                                    echo "<td><a href=\"../view/post.php?postid=".$rows["postid"]."&uname=$username&comid=$communityID\">".$rows["title"]."</a></td>";
                                    echo "<td>".$rows["poster"]."</td>";
                                    echo "<td>".$rows["posttime"]."</td>";
                                    echo "<td>".$rows["uvotes"]."</td>";
                                    echo "<td>".$rows["dvotes"]."</td>";
                                echo"</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <?php include_once("./templates/sidebar.php") ?>

    </div>
</div>

<?php
    include_once("./templates/foot.php");
?>
