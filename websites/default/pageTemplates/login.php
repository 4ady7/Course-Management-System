<h2>Log In</h2> username: master3 password: master3
<!-- the form for the login page for the user(either a staff member admin or a superadmin) to login -->
<form action="index.php?destination=admin&action=login" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <input type="submit" name="submit">
</form>
<?php
//checking if the variable is not empty, and if the varibale is not wmpty then displaying the an error error message if it is not empty
if (!empty($failedLogin)) {?>
    <!-- because the variable is not empty, displaying the content of the variable, which is displaying an error message to the user that the login has failed -->
    <?= $failedLogin ?>
<?php } ?>