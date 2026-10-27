<?php
class AdminController {
    private $usersTable;
    
    public function __construct($pdo) {
        //creating a users table instance that takes the database connection stored in the variable pdo, the table name, and the primary key 
        $this->usersTable = new Databasetable($pdo, 'users', 'id');
    }

    //ticket 1 function for the login page
    public function login() {
        //initializing a variable
        $failedLogin = '';

        //checking if the login button has been triggered by the keyboard or if the buttin has been clicked
        if (isset($_POST['submit'])) {
            //storing the username taken from the input of the user in the variable username
            $username = $_POST['username'];
            //storing the password taken from the input of the user in the variable password
            $password = $_POST['password'];

            //lookng up an existing user in the database, so using the find function to find the user records that matches the username entered by the user, and storing it in the variable users. Then storing these records that match as an array in the varibale $users
            $users = $this->usersTable->find('username', $username);

            //checking if the variable users is not empty, and chekcing the password aligned with that user record
            if (!empty($users) && password_verify($password, $users[0]['pass'])) {
                //logging the user in
                //becuase the variable users is not empty, and the password is aligned with that in the user record, so the loggedin variable in the session is now set to true
                $_SESSION['loggedin'] = true;
                //and storing the username in the session
                $_SESSION['username'] = $users[0]['username'];
                //and storing the user id in the session
                $_SESSION['user_id'] = $users[0]['id'];
                //and storing the role of the username in the session
                $_SESSION['role'] = $users[0]['role'];

                //taking the user to the admin dashboard
                header('location: index.php?destination=admin&action=dashboard');
                exit();
            }
            //if the variable users is empty, or the password is not aligned with what in the user record, then assigned the following message string to the variable failedLogin
            else {
                //because the variable users is empty, or the password is not aligned with what in the user record, then assigning the following message string to the variable failedLogin
                $failedLogin = 'Login Failed, please check that your username and password, and try again';
            }
        }

        //loading the output of the login form file and storing it in the variable content 
        ob_start();
        //capturing the login form
        require '/websites/default/pageTemplates/login.php';
        //storing the output in the variable
        $content = ob_get_clean();
        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Log In',
            //returning the output of the login templete file stored in the varibale content  
            'content' => $content
        ];
    }


    //funtion for displaying the admin dashboard 
    public function dashboard() {
        //checking if the user(either a staff member admin or a superadmin) is logged in
        if (!isset($_SESSION['loggedin'])) {
            //if the user is notlogged in then directing thr user to the login form to enter the username and password  
            header('Location: index.php?destination=admin&action=login');
            exit();
        }

        //starting capturing, and loading the dashboard templete
        ob_start();
        //capturing the daashboard page templete
        require '/websites/default/pageTemplates/AdminDashboard.php';
        //storing what has been captured in the variable content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Admin Dashboard',
            //returning the output of the dashboard templete file stored in the varibale content 
            'content' => $content
        ];
    }

    //function for logging out
    public function logout() {
        //removing the session variables, so loggedin variable is now not set to True
        unset($_SESSION['loggedin']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
        //destroying the session and deleting all data on the server
        session_destroy();

        //and then taking the user to the home page 
        header('location: index.php?destination=home');
        exit();
    }

    //function for adding an account
    public function add() {
        //So I realised that I am using the following ineffectively because in that code: I am saying if the login variable is not set to True or if the user is not a superadmin, then the user to the dashboard page. However, I am not even allowing the user to click the edit button, because I am hiding the edit button through the html code. On the other hand, it logically makes sense to me because the if normal user is not logged, and this area is above the user’s access level then it makes sense to me to hide it through html code, and it still makes sense to me to keep this checking code for extra security.
        //if the login variable is not set to True or if the user is not a superadmin, then send the user to the dashboard page.
        if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'superadmin') {
        header('Location: index.php?destination=admin&action=login');
        exit();
        }

        //checking if the the add account button has been clicked, and if the add account button has been clicked then do the following
        if (isset($_POST['submit'])) {
        //retrieving the arry of data and storing it in the varibale $user
        $user = $_POST['user'];

        //retrieving the password entered by the user and then hashing the password, and storing it in the pass column in the database
        $user['pass'] = password_hash($user['pass'], PASSWORD_DEFAULT);


        //through accessing the save function in the databaseTable.php, saving and storing the username entered by the user, and the hashed password to the the users table in the database
        $this->usersTable->save($user);

        //taking the user to the admin dashboard
        header('Location: index.php?destination=admin&action=dashboard');
        exit();
        }


        //start capturing and loading the output of the add account form file and storing it in the variable content
        ob_start();
        //capturing the add account form
        require '/websites/default/pageTemplates/addAccount.php';
        //storing the output in the variable content
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Add Account',
            //returning the output of the add account templete file stored in the varibale content
            'content' => $content
        ];

        require '/websites/default/pageTemplates/AdminDashboard.php';
    }


    //funtion for displaying the list of user who can login either as staff member admins, or superadmins
    public function staffList() {
        //So I realised that I am using the following ineffectively because in that code: I am saying if the login variable is not set to True or if the user is not a superadmin, then the user to the dashboard page. However, I am not even allowing the user to click the edit button, because I am hiding the edit button through the html code. On the other hand, it logically makes sense to me because the if normal user is not logged, and this area is above the user’s access level then it makes sense to me to hide it through html code, and it still makes sense to me to keep this checking code for extra security.
        if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'superadmin') {
            //If a normal user tries to access this, send them back to dashboard
            header('Location: index.php?destination=admin&action=dashboard');
            exit();
        }

        
        //lookng up an existing user in the database, so using the findAll function to find the user records, and storing it in the variable users. Then storing these records as an array in the varibale $users
        $users = $this->usersTable->findAll();

        
        //loading the output of the accounts list form file and storing it in the variable content
        ob_start();
        //capturing the the members list form
        require __DIR__ . '/../pageTemplates/membersList.php';
        //storing the output in the variable
        $content = ob_get_clean();

        return [
            //returning the title that will be shown in the tab page on the broswer
            'title' => 'Staff List',
            //returning the output of the members list templete file stored in the varibale content
            'content' => $content
        ];
    }

    public function delete() {
        //So I realised that I am using the following ineffectively because in that code: I am saying if the login variable is not set to True or if the user is not a superadmin, then the user to the dashboard page. However, I am not even allowing the user to click the edit button, because I am hiding the edit button through the html code. On the other hand, it logically makes sense to me because the if normal user is not logged, and this area is above the user’s access level then it makes sense to me to hide it through html code, and it still makes sense to me to keep this checking code for extra security.
        if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'superadmin') {
             header('Location: index.php?destination=admin&action=login');
             exit();
        }

        if (isset($_POST['id'])) {
            //finding the user id in the users table and storing it in $staffMember
            $staffMember = $this->usersTable->find('id', $_POST['id']);

            
            //checking if $staffMember is not empty, and checking if the role of the user is not superadmin, and if both are satisfied then we procced
            if (!empty($staffMember) && $staffMember[0]['role'] !== 'superadmin') {
                //through accessing the delete function in the databaseTable, delteing the user record
                $this->usersTable->delete($_POST['id']);
            }
        }

        //taking the user to the admin dashboard
        header('Location: index.php?destination=admin&action=staffList');
        exit();
    }

}