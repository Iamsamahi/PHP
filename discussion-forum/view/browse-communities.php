<?php
    $username = $_GET["uname"];

    $PAGE_TITLE = "Browse Communities";
    $MY_STYLE_PATH = "../styles/saif.css" ;

    include_once("./templates/head.php");
    require_once("../controllers/dbconfig.php");
?>

<?php include_once("./templates/navbar.php") ?>

<?php
    $myCommunitiesQuery = " SELECT c.community_id as comid, c.community_name as comname, c.description as comdesc
                            FROM `communities` c
                            INNER JOIN `followed_communities` f ON (c.community_id = f.community_id)
                            INNER JOIN `users` u ON (u.user_id = f.follower_id)
                            WHERE u.username = '$username'" ;

    $communitiesFollowed = mysqli_query($connection , $myCommunitiesQuery )
        or die("Could not get followed communities!") ;
?>

    <div class="ui container">
        <h1>Followed Communities</h1>
        <?php
            if ( $communitiesFollowed ) {
                echo "<table class=\"ui celled table\"> \n";
                    echo "<thead> <th>Community</th> <th>Community Description</th> </thead>";

                    while( $rows = mysqli_fetch_array( $communitiesFollowed ) ) {
                        echo "<tr>" ;
                            echo "<td><a href='./community.php?uname=$username&comid=".$rows["comid"]."'>".$rows["comname"]."</a></td>";
                            echo "<td>".$rows["comdesc"]."</td>";
                        echo "</tr>" ;
                    }
                echo "</table> \n";
            }
        ?>

        <h1>All Communities</h1>
        <?php
            $allCommunitiesQuery = "SELECT
                                        c.community_id as comid, c.community_name as comname, c.description as comdesc
                                    FROM `communities` c";

            $allCommunities = mysqli_query($connection , $allCommunitiesQuery ) or die("Could not get all communities!") ;

            echo "<table class=\"ui celled table\"> \n";
                echo "<thead> <th>Community</th> <th>Community Description</th> </thead>";

                while( $rows = mysqli_fetch_array( $allCommunities ) ) {
                    echo "<tr>" ;
                        echo "<td><a href='./community.php?uname=$username&comid=".$rows["comid"]."'>".$rows["comname"]."</a></td>";
                        echo "<td>".$rows["comdesc"]."</td>";
                    echo "</tr>" ;
                }
            echo "</table> \n";
        ?>
        <br>
        <button class="ui large button orange" onclick="location.href='./forms/community.php?uname=<?php echo $username; ?>'"><i class="comment outline icon"></i> Create A New Community</button>
    </div>

<?php
    include_once("./templates/foot.php");
?>
