<h3 class="ui dividing header fluid row">
    Delete Account
</h3>

<p class="row">This action is irreversible. Do you still wish to delete your account?</p>

<form class="ui row" method="POST" action="../controllers/delete/user.php">
    <input type="hidden" name="USERNAME" value="<?php echo $username; ?>">
    <button type="submit" class="ui left floated button red">Yes. Delete My Account</button>
</form>
