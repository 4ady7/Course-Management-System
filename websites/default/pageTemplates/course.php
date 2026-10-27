<h2>
    <?php if (isset($course['idcourses'])) {
            echo 'Edit';
        } else { 
            echo 'Add';
        }
    ?> 
    Course
</h2>


<form action="" method="post">
    <input type="hidden" name="theCourse[idcourses]" value="<?= $course['idcourses'] ?? '' ?>">

    <label>Course Title:</label>
    <input type="text" name="theCourse[coursesTitle]" value="<?= $course['coursesTitle'] ?? '' ?>" required>

    <label>Type:</label>
    <select name="theCourse[courseType]">
        <option value="BSc" <?= ($course['courseType'] ?? '') == 'BSc' ?>>BSc</option>
        <option value="MSc" <?= ($course['courseType'] ?? '') == 'MSc' ?>>MSc</option>
        <option value="PhD" <?= ($course['courseType'] ?? '') == 'PhD' ?>>PhD</option>
    </select>

    <label>Duration (Years):</label>
    <input type="number" name="theCourse[courses_duration]" value="<?= $course['courses_duration'] ?? '' ?>">


    <label>Part Time:</label>
    <input type="hidden" name="theCourse[PartTime]" value="N">
    <label style="display: inline-block; float: none;">
        <input type="checkbox" name="theCourse[PartTime]" value="Y"
            style="width: auto; float: none;"
            <?= ($course['PartTime'] ?? 'N') === 'Y' ? 'checked' : '' ?>
        >
        Is this course available Part-Time?
    </label>


    <label>Description:</label> <!-- if the user did not enter information in the description box then return an empty string -->
    <textarea name="theCourse[coursesDes]" rows="5"><?= $course['coursesDes'] ?? '' ?></textarea>




    <label>Subject Area (Subfolder):</label>
    <select name="theCourse[subject_id]" required>
        <option value="">-- Select a Subject --</option>
        <?php foreach ($subjects as $subject) { ?>
            <?php
            // Check if this subject is the one currently saved for this course
            $selected = '';
            if (($course['subject_id'] ?? '') === $subject['subject_id']) {
                $selected = 'selected'; 
            }
            ?>
            <option value="<?= $subject['subject_id'] ?>" <?= $selected ?>>
                <?= $subject['subject_name'] ?>
            </option>
        <?php } ?>
    </select>

    <input type="submit" name="submit" value="Save Course">
</form>