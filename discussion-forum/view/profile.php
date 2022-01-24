<?php
    $username = $_GET["uname"];

    $PAGE_TITLE = "User Profile: $username";
    require_once("./templates/head.php");
    require_once("../controllers/dbconfig.php");

    $getUserDetailsQuery = "SELECT * FROM `users` WHERE username = '$username'";
    $userRow = mysqli_query($connection, $getUserDetailsQuery) or die("failed to get user details");

    $userDetails = null;
    if ($userRow) {
        $userDetails = $userRow->fetch_array();
    }

    $getFollowedComms = "SELECT c.community_name AS comname
                         FROM `communities` c
                         INNER JOIN `followed_communities` f
                             ON (f.community_id = c.community_id)
                         WHERE f.follower_id = (SELECT u.user_id FROM `users` u WHERE u.username = '$username')";

    $followedComms = mysqli_query( $connection, $getFollowedComms )
        or die("Failed to fetch follow info");
?>

<?php include_once("./templates/navbar.php") ?>

<div class="ui container">
    <div class="ui grid">
        <div class="four wide column" id="mynavmenu">
            <div class="ui vertical menu">
                <a class="active item orange" id="profileViewBtn" onclick="updateView('profileViewBtn')">
                    Profile
                    <i class="left user icon"></i>
                </a>
                <a class="item" id="updateProfileBtn" onclick="updateView('updateProfileBtn')">
                    Update Profile
                    <i class="left wrench icon"></i>
                </a>
                <a class="item" id="followManageBtn" onclick="updateView('followManageBtn')">
                    Manage Follows
                    <i class="left list alternate icon"></i>
                </a>
                <a class="item" id="deleteUserBtn" onclick="updateView('deleteUserBtn')">
                    Delete Account
                    <i class="left trash alternate icon"></i>
                </a>
            </div>
        </div>

        <div class="twelve wide column">
            <div class="ui very padded segment grid">
                <div class="twelve wide column" id="mymainview">
                    <?php include("./templates/followview.php") ?>
                </div>
                <div class="four wide column">
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let views = {
        'deleteUserBtn'   : './templates/deleteview.php',
        'profileViewBtn'  : './templates/profileView.php',
        'updateProfileBtn': './templates/updateView.php',
        'followManageBtn' : './templates/followview.php',
    };

    function updateView(btnID) {
        Array.prototype.forEach.call(document.getElementById('mynavmenu').getElementsByClassName('active'), function(element) {
            element.classList.remove('active', 'orange');
        });
        document.getElementById(btnID).classList.add('active');
        document.getElementById(btnID).classList.add('orange');

        $.ajax({
            type: "GET",
            url: views[btnID],
            dataType: "html"
        }).done(function (data) {
            $('#mymainview').html(data);
        });
    }
</script>

<?php
    require_once("./templates/foot.php");
?>