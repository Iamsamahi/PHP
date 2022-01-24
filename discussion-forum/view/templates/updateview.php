<h3 class="ui header">Profile Update:</h3>

<form action="./controllers/updates/user.php" method="POST" class="ui form">
    <input type="hidden" name="USERID" value="<?php echo $userDetails["user_id"] ?>">
    <div class="field">
        <label>Username</label>
        <input type="text" name="USERNAME" placeholder="Username" required>
    </div>
    <div class="field">
        <label>Email</label>
        <input type="text" name="EMAIL" placeholder="Email" required>
    </div>

    <!-- <div class="field">
        <label>Password</label>
        <input type="password" name="PASSWORD" placeholder="Password" value="<?php //echo $userDetails["username"]; ?>" required>
    </div> -->

    <button type="submit" class="ui button orange inverted">Save Changes</button>
</form>
