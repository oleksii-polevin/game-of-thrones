<?php
session_start();
//array with images for slider
$images = ['arryn','baratheon','greyjoy',
'lannister','martell','stark','tully'];

//for testing password and textarea
$LENGTH = 7;

// find out which form need to show
if(!isset($_SESSION['first'])) {
  $_SESSION['second'] = 'invisible';
  $_SESSION['first'] = '';
  $_SESSION['info'] = '';
}

//default value for houses
$not_selected = 'Select Your Great House';

//error messages
$errEmail = $errPassword = $errName = $errHouse = $errTextarea = '';

//check first form
if(isset($_POST['signUp'])) {
  if(empty($_POST['email']) && empty($_POST['password'])) {
    $errEmail = $errPassword = "   Required";
  } else {

    $email_and_password_ok = false; // flag used for validation
    //regex for email
    $regex = '/^\w{2,16}\@\w{2,6}\.\w{2,4}$/';

    $email = $_POST['email'];
    $password = $_POST['password'];
    //email validation
    if(!preg_match($regex, $email)) {
      unset($_SESSION['user']);
      $errEmail = '   incorrect email';
    } else {
      $_SESSION['user'] = $email;
      $email_and_password_ok = true;
    }
    //password validation
    if(strlen($password) < $LENGTH) {
      $errPassword = '   password is too short';
      $email_and_password_ok = false;
    } else {
      $email_and_password_ok = true;
    }

    //check in 'database';       case: new user
    if($email_and_password_ok && !findMail($email)) {
      $data['password'] = $password;
      $data = json_encode($data);
      file_put_contents('data/'.$email.'.json', $data);
      showSecondForm();
      //                          case: existing user
    } else if($email_and_password_ok && findMail($email)) {
      $json_object = file_get_contents('data/'.$email.'.json');
      $data = json_decode($json_object, true);
      $_SESSION['data'] = $data;
      // password verification
      if($data['password'] === $password) {
        showSecondForm();
      } else {
        $errPassword = 'incorrect password';
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
  $_SESSION['first'] = 'invisible';
  $_SESSION['second'] = '';
}

function showInfo()
{
  $_SESSION['second'] = 'invisible';
  $user =  $_SESSION['user'];
  $json_object = file_get_contents('data/'.$user.'.json');
  $data = json_decode($json_object, true);
  $_SESSION['info'] .="<div>". $user."</div>";
  foreach ($data as $key => $value) {
    $_SESSION['info'] .= "<div>$key : $value</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" content="width=device-width, initial-scale=1">
  <title>Game of Thrones</title>
  <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
  <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  <link rel="stylesheet" href="styles/nice-select.css">
</head>
<body>
  <div class="landing-page">
    <section class="left">
      <div class="owl-carousel owl">
        <?php
        foreach($images as $item) {
          echo "<img src='sources/image/$item.jpg' alt='$item'>";
        }
        ?>
      </div>
    </section>
    <section class="right">
      <div class="heading">
        <h1 class="heading__title">Game of thrones</h1>
      </div>
      <form class="form <?php echo $_SESSION['first']?>" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="firstForm">
        <div class="form">
          <label for="mail" class="form__label">Enter your email <span class="invalid"><?php echo $errEmail?></span></label>
          <input type="email" class="form__input-box" id="mail" name="email" placeholder="example@gmail.com"value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user'];?>">
          <label for="password" class="form__label">
            <h4 class="password__heading">Choose secure password<span class="invalid"><?php echo $errPassword?></span></h4>
            <p class="password__text">Must be at least 8 characters</p>
          </label>
          <input type="password" class="form__input-box form__password" id="password" name="password" minlength="2" placeholder="enter your password">
          <input type="checkbox" id="checkbox" name="remember">
          <label for="checkbox" class="form__label form--checkbox-custom">Remember me</label>
          <button type="submit" class="submit button" name="signUp" id="signUp">Sign Up</button>
        </div>
      </form>
      <form class="form <?php echo $_SESSION['second']?> " action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="secondForm" method="post">
        <div class="form">
          <div class="message">
            <p class="message__text">You've successfully joined the game. <br>
              Tell us more about yourself.
            </p>
          </div>
          <label for="name" class="label">
            <h2 class="label__heading">Who are you?<span class='invalid'><?php echo $errName?></span></h2>
            <p class="label__text">Alpha-numeric username</p>
          </label>
          <input type="text" id="name" class="form__input-box" name="name" value="<?php if(isset($_SESSION['data']['name'])) echo $_SESSION['data']['name'];?>"  placeholder="arya">
          <label for="houses" class="form__label">Your Great House<span class='invalid'><?php echo $errHouse?></span></label>
          <select id="houses" name="house" class="houses">
            <?php
            if(isset($_SESSION['data']['house'])) {
              echo "<option>".$_SESSION['data']['house']."<option>";
              foreach ($images as $item) {
                if($item !== $_SESSION['data']['house']) {
                  echo "<option>$item</option>";
                }
              }
              echo "<option>$not_selected</option>";
            } else {
              echo "<option>$not_selected<option>";
              foreach($images as $item) {
                echo "<option>$item</option>";
              }
            }
            ?>
          </select>
          <label for="textarea" class="form__label">Your preferences, hobbies, wishes, etc.<span class='invalid'><?php echo $errTextarea?></span></label>
          <textarea name="hobby" id="textarea" class="form__input-box form__input-box__textarea" rows="3" placeholder="I have long TOKILL list..."><?php if(isset($_SESSION['data']['hobby'])) echo $_SESSION['data']['hobby']?></textarea>
          <button id="save" type="submit" class="submit button button__save" name="save">Save</button>
        </div>
      </form>
      <div class="form info">
        <?php echo $_SESSION['info'] ?>
      </div>
    </section>
  </div>
  <!-- <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script> -->
  <script src="src/jquery-3.4.1.min.js"></script>
  <script src="src/jquery.nice-select.js"></script>
  <script src="owlcarousel/owl.carousel.min.js"></script>
  <script type="text/javascript" src="src/main.js"></script>
</body>
</html>
