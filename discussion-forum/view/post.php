<?php
    $MY_STYLE_PATH = "./styles/saif.css";
    $postid = $_GET["postid"];
    $username = $_GET["uname"];
    $communityID = $_GET["comid"];

    $PAGE_TITLE = "Post View";
    include_once("./templates/head.php");
    include_once("./templates/logger.php");
    require_once("../controllers/dbconfig.php");
?>

<?php include_once("./templates/navbar.php") ?>

<?php
    $postdetailQuery = "SELECT
                            p.post_title as title, p.post_content as content,
                            DATE(p.datetime_posted) as posttime, p.upvotes as uvotes, p.downvotes as dvotes,
                            u.username as poster
                        FROM `posts` p
                        INNER JOIN `users` u ON (u.user_id = p.poster_id)
                        WHERE p.post_id = $postid";

    $imageQuery = " SELECT
                        i.image_description as img_desc, i.image as img
                    FROM `images` i
                    WHERE i.post_id = $postid";

    $postDetails = mysqli_query($connection, $postdetailQuery)
        or die("Failed to get post details :(");
    $images = mysqli_query($connection, $imageQuery)
        or die("Failed to get images");

    $postDetailsResult = $postDetails->fetch_array();

    if (!$postDetailsResult) {
        showUIMessage("Failed to read data from server", "The post may have been removed.", "negative");
    }
?>


<div class="ui grid stackable container">
    <div class="row">
        <!-- MAIN CONTENT -->
        <div class="eleven wide column">
            <div class="ui raised fluid card">
                <div class="content center">
                    <br>
                    <?php 
                        if ( $username == $postDetailsResult["poster"] ) {
                            echo "<a href=./forms/edit_post.php?postid=$postid&uname=$username&comid=$communityID><button class='ui button right floated'>Edit</button></a>";
                        }
                    ?>
                    <!-- HEADER -->
                    <h3 class="header"><?php echo $postDetailsResult["title"] ?></h3>
                    <!-- DATE -->
                    <div class="meta">
                        <span class="category">Posted on <?php echo $postDetailsResult["posttime"] ?></span>
                    </div>

                    <!-- CONTENT -->
                    <div class="description">
                        <?php echo "<p> $postDetailsResult[content]</p>"; ?>
                        <br>
                        <?php
                        if ($images) {
                            while ($imageResult = $images->fetch_array()) {
                                $alt = $imageResult["img_desc"] | "";
                                echo "<img class=\"ui medium bordered image\" src=\"data:image/jpeg;base64," . base64_encode($imageResult["img"]) . "\" alt=\"" . $alt . "\">";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="extra content">
                    <div class="left floated">
                        Upvotes: <?php echo ($postDetailsResult["uvotes"] - $postDetailsResult["dvotes"]); ?>
                    </div>
                    <div class="right floated author">
                        <?php echo $postDetailsResult["poster"] ?>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <!-- COMMENT SECTION -->
            <div class="ui comments">
                <?php  
                    $sql = "SELECT 
                                (SELECT COUNT(c.comment_id)
                                 FROM `comments` c
                                 WHERE c.post_id = $postid)
                                +
                                (SELECT COUNT(r.reply_id)
                                 FROM `replies` r
                                 WHERE r.comment_id IN (SELECT c.comment_id
                                                        FROM `comments` c 
                                                        WHERE c.post_id = $postid ))
                                AS totalCmts";

                    $numComs = mysqli_query( $connection, $sql ) or die("Failed to execute query");
                    $numComs = $numComs->fetch_array() ["totalCmts"];
                ?>
                <h3 class="ui dividing header">Comments</h3>
                <h5 class="ui header" >( <?= $numComs ?> comments )</h5>

                <!-- NEW COMMENT FORM -->
                <form class="ui reply form" method="POST" action="../controllers/newcomment.php">
                    <div class="field">
                        <textarea name="comment" placeholder="Type a comment..."></textarea>
                    </div>
                    <?php
                        echo "<input type='text' name='uname' value=$username hidden>";
                        echo "<input type='text' name='postid' value=$postid hidden>";
                        echo "<input type='text' name='comid' value=$communityID hidden>";
                    ?>
                    <button class="ui orange labeled submit icon button" type="submit">
                        <i class="icon edit"></i>
                        Add Comment
                    </button>
                </form>

                <!-- ALL COMMENTS -->
                <div class="ui dividing header"></div>
                <?php
                    $allCommentsQuery = "   SELECT
                                                c.comment_id as commentid, DATE(c.comment_datetime) as comdate, c.comment_content as comment,
                                                u.username as commenter
                                            FROM `comments` c
                                            INNER JOIN `users` u ON (u.user_id = c.commenter_id)
                                            WHERE c.post_id = $postid";

                    $allComments = mysqli_query( $connection, $allCommentsQuery )
                        or die("Failed to fetch comments");

                    if ( $allComments ) {
                        while ( $comments = $allComments->fetch_array() ) {
                            echo "<div class=\"comment\">";
                                // echo "<a class=\"avatar\"><img src=\"/images/avatar/small/elliot.jpg\"></a>";
                                echo "<div class=\"content\">";
                                    echo "<a class=\"author\">$comments[commenter]</a>";
                                    echo "<div class=\"metadata\"> <span class=\"date\">$comments[comdate]</span> </div>";
                                    echo "<div class=\"text\"> <p>$comments[comment]</p> </div>";
                                    echo "<br>";
                                    echo "<div class='ui grid row'>
                                            <div class=\"actions\"> <a class=\"reply\" href='../view/forms/newreply.php?commentid=$comments[commentid]&postid=$postid&uname=$username&comid=$communityID'>Reply</a> </div>
                                            <div class=\"actions\"> <a class=\"reply\" href='../view/forms/edit_comment.php?commentid=$comments[commentid]&postid=$postid&uname=$username&comid=$communityID'>Edit</a> </div>
                                          </div>";
                                    echo "<br>";
                                echo "</div>";

                                $repliesQuery ="SELECT
                                                    r.reply_content as reply, DATE(r.reply_datetime) as replytime, u.username as replier, r.reply_id as replyid
                                                FROM `replies` r
                                                INNER JOIN `users` u ON (u.user_id = r.replier_id)
                                                WHERE r.comment_id = $comments[commentid]";
                                $allReplies = mysqli_query( $connection, $repliesQuery )
                                    or die("Failed to fetch replies");

                                if ( $allReplies ) {
                                    echo "<div class=\"comments\">";
                                    while ( $reply = $allReplies->fetch_array() ) {
                                        echo "<div class=\"comment\">";
                                            echo "<div class=\"content\">";
                                                echo "<a class=\"author\">$reply[replier]</a>";
                                                echo "<div class=\"metadata\"> <span class=\"date\">$reply[replytime]</span> </div>";
                                                echo "<div class=\"text\"> <p>$reply[reply]</p> </div>";
                                                echo "<br>";
                                                echo "<div class=\"ui grid row\">";
                                                    echo "<div class=\"actions\" onclick='location.href=\"./forms/replyupdate.php?replyid=$reply[replyid]&uname=$username&comid=$communityID&postid=$postid\"'><a class=\"reply\">Edit</a></div>";
                                                    echo "<div class=\"actions\" onclick='location.href=\"../controllers/delete/reply.php?replyid=$reply[replyid]&uname=$username&comid=$communityID&postid=$postid\"'><a class=\"reply\">Delete</a></div>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                    echo "</div>";
                                }
                            echo "</div>";
                        }
                    }
                ?>
            </div>

            <div class="ui horizontal divider"></div>
        </div>

        <?php include_once("./templates/sidebar.php") ?>
</div>

<?php
    include_once("./templates/foot.php");
?>