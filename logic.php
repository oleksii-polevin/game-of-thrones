<?php
session_start();

//array with images for slider
$images = ['arryn','baratheon','greyjoy',
'lannister','martell','stark','tully'];

//for testing password and textarea
define("LENGTH", "7");

//default value for houses
$not_selected = 'Select Your Great House';

//error messages
$errEmail = $errPassword = $errName = $errHouse = $errTextarea = '';

//check first form
if(isset($_POST['signUp'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email) || empty($password)) {
    $errEmail = $errPassword = "   Required";
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
      file_put_contents('data/'.$email.'.json', $data);
      header('Location: form2.php');
      // added for testiing purposes
    } else { // existing user
      //$errEmail = "<br> <i>$email</i> is already registered.";
      $json_object = file_get_contents('data/'.$email.'.json');
      // read user's data
      $data = json_decode($json_object, true);
      $_SESSION['data'] = $data;
      // password verification
      if($data['password'] === $password) {
        header('Location: form2.php');
      } else {
        $errEmail = "<br> <i>$email</i> is already registered. <br>
        If you want to change personal info type your email and password";
        unset($_SESSION['user']);
        unset($_SESSION['data']);
      }
    }
  }
}
//processing second form
if(isset($_POST['save'])) {
  $user = $_SESSION['user'];
  $name = $_POST['name'];
  $house = $_POST['house'];
  $textarea = $_POST['hobby'];
  $json_object = file_get_contents('data/'.$user.'.json');
  $data = json_decode($json_object, true);

  // all fields are correct
  if(preg_match('/\w{2,20}/', $name)
  && strlen($textarea) > LENGTH
  && $house !== $not_selected) {

    $data['name'] = $name;
    $data['house'] = $house;
    $data['hobby'] = $textarea;
    file_put_contents('data/'.$user.'.json', json_encode($data));
    header('Location: info.php');
    //processing errors
  } else {
    //invalid mame
    if(!preg_match('/^\w{2,20}$/', $name)) {
      unset($_SESSION['data']['name']);
      $errName = "   Enter your name (only letters and digits allowed)";
    } else {
      $_SESSION['data']['name'] = $name;
    }
    //invalid textarea
    if(strlen($textarea) < LENGTH) {
      unset($_SESSION['data']['hobby']);
      $errTextarea = "   Type at least 8 symbols";
    } else {
      $_SESSION['data']['hobby'] = $textarea;
    }
    //house not selected
    if($house === $not_selected) {
      unset($_SESSION['data']['house']);
      $errHouse = "   Choose house";
    } else {
      $_SESSION['data']['house'] = $house;
    }
  }
}

//check file in folder 'data'
function hasEmail($email)
{
  $files = scandir('data');
  return in_array($email.'.json', $files);
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
