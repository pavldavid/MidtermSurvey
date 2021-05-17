<?php
//Controller for the cupcakes site

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Define default route
$f3->route('GET /', function(){
    //Display the home page
    $view = new Template();
    echo $view->render('views/home.html');

});

$f3->route('GET|POST /survey' , function($f3){
    $_SESSION = array();

    $userName = "";
    $userMidterms = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $userName = $_POST['name'];

        if (validName($userName))
        {
            $_SESSION['userName'] = $userName;
        }
        else
        {
            $f3->set('errors["name"]', 'Please enter your name');
        }


        if (validFlavors($_POST['midterms']))
        {
            $userMidterms = $_POST['midterms'];

            $_SESSION['userMidterms'] = $userMidterms;
        }
        else
        {
            $f3->set('errors["midterms"]', 'Please select a Midterm option');
        }
        //If there are no errors redirect to summary route
        if (empty($f3->get('errors')))
        {
            header('location: summary');
        }
    }

    $f3->set('midterms', getMidterm());

    $f3->set('userName', $userName);
    $f3->set('userMidterms', $userMidterms);

    $view = new Template();
    echo $view->render('views/survey.html');
});

//Run Fat-Free
$f3->run();
