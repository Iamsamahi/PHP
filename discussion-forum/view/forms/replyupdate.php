<?php
    require_once("../../controllers/dbconfig.php");

    $username = $_GET["uname"];
    $communityID = $_GET["comid"];
    $postID = $_GET["postid"];
    $replyid = $_GET['replyid'];

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
    <div class="column">
        <div class="ui row">
            <h3 class="ui header center aligned">
                Reply Update
            </h3>
        </div>

        <div class="ui section divider"></div>

        <div class="ui row">
            <form class="ui form" method="POST" action="../../controllers/updatereply.php">
                <div class="field">
                    <label>Reply</label>
                    <textarea type="text" name="REPLY" placeholder="New Reply"></textarea>
                </div>
                <input type="text" name="uname" value="<?php echo $username ?>" hidden>
                <input type="text" name="comid" value="<?php echo $communityID ?>" hidden>
                <input type="text" name="postid" value="<?php echo $postID ?>" hidden>
                <input type="text" name="replyid" value="<?php echo $replyid ?>" hidden>

                <button class="ui button right floated large orange" type="submit">Update</button>
            </form>

            <button class="ui button left floated large" onclick="location.href='../post.php?uname=<?php echo $username;?>&comid=<?php echo $communityID?>&postid=<?php echo $postID; ?>'">Go Back</button>
        </div>
    </div>
</div>
