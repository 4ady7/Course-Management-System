<?php
class CourseController {
    private $courseTable;
    private $subjectTable;
    private $moduleTable;

    public function __construct($pdo) {
        //connecting to the courses table
        $this->courseTable = new DatabaseTable($pdo, 'courses', 'idcourses');
        
        //connecting to the subject areas table for the dropdown
        $this->subjectTable = new DatabaseTable($pdo, 'subjectAreas', 'subject_id');

        //connecting to the modules table for the dropdown
        $this->moduleTable = new DatabaseTable($pdo, 'modules', 'idmodule');
    }



    public function edit() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        if (isset($_POST['theCourse'])) {
            //saving the course to the database in the courses table
            $this->courseTable->save($_POST['theCourse']);
            //then directing thr user to the list of courses that are already saved in the database
            header('Location: index.php?destination=course&action=list');
            exit();
        }

        
        //initializing $course
        $course = null;
        //checking if the user clicked the edit button
        if (isset($_GET['id'])) {
            //editing the existing course
            $result = $this->courseTable->find('idcourses', $_GET['id']);
            $course = $result[0];
        }

        //finding all the subject area records, and storing all the subject area records in the subject area table as an array in $subjects 
        $subjects = $this->subjectTable->findAll();

        ob_start();
        //capturing the page form
        require __DIR__ . '/../pageTemplates/course.php';
        //storing the output in $content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Edit Course',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }



    //the begining of the AI assisted code
    //the Prompt used is: "Write a PHP function that filters records from a database table using GET parameters and loads the results into a template file"
    public function list() {
        //checking if the search courses button has been clicked, thus the Search Form was submitted
        if (isset($_GET['search_submit'])) {
            
            //initializing $filters
            $filters = [];
            //checking if the courses id exists in the url, and that the url is not empty without an id
            if (!empty($_GET['idcourses'])) {
                $filters['idcourses'] = $_GET['idcourses'];
            }

            //filtering the courses by the Subject Area
            if (!empty($_GET['subject_id'])) {
                $filters['subject_id'] = $_GET['subject_id'];
            }

            //filtering the courses by the Course Type (BSc, MSc, etc.)
            if (!empty($_GET['type'])) {
                $filters['courseType'] = $_GET['type'];
            }

            //filtering the courses by the Duration
            if (!empty($_GET['duration'])) {
                //the database column is courses_duration, and the form input is duration
                $filters['courses_duration'] = $_GET['duration'];
            }

            //filtering the courses by PartTime
            if (!empty($_GET['PartTime'])) {
                $filters['PartTime'] = $_GET['PartTime'];
            }

            //if the search courses button has been clicked, thus the Search Form was submitted, so passing filters to the function findFiltered in the DatabaseTable, which returns the rows of courses after they have been filtered from all the rows of courses in the courses table, and if no filter has been selected then then returing all courses, and the returned rows of courses are stored in $courses
            $courses = $this->courseTable->findFiltered($filters);
        } 
        else {
            //if no search criteria has been selected by the user to filter the search, then finding all the course records, and storing all the course records in the courses table as an array in $courses, thus storing all the courses in $courses
            $courses = $this->courseTable->findAll();
        }


        //looping through each course row in the courses table
        foreach ($courses as $key => $value) {
            //attaching modules to their courses using the courses id as a foriegn key
            $courses[$key]['modules'] = $this->moduleTable->find('idcourses', $value['idcourses']);
        }

        
        ob_start();
        //capturing the subject area page form
        require __DIR__ . '/../pageTemplates/courses.php';
        //storing the output in the variable
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Course List',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    
    }
    //explaining the function in more details: it retrives course records from the database, and if search parmeters are provided through GET variables, it filters the records acccordingly; otherwise it retrives all records; and the results are then passed to a template file for display
    //the end of the AI assisted code 

    public function delete() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is not logged in then directing thr user to the login form to enter the username and password
            header('Location: index.php?destination=admin&action=login');
            exit();
        }
        if (isset($_POST['id'])) {
            //deleting the course that mactches the course id column in the courses table
            $this->courseTable->delete($_POST['id']);
        }
        //directing the user to the list of courses that are already saved in the database
        header('Location: index.php?destination=course&action=list');
    }


    public function search() {
        //finding all the subject area records, and storing all the subject area records in the subject area table as an array in $subjects for the subject areas dropdown
        $subjects = $this->subjectTable->findAll();

        //finding all the course records, and storing all the course records in the courses table as an array in $courses for the courses dropdown
        $courses = $this->courseTable->findAll();

        ob_start();
        //capturing the page form
        require __DIR__ . '/../pageTemplates/searchCourses.php';
        //storing the output in $content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Search Courses',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }
}