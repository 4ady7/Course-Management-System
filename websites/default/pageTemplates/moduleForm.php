<h2>
    <!-- checking for a module id, if there is a subject id then print Edit, otherwise print Add -->
    <?php if (isset($module['idmodule'])) {
            echo 'Edit';
        } else {
            echo 'Add';
        }
    ?>
    <!--printing Module in both cases -->
    Module
</h2>

<form action="" method="post">
    <input type="hidden" name="module[idmodule]" value="<?= $module['idmodule'] ?? '' ?>">
    
    <input type="hidden" name="module[idcourses]" value="<?= $course_id ?? '' ?>">

    <label>Module Code:</label>
    <input type="text" name="module[moduleCode]" value="<?= $module['moduleCode'] ?? '' ?>" required placeholder="e.g. CSY2028">

    <label>Module Name:</label>
    <input type="text" name="module[moduleName]" value="<?= $module['moduleName'] ?? '' ?>" required placeholder="e.g. Web Programming">

    <label>Description:</label>
    <textarea name="module[moduleDescription]" rows="5"><?= $module['moduleDescription'] ?? '' ?></textarea>

    <input type="submit" name="submit" value="Save Module">
</form>