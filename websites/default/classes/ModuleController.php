<?php
class ModuleController {
    private $moduleTable;

    public function __construct($pdo) {
        $this->moduleTable = new DatabaseTable($pdo, 'modules', 'idmodule');
    }

    public function edit() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        if (isset($_POST['module'])) {
            //saving the module to the database in the modules table
            $this->moduleTable->save($_POST['module']);
            //then directing thr user to the list of courses that are already saved in the database
            header('Location: index.php?destination=course&action=list');
            exit();
        }

        //initializing $module
        $module = null;
        $course_id = $_GET['course_id'] ?? null;

        //checking if the user clicked the edit module button
        if (isset($_GET['id'])) {
            //editing the existing module
            $result = $this->moduleTable->find('idmodule', $_GET['id']);
            $module = $result[0];
            //storing the course id of the module in $course_id
            $course_id = $module['idcourses'];
        }

        ob_start();
        //capturing the page form
        require __DIR__ . '/../pageTemplates/moduleForm.php';
        //storing the output in $content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Edit Module',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }

    public function delete() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is not logged in then directing thr user to the login form to enter the username and password
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        if (isset($_POST['id'])) {
            //deleting the module that mactches the module id column in the modules table
            $this->moduleTable->delete($_POST['id']);
        }
        //directing the user to the list of courses that are already saved in the database
        header('Location: index.php?destination=course&action=list');
    }

}
?>