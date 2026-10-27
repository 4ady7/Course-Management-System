<h2>Search for a Course</h2>

<!--form for the search page -->
<!--since I want anyone to use the search function to search for courses, anyone, even those who are not looged in, so I am using the GET method to allow friends to share a url with their friends-->
<form action="index.php" method="get">
    <!--connecting to the course controller through routing -->
    <input type="hidden" name="destination" value="course">

    <label>Subject Area:</label>
    <select name="subject_id">
        <option value=""> Subjects </option>
        <?php 
        foreach ($subjects as $subject) { 
        ?>
            <option value="<?= $subject['subject_id'] ?>">
                <?= $subject['subject_name'] ?>
            </option>
        <?php 
        } 
        ?>
    </select>

    <label>Course Type:</label>
    <select name="type">
        <option value=""> Types </option>
        <option value="BSc">BSc</option>
        <option value="MSc">MSc</option>
        <option value="PhD">PhD</option>
    </select>

    <label>Duration:</label>
    <select name="duration">
        <option value=""> Duration </option>
        <option value="1">1 Year</option>
        <option value="2">2 Years</option>
        <option value="3">3 Years</option>
        <option value="4">4 Years</option>
    </select>

    <label>Course Part Time Status:</label>
    <select name="PartTime">
        <option value=""> Status </option>
        <option value="Y">Can be Part Time</option>
        <option value="N">Can Not be Part Time</option>
    </select>

    <input type="submit" name="search_submit" value="Search Courses">
</form>