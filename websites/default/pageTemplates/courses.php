<!--checking if a user (either is a staff or a superadmin) is logged in -->
<?php if (isset($_SESSION['loggedin'])) { ?>
    <h2>Courses</h2>
    <p>Add a new course using the link below:</p>
    <a href="index.php?destination=course&action=edit" >Add New Course</a>
<?php } ?>


<h1>Here is a list of courses</h1>

<ul>
    <!--looping through courses -->
    <?php foreach ($courses as $course) { ?>
        <li>
            <h3><?= $course['coursesTitle'] ?></h3>
                <p>
                    Part Time Status:
                    <?php
                    if ($course['PartTime'] === 'Y') {
                        echo "This course can be completed part time";
                    } else {
                        echo "This course can not be completed part time";
                    }
                    ?>
                </p>
            <?php if (isset($_SESSION['loggedin'])) { ?>
                <li>
                    
                    <form action="index.php?destination=course&action=delete" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $course['idcourses'] ?>">
                        <input type="submit" value="Delete Course" onclick="return confirm('Are you sure you want to delete the course ?');">
                    </form>
                    <a href="index.php?destination=course&action=edit&id=<?= $course['idcourses'] ?>">Edit Course</a>
                </li>
            <?php } ?>
            
            <p><?= $course['coursesDes'] ?? '' ?></p>



            <h3>Modules</h3>

            <?php
            //the following are only visible if a user is logged in.
            if (isset($_SESSION['loggedin'])) { 
            ?>
                <!-- the following are only visible if a user is logged in. Adding a module is only visible if a user is logged in.-->
                <a href="index.php?destination=module&action=edit&course_id=<?= $course['idcourses'] ?>"> Add Module</a>

            <?php 
            } 
            ?>
            
            <?php
            //checking if a module or modules exists for a course
            if (isset($course['modules']) && !empty($course['modules'])) { 
            ?>
                <ul style="padding-left: 0;">
                    <?php 
                    foreach ($course['modules'] as $module) { 
                    ?>
                        <li style="margin-bottom: 10px; border-left: 3px solid;">
                            <h4><?= $module['moduleCode'] ?> - <?= $module['moduleName'] ?></h4>
                            <p><?= $module['moduleDescription'] ?></p>
                            
                            <?php
                            //the following are only visible if a user is logged in.
                            if (isset($_SESSION['loggedin'])) { 
                            ?>
                                <!--the following are only visible if a user is logged in. editing the the module is only visible if a user is logged in. -->
                                <a href="index.php?destination=module&action=edit&id=<?= $module['idmodule'] ?>">Edit Module</a>
                                
                                <!--the following are only visible if a user is logged in. deleting the module is only visible if a user is logged in. -->
                                <form action="index.php?destination=module&action=delete" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $module['idmodule'] ?>">
                                    <input type="submit" value="Delete Module" style="padding: 2px 5px;" onclick="return confirm('Are you sure you want to delete the module ?');">
                                </form>
                                
                            <?php 
                            } 
                            ?>
                        </li>
                    <?php 
                    } 
                    ?>
                </ul>
            <?php 
            } else { 
            ?>
                <p>No modules assigned yet.</p>
            <?php 
            } 
            ?>







        </li>
    <?php } ?>
</ul>