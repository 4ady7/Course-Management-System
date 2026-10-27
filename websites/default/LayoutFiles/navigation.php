<ul>
    <li><a href="index.php?destination=home">Home</a></li>
    <li><a href="index.php?destination=subject&action=list">Subject Area</a></li>


    <li><a href="index.php?destination=enquiry">Make an enquiry</a></li>

    <!-- checking if a user (either is a staff or a superadmin) is logged in, then add the following logout link to the navigation -->
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    ?>
        <!-- because the user is logged in, then adding logout link to the navigation bar -->
        <li><a href="index.php?destination=admin&action=logout">Logout</a></li>
    <?php
    } else {
    ?>
        <!-- and in the case that the user is not logged in then adding the login link to the navigation bar -->
        <li><a href="index.php?destination=admin&action=login">Login</a></li>
    <?php
    }
    ?>
</ul>