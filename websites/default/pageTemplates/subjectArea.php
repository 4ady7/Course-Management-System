<h2>Manage Subject Areas</h2>

<?php
//checking if the variable loggedin in the session is set to True, so to determine if a user is logged in 
if (isset($_SESSION['loggedin'])) { 
?>
    <!--so if the user(either a staff member admin or a superadmin) is logged in, then display the href link for adding a new subject area -->
    <a href="index.php?destination=subject&action=edit">Add New Subject Area</a>
<?php
} 
?>

<ul>
    <?php
    //looping through each subject area, and giving each each subject area a link
    foreach ($subjects as $subject) { 
    ?>
        <li>
            <li>            
                <a 
                href="index.php?destination=subject&action=show&id=<?= $subject['subject_id'] ?>"> <?= $subject['subject_name'] ?>
                </a>
            </li>
            <?php
            //checking if the variable loggedin in the session is set to True, so to determine if a user is logged in 
            if (isset($_SESSION['loggedin'])) { 
            ?>
                <li>
                    <form action="index.php?destination=subject&action=delete" method="post">
                        <input type="hidden" name="id" value="<?= $subject['subject_id'] ?>">
                        <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this subject ?');">
                    </form>
                    --> <a href="index.php?destination=subject&action=edit&id=<?= $subject['subject_id'] ?>">Edit</a>
                </li>
            <?php
            } 
            ?>
        </li>
    <?php
    } 
    ?>
</ul>