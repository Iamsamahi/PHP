<div class="ui segments">
    <div class="ui orange segment header">
        <p>
        <h5 class="ui header">Username</h5>
        </p>
    </div>
    <div class="ui attached segment">
        <p><?php echo $userDetails["username"]; ?></p>
    </div>

    <div class="ui orange segment header">
        <p>
        <h5 class="ui header">Usermail</h5>
        </p>
    </div>
    <div class="ui attached segment">
        <p><?php echo $userDetails["usermail"]; ?></p>
    </div>

    <div class="ui orange segment header">
        <p>
        <h5 class="ui header">Date of Birth</h5>
        </p>
    </div>

    <div class="ui attached segment">
        <p><?php echo $userDetails["date_of_birth"]; ?></p>
    </div>

    <div class="ui orange segment header">
        <p>
        <h5 class="ui header">Date Joined</h5>
        </p>
    </div>
    <div class="ui attached segment">
        <p><?php echo $userDetails["date_joined"]; ?></p>
    </div>

    <!-- <div class="ui orange segment header"><p><h5>Password</h5></p></div> -->
    <!-- <div class="ui segment"><p><?php //echo $userDetails["password"]; ?></p></div> -->
</div>