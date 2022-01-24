<?php
    // TODO: LOGIN FEATURE
    $PAGE_TITLE = "Login";
    $LOGGED_IN  = false;
    $MY_STYLE_PATH = "../styles/mubin/main.css";

    $msg = isset($_GET['msg']) ? $_GET["msg"] : "";

    include_once("./templates/head.php");
    include_once("./templates/logger.php");
?>

<div class="ui middle aligned center aligned grid">
    <div class="column raised segment">
        <form class="ui form very padded raised segment" method="POST" action="../controllers/loginmanager.php">
            <div class="row">
                <h1 class="header">User Login</h1>
            </div>

            <?php
                if ($msg == 'loginerror') {
                    showUIMessage("Invalid username or password.", "Please try again...", "negative");
                } else if ($msg == 'regsuccess') {
                    showUIMessage("Successfully Registered!", "You can now log in to your account :)", "positive");
                } else if ($msg == 'userdelete') {
                    showUIMessage("Deleted User", "We are sorry to see you go. :(", "teal");
                }
            ?>

            <div class="ui section divider"></div>

            <div class="row field">
                <label>
                    <h4 class="label header">Username:</h4>
                </label>

                <input type="text" name="USERNAME" pattern="[a-zA-Z0-9]{5,32}" title="Only Alphanumeric Values of length 5 to 32" placeholder="Username" autocomplete="off" required>
            </div>

            <div class="row field">
                <label>
                    <h4 class="">Password:</h4>
                </label>
                <input type="password" name="PASSWORD" pattern="[a-zA-Z0-9]+" placeholder="Password" required>
            </div>

            <br>
            <br>

            <div class="ui grid two columns">
                <div class="ui left floated left aligned wide column" style="align-items: center;">
                    <a class="ui link center aligned" href="./register.php">Don't have an account with us?</a>
                </div>

                <div class="ui right floated right aligned wide column">
                    <button class="ui large button orange" type="submit">
                        <i class="user icon"></i>
                        Log In
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
    include_once('./templates/foot.php');
?>
