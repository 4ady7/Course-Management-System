<h2>Manage Staff Accounts</h2>

<table border="1">
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //lloping through each user in the users table in the database 
        foreach ($users as $staff) {
        ?>
            <tr>
                <td><?= $staff['username'] ?></td>
                <td><?= $staff['role'] ?></td>

                <td>
                    <?php
                    //checking if the user(staff) id retieved from the users table in the database is not equla to the user id that is already logged in in the current session
                    if ($staff['id'] != $_SESSION['user_id']) {
                    ?>
                        <!--if it is not the same user id that is already logged in in the current session, then displaying the delete button next to that user -->
                        <form method="post" action="index.php?destination=admin&action=delete" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure ?');">
                        </form>
                    <?php
                    } else {
                    ?>
                        <!--otherwise if it is the same user id that is already logged in in the current session, then displaying the following paragraph next -->
                        <p>(This is your account that is currently logged in)</p>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>