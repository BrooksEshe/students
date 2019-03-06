<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require fat-free
require_once ('vendor/autoload.php');
require_once ('model/db-functions.php');

//start session after autoload
session_start();

//connect to database
$dbh = connect();
if(!$dbh){
    exit;
}

//Create an instance of the Base class
$f3 = Base::instance();

//Turn of fat free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function($f3) {

    $students = getStudents();

    $f3->set('students',$students);

    $template = new Template();
    echo $template->render('views/all-students.html');
});

$f3->route('GET|POST /add', function($f3) {

    if(isset($_POST['add'])){
        $sid = $_POST['sid'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $birth = $_POST['birth'];
        $gpa = $_POST['gpa'];
        $advisor = $_POST['advisor'];
        $success = addStudent($sid,$first,$last,$birth,
            $gpa,$advisor);

        if($success){
            //create a student object
            $student = new Student($sid,$first,$last,$birth,
                $gpa,$advisor);

            //add to a session
            $_SESSION['student'] = $student;

            //reroute to home page
            $f3->reroute('/');
        }
    }

    $template = new Template();
    echo $template->render('views/new-student.html');
});

$f3->route('GET /summary/@sid', function($f3, $params) {
    $sid = $params['sid'];
    $student = getStudent($sid);
    $f3->set('student', $student);

    //load a template
    $template = new Template();
    echo $template->render('views/view-student.html');
});

//Run fat-free
$f3->run();
