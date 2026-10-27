<h1>Welcome to the university website</h1>
<?php
//checking if the user exsists in the session storage memeory and is logged in to the session. In other words, checking if the loggedin variable is set to true, and if the loggedin variable is set to true then displaying the following paragraph and admin panel link 
if (isset($_SESSION['loggedin'])) {
?>
    <p>
        Click the following to go to the admin setting page
        <li><a href="index.php?destination=admin&action=dashboard">Admin Panel</a></li>
    </p>
<?php
}
?>
<br>
<p>
    You can also view our full catalogue of courses here:
    <li><a href="index.php?destination=course&action=list">View All Courses</a></li>
</p>
<br>
<em>Click the folllowing to search</em>
<li><a href="index.php?destination=course&action=search">Search</a></li>
<br>
<em>we are supporting aspiration, creating opportunities, delivering impact</em>
<p>And We offer an extensive support throughout your studies. We have a range of support and services available to help ensure that your time at the University is as enjoyable and rewarding as possible. Our services offer support in many areas including academic, mental and physical health, disabilities, and general student support.</p>