<h1>Welcome back, <?= $_SESSION['username'] ?></h1>

<h3>Here is some quick links:</h3>
<ul>
    <li>
        <a href="index.php?destination=course&action=list">Manage Courses</a>
        <p>Add, edit, or delete courses.</p>
    </li>

    <li>
        <a href="index.php?destination=subject&action=list">Manage Subject Areas</a>
        <p>Update the list of subjects.</p>

        <br>

        <p>Here is a list of all the submitted enquires:</p>
        <a href="index.php?destination=enquiry&action=manage">Enquiry List</a>
    </li>
    <?php
    //checking f the role of the username is stored in the session and also checking if the role stored is superadmin, and if both are true then display the following
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') {
    ?>
        <li>
            <p>Create new users</p>
            <a href="index.php?destination=admin&action=add">Add New account</a>

            <br>
            <br>

            <p>Delete existing users</p>
            <a href="index.php?destination=admin&action=staffList">Delete Staff Accounts</a>
        </li>
    <?php
    }
    ?>
</ul>