<h2>Make an Enquiry</h2>
<!--the form for making an enquiry -->
<form action="index.php?destination=enquiry" method="post">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Course Name:</label>
    <select name="course">
        <option value="Courses"> select your course </option>
        <!--looping trough the existing courses -->
        <?php foreach ($courses as $course) { ?>
            <option value="<?= $course['coursesTitle'] ?>">
                <?= $course['coursesTitle'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Enquiry Context:</label>
    <textarea name="context" rows="1" required></textarea>

    <input type="submit" name="submit" value="Send Enquiry">
</form>