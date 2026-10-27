<?php
class EnquiryController {
    private $courseTable;
    private $enquiryTable;

    public function __construct($pdo) {
        //connecting to the enquries table
        $this->enquiryTable = new DatabaseTable($pdo, 'enquires', 'idenquires');
        //connecting to the courses table for the dropdown
        $this->courseTable = new DatabaseTable($pdo, 'courses', 'idcourses');
    }

    public function list() {
        //checking if the send enquires button has been clicked, thus the enquiry Form has been submitted
        if (isset($_POST['submit'])) {
            //storing the the details of the enquiry in an array $record, and the keys of the arrays are the database enquiries table column names
            $record = [
                'contactName' => $_POST['name'],
                'contactEmail' => $_POST['email'],
                'courseName' => $_POST['course'],
                'enquiryContext' => $_POST['context']
            ];

            //saving the record to the enquries table in the database
            $this->enquiryTable->save($record);

            
            return [
                //returning the title that will be shown in the tab page on the broswer
                'title' => 'Enquiry Sent',
                //returning a success message
                'content' => '<h2>Message Sent</h2><p>Thank you for your enquiry. We will contact you shortly.</p>'
            ];
        }

        //finding all the course records, and storing all the course records in the courses table as an array in $courses 
        $courses = $this->courseTable->findAll();

        
        ob_start();
        //capturing the page form
        require __DIR__ . '/../pageTemplates/MakeEnquiry.php';
        //storing the output in $content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Make an Enquiry',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }

    public function manage() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        //finding all the enquiry records that are saved in the database, and storing all the enquiry records in the enquries table as an array in $enquiries 
        $enquiries = $this->enquiryTable->findAll();

        
        ob_start();
        //capturing the page form
        require __DIR__ . '/../pageTemplates/EnquriesList.php';
        //storing the output in $content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Manage Enquiries',
            //returning the output of the pagetemplete file stored in the varibale content
            'content' => $content
        ];
    }

    public function complete() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        //checking if the mark as checked button has been clicked for an enquiry
        if (isset($_POST['id'])) {
            //if it clicked, updating the enquiry record
            $record = [
                'idenquires' => $_POST['id'],
                //updating the enquiry status to an enquiry has had a response
                'enquiryResponded' => 1,
                //updating the enquiry status to an enquiry has been responded to by a staff member
                'enquiresRespondedBY' => $_SESSION['username']
            ];
            
            //using the save function to update the enquiry record in the enquires table in the database
            $this->enquiryTable->save($record);
        }

        //directing the user to the list of enquires that are already saved in the database
        header('Location: index.php?destination=enquiry&action=manage');
        exit();
    }
}
?>