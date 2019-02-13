<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require fat-free
require_once ('vendor/autoload.php');
require_once ('model/db-functions.php');

//connect to database
$dbh = connect();
print_r($dbh);

//Create an instance of the Base class
$f3 = Base::instance();

//Turn of fat free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function() {
    $template = new Template();
    echo $template->render('views/all-students.html');
});

//Run fat-free
$f3->run();
