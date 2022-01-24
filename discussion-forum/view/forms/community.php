<?php
    $username = $_GET["uname"];

    $PAGE_TITLE = "Create a New Community";

    include_once("../templates/head.php");
    require_once("../../controllers/dbconfig.php");
?>

<div class="ui borderless top inverted secondary menu menu" style="background-color: black;">
    <div class="ui container">
        <a class='item' href="./follows.php?uname=<?php echo $username; ?>">
            <i class="home icon"></i>
            Home
        </a>

        <a class='item' href="./follows.php?uname=<?php echo $username; ?>">
            <i class="tasks icon"></i>
            Follows
        </a>

        <a class='item' href="./browse-communities.php?uname=<?php echo $username; ?>">
            <i class="rss icon"></i>
            Browse All
        </a>
        <a class='item'>
            <i class="info circle icon"></i>
            About
        </a>
        <a class="right item" href="./profile.php?uname=<?php echo $username; ?>">
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
                Community Creation
            </h3>
        </div>

        <div class="ui section divider"></div>

        <div class="ui row">
            <form class="ui form" method="POST" action="../../controllers/newcommunity.php">
                <div class="field">
                    <label>Community Name:</label>
                    <input type="text" name="NAME" placeholder="Community Name">
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea type="text" name="description" placeholder="Community Description"></textarea>
                </div>

                <input type="text" name="uname" value="<?php echo $username ?>" hidden>
                <button class="ui button right floated large orange" type="submit">Create</button>

            </form>

            <button class="ui button left floated large" onclick="location.href='../browse-communities.php?uname=<?php echo $username;?>'">Go Back</button>
        </div>
    </div>
</div>
