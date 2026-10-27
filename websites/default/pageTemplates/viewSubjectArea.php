<h1>
    <!--displaying the subject area name -->
    <?= $subject['subject_name'] ?>
</h1>

<ul>
    <?php 
    //checking if there have been any courses added to this suject area
    if (empty($courses)) {
        echo "<p>No courses currently available in this subject.</p>";
    } else {
        //looping throuh courses
        foreach ($courses as $course) { 
            ?>
            <li>
                <h3><?= $course['coursesTitle'] ?></h3>

                <p>
                    Part Time Status:
                    <?php
                    //checking if the course can be enrolled into part time
                    if ($course['PartTime'] === 'Y') {
                        //displaying the following if the course can be enrolled part time
                        echo "This course can be completed part time";
                    } else {
                        //displaying the following if the course can not be enrolled part time
                        echo "This course can not be completed part time";
                    }
                    ?>
                </p>

                <p>
                    <!--//displaying the type of the course -->
                    Type: <?= $course['courseType'] ?><br>
                    <!--//displaying the duration of the course -->
                    Duration: <?= $course['courses_duration'] ?? 'N/A' ?> Years
                </p>
                <!--//displaying the description of the course -->
                <p><?= $course['coursesDes'] ?? '' ?></p>
                
                <?php if (isset($_SESSION['loggedin'])) { ?>
                    <a href="index.php?destination=course&action=edit&id=<?= $course['idcourses'] ?>">Edit Course</a>
                <?php } ?>
            </li>
            <hr>
            <?php 
        } 
    }
    ?>
</ul>

<?php if ($turnpage > 1) { ?>
        <a 
        href="index.php?destination=subject&action=show&id=<?= $_GET['id'] ?>&page_num=<?= $turnpage - 1 ?>
        "class="button"> Previous
        </a>
<?php } ?>
Page <?= $turnpage ?> of <?= $totalPages ?>
<?php if ($turnpage < $totalPages) { ?>
        <a 
        href="index.php?destination=subject&action=show&id=<?= $_GET['id'] ?>&page_num=<?= $turnpage + 1 ?>" class="button">
            Next
        </a>
<?php } ?>