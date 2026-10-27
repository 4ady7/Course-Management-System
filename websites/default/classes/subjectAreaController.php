<?php
class SubjectAreaController {
    private $subjectTable;
    private $courseTable;
    
    
    public function __construct($pdo) {
        //connecting to the subject areas table, by creating a databasetable class instance that takes the database connection stored in the variable pdo, the table name, and the primary key
        $this->subjectTable = new DatabaseTable($pdo, 'subjectAreas', 'subject_id');
        //connecting to the courses table, by creating a databasetable class instance that takes the database connection stored in the variable pdo, the table name, and the primary key 
        $this->courseTable = new DatabaseTable($pdo, 'courses', 'idcourses');
    }

    //function foe lisitng the subject areas
    public function list() {
        //lookng up an existing subject area in the database, so using the findAll function to find the subject area records, and storing it in the variable subjects. Then storing these records as an array in $subjects
        $subjects = $this->subjectTable->findAll();

        //loading the output of the subject areas list tempelete file and storing it in the variable content
        ob_start();
        //capturing the the subject area list tempelete
        require __DIR__ . '/../pageTemplates/subjectArea.php';
        //storing the output in the variable
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Subject Areas',
            //returning the output of the subject area list templete file stored in the varibale content
            'content' => $content
        ];
    }

    public function edit() {
        //So I realised that I am using the following ineffectively because in that code: I am saying if the login variable is not set to True, then the user to the dashboard page. However, I am not even allowing the user to click the edit button, because I am hiding the edit button through the html code. On the other hand, it logically makes sense to me because the if normal user is not logged, and this area is above the user’s access level then it makes sense to me to hide it through html code, and it still makes sense to me to keep this checking code for extra security.
        //if the login variable is not set to True, then send the user to the dashboard page.
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password  
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        //checking if the save subject button has been clicked
        if (isset($_POST['submit'])) {
            //saving the subject entered by the user into the database subject area table
            $this->subjectTable->save($_POST['subject']);
            //and then directing the user to subject area list
            header('Location: index.php?destination=subject&action=list');
            exit();
        }

        //initializing subjects
        $subject = null;
        //checking if there is an id
        if (isset($_GET['id'])) {
            //if there is an id, we search for that id in the subject id column in the subjects table, and we store it in the variable result
            $result = $this->subjectTable->find('subject_id', $_GET['id']);
            //we take the value in the array result, and store it in $subject, and if the array result is empty, then $subject is assigned the value null
            $subject = $result[0];
        }
       
        ob_start();
        //capturing the subject area form for ading and editing subjects
        require __DIR__ . '/../pageTemplates/addEditSubjectArea.php';
        //storing the output in the variable
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Edit Subject',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }

    //function for deleteing the subject area
    public function delete() {
        //So I realised that I am using the following ineffectively because in that code: I am saying if the login variable is not set to True, then the user to the dashboard page. However, I am not even allowing the user to click the edit button, because I am hiding the edit button through the html code. On the other hand, it logically makes sense to me because the if normal user is not logged, and this area is above the user’s access level then it makes sense to me to hide it through html code, and it still makes sense to me to keep this checking code for extra security.
        //if the login variable is not set to True, then send the user to the dashboard page.
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password  
            header('Location: index.php?destination=admin&action=login');
            exit();
        }
        if (isset($_POST['id'])) {
            //deleting the subject area that mactches the subject id column in the subject area table
            $this->subjectTable->delete($_POST['id']);
        }
        //directing the user to subject area list
        header('Location: index.php?destination=subject&action=list');
    }
    
    //the begining of the AI assisted code
    //the Prompt used is: "Write a PHP function that handles pagination, fetches records for the current page, and limits each page to a limited number of records"
    public function show() {
        //initializing $courses
        $courses = [];
        //setting the value of $subject to null
        $subject = null;
        
        //grabbing the page number and setting $turnpage to that page number, otherwise setting $turnpage to the value 1
        $turnpage = $_GET['page_num'] ?? 1;
        //setting $limit to the value 10, to limit the number of courses on a opage to 10  
        $limit = 10;
        //storing the value of the calculation in $offset to calculate where to start. If uit's page 1 then $offset's value is 0, and if ut's page 2 then $offset's value is 10, thus skipping the first 10 courses, and starting display with the 11th course on the list on page 2, and if it's page 3 then $offset's value is 20, thus skipping the first 20 courses, and starting display with the 21th course on the list on page 3
        $offset = ($turnpage - 1) * $limit;
        //initializing $totalPages
        $totalPages = 0;

        //checking if the subject area link was clicked, and thus checking if the subject id exists in the url
        if (isset($_GET['id'])) {
            //finding the subject id in the subject_id column in the subjectAreas table, and storing the subject area record in $result
            $result = $this->subjectTable->find('subject_id', $_GET['id']);
            $subject = $result[0];

            //checking if $subject has a record valeu
            if ($subject) {
                //counting the courses records that has that same subject_id and storing it in $totalCourses, and here just to mention I am uitilizing the foreign key subject_id in the courses table
                $totalCourses = $this->courseTable->countRecords('subject_id', $_GET['id']);
                //dividing here to calculate the total number of pages, and using ceil() to approximate and round up to the nearest integear.
                $totalPages = ceil($totalCourses / $limit);

                //grabbing no more than 10 courses depending on which page number it is, and which subject id does this course have
                $courses = $this->courseTable->searchPageLimit('subject_id', $_GET['id'], $limit, $offset);
            }
        }

        //starting capturing
        ob_start();
        //checking if $subject have a record value
        if ($subject) {
            //capturing the view subject area page form including all the their courses
            require __DIR__ . '/../pageTemplates/viewSubjectArea.php';
        } else {
            echo "<p>Subject has not been found</p>";
        }
        //storing the output in the variable
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => $subject['subject_name'] ?? 'Subject Not Found',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }
    //explaining the function in more details: it manages pagination for courses within a subject area, and it calculats the page offset based on current page number, limits the numbe of records displayed per page, and retrives the course records of that subject area from the database
    //the end of the AI assisted code

}