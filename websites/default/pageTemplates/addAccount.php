<h2>Add New Account</h2>

<!--the forma for adding the an account to the accounts list -->
<form action="index.php?destination=admin&action=add" method="post">
    <input type="hidden" name="user[id]" value="<?= $user['id'] ?? '' ?>">

    <label>Username:</label>
    <!--name="user[username] is taking the username typed dowm by the user, and value= is retrireving the username from the database. Why retrireve the username from the database ? to avoid having duplicate usernames-->
    <input type="text" name="user[username]" value="<?= $user['username'] ?? '' ?>" required>

    <label>Password:</label>
    <input type="password" name="user[pass]">

    <label>Role:</label>
    <select name="user[role]">
        <option value="user" <?php if (($user['role'] ?? '') == 'user') { echo 'selected'; } ?> >Limited Acccess Account</option>
        <option value="superadmin" <?php if (($user['role'] ?? '') == 'superadmin') { echo 'selected'; } ?> >Super Admin Account</option>
    </select>

    <input type="submit" name="submit" value="Add Account">
</form>