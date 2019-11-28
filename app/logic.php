<?php
session_start();

// array with images for slider
define('IMAGES', ['arryn','baratheon','greyjoy',
'lannister','martell','stark','tully']);

define('DIR', 'data/');

// for testing password and textarea
define("LENGTH", "7");

// default value for houses
$not_selected = 'Select Your Great House';

// error messages
$errEmail = $errPassword = '';

// check first form
if(isset($_POST['signUp'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email) || empty($password)) {
    $errEmail = $errPassword = " Required";
    unset($_SESSION['user']);
    return;
  }

  if(!testEmail($email)) {
    unset($_SESSION['user']);
    $errEmail = ' incorrect email';
  }

  if(!testPassword($password)) {
    $errPassword = ' password is too short';
  }

  if(testEmail($email) && testPassword($password)) {
    $_SESSION['user'] = $email;
    // new user
    if(!hasEmail($email)) {
      $data['password'] = $password;
      $data = json_encode($data);
      file_put_contents('./app/'.DIR.$email.'.json', $data);
      header('Location: ./app/form2.php');
    } else { // existing user
      $json_object = file_get_contents('./app/'.DIR.$email.'.json');
      // read user's data
      $data = json_decode($json_object, true);
      $_SESSION['data'] = $data;
      // password verification
      if($data['password'] === $password) {
        header('Location: ./app/form2.php');
      } else {
        $errEmail = "<br> <i>$email</i> is already registered. <br>
        If you want to change personal info type your email and password";
        $errPassword = "wrong password";
        unset($_SESSION['user']);
        unset($_SESSION['data']);
      }
    }
  }
}

//processing second form
if(isset($_POST['second'])) {
  $error = [];
  $user = $_SESSION['user'];
  $name = $_POST['name'];
  $house = $_POST['house'];
  $hobby = $_POST['hobby'];
  $json_object = file_get_contents(DIR.$user.'.json');
  $data = json_decode($json_object, true);

  // all fields are correct
  if(preg_match('/\w{2,20}/', $name)
  && strlen($hobby) > LENGTH
  && $house !== $not_selected) {

    $data['name'] = $name;
    $data['house'] = $house;
    $data['hobby'] = $hobby;
    file_put_contents(DIR.$user.'.json', json_encode($data));
    header('Location: info.php');
    //processing errors
  } else {
    //invalid mame
    if(!preg_match('/^\w{2,30}$/', $name)) {
      unset($_SESSION['data']['name']);
      $error['name'] = " Name should be from 2 to 30 symbols long";
    } else {
      $error['name'] = '';
    }
    //invalid textarea
    if(strlen($hobby) < LENGTH) {
      unset($_SESSION['data']['hobby']);
      $error['hobby'] = "   Type at least 8 symbols";
    } else {
      $error['hobby'] = '';
    }
    //house not selected
    if($house === $not_selected) {
      unset($_SESSION['data']['house']);
      $error['house'] = " Choose house";
    } else {
      $error['house'] = '';
    }
    unset($_POST['second']);
    echo json_encode($error);
  }
}

//check file in folder 'data'
function hasEmail($email)
{
  // $files = scandir('./app/data');
  // return in_array($email.'.json', $files);
  return file_exists("./app/data/".$email.".json");
}

function testEmail($email)
{
  $regex = '/^\w{2,20}\@\w{1,6}\.\w{2,4}$/';
  return preg_match($regex, $email);
}

function testPassword($password)
{
  return strlen($password) > LENGTH;
}

function createSlides()
{
  foreach(IMAGES as $item) {
    echo "<img src='../public/sources/image/$item.jpg' alt='$item'>";
  }
}
