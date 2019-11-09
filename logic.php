<?php
session_start();
if(isset($_POST['back'])) {
  session_unset();
}
//array with images for slider
$images = ['arryn','baratheon','greyjoy',
'lannister','martell','stark','tully'];

//for testing password and textarea
$LENGTH = 7;

// find out which form need to show
if(!isset($_SESSION['first_form'])) {
  $_SESSION['second_form'] = 'invisible';
  $_SESSION['first_form'] = '';
  $_SESSION['info'] = '';
  $_SESSION['result'] = 'invisible';
}

//default value for houses
$not_selected = 'Select Your Great House';

//error messages
$errEmail = $errPassword = $errName = $errHouse = $errTextarea = '';

//check first form
if(isset($_POST['signUp'])) {
  if(empty($_POST['email']) || empty($_POST['password'])) {
    $errEmail = $errPassword = "   Required";
  } else {
    $email_ok = false; // flag used for validation
    $password_ok = false;
    //regex for email
    // $regex = '/^\w{2,16}\@\w{1,6}\.\w{2,4}$/';
    $email = $_POST['email'];
    $password = $_POST['password'];
    //email validation
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      unset($_SESSION['user']);
      $errEmail = '   incorrect email';
    } else {
      $_SESSION['user'] = $email;
      $email_ok = true;
    }
    //password validation
    if(strlen($password) < $LENGTH) {
      $errPassword = '   password is too short';
      $password_ok = false;
    } else {
      $password_ok = true;
    }

    //check in 'database';       case: new user
    if($email_ok && $password_ok && !findMail($email)) {
      $data['password'] = $password;
      $data = json_encode($data);
      file_put_contents('data/'.$email.'.json', $data);
      showSecondForm();
      //                          case: existing user
    } else if($email_ok && $password_ok && findMail($email)) {
      $json_object = file_get_contents('data/'.$email.'.json');
      $data = json_decode($json_object, true);
      $_SESSION['data'] = $data;
      // password verification
      if($data['password'] === $password) {
        showSecondForm();
      } else {
        $errPassword = '  wrong password';
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
  && strlen($textarea) > $LENGTH
  && $house !== $not_selected) {

    $data['name'] = $name;
    $data['house'] = $house;
    $data['hobby'] = $textarea;
    file_put_contents('data/'.$user.'.json', json_encode($data));
    showInfo();
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
    if(strlen($textarea) < $LENGTH) {
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

function findMail($email)
{
  $files = scandir('data');
  if(in_array($email.'.json', $files)) {
    return true;
  }
  return false;
}

function showSecondForm()
{
  $_SESSION['first_form'] = 'invisible';
  $_SESSION['second_form'] = '';
}

function showInfo()
{
  $_SESSION['second_form'] = 'invisible';
  $_SESSION['result'] = '';
  $user =  $_SESSION['user'];
  $json_object = file_get_contents('data/'.$user.'.json');
  $data = json_decode($json_object, true);
  $_SESSION['info'] .="<div>". $user."</div>";
  foreach ($data as $key => $value) {
    $_SESSION['info'] .= "<div>$key : $value</div>";
  }
}
