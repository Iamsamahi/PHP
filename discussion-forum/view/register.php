<?php
    $PAGE_TITLE = "Register";
    $msg = isset($_GET['msg']) ? $_GET['msg'] : "";

    $MY_STYLE_PATH = "../styles/mubin/main.css";
    include_once("./templates/head.php");
    include_once("./templates/logger.php");
?>

<div class="ui middle aligned center aligned grid">
    <div class="column raised segment">
        <form class="ui form very padded raised segment" method="POST" action="../controllers/registrationmanager.php">
            <h3 class="ui header center aligned">Registration Form</h3>

            <?php
                if ($msg == 'unameerror') {
                    showUIMessage(
                        "User already exists",
                        "That username is already registered. Login or Try a different username",
                        "negative"
                    );
                } else if ($msg == 'mailerror') {
                    showUIMessage(
                        "Email already registered",
                        "That user mail is already registered. Login or Try registering with a different email.",
                        "negative"
                    );
                }
            ?>

            <div class="ui section divider"></div>

            <div class="row field">
                <label>Username</label>
                <input type="text" name="USERNAME" placeholder="Username" required>
            </div>

            <div class="row field">
                <label>Email</label>
                <input type="text" name="MAIL" placeholder="Email" required>
            </div>

            <div class="row field">
                <label>Password</label>
                <input type="password" name="PASSWORD" placeholder="Password" required>
            </div>

            <div class="row field">
                <label>Date of Birth</label>
                <input type="date" name="DOB" required>
            </div>

            <br>
            <br>

            <div class="ui grid two columns">
                <div class="ui left floated left aligned wide column">
                    <button class="ui small button center aligned" onclick="location.href='./login.php'">
                        <i class="angle left icon"></i>
                        Go Back
                    </button>
                </div>

                <div class="ui right floated right aligned wide column">
                    <button class="ui small button orange" type="submit">
                        <i class="clipboard check icon"></i>
                        Register Now
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<?php
    include_once("./templates/foot.php");
?>
