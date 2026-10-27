<h2>
    <!-- checking for a subject id, if there is a subject id then print Edit, otherwise print Add -->
    <?php if (isset($subject['subject_id'])) {
            echo 'Edit';
        } else {
            echo 'Add';
        }
    ?>
    <!--printing Subject Area in both cases -->
    Subject Area
</h2>

<form action="index.php?destination=subject&action=edit" method="post">
    <!--setting the value to the subject id, if subject id is not found then setting the value of value to an empty string -->
    <input type="hidden" name="subject[subject_id]" value="<?= $subject['subject_id'] ?? '' ?>">

    <label>Subject Name:</label>
    <!--setting the value to the subject id, if subject id is not found then setting the value of value to an empty string -->
    <input type="text" name="subject[subject_name]" value="<?= $subject['subject_name'] ?? '' ?>" required>

    <input type="submit" name="submit" value="Save Subject">
</form>