<?php
include 'logic.php';
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
      <form class="form <?php echo $_SESSION['first_form']?>" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="firstForm">
        <div class="form">
          <label for="mail" class="form__label">Enter your email <span class="invalid"><?php echo $errEmail?></span></label>
          <input type="email" class="form__input-box" id="mail" name="email" placeholder="example@gmail.com"value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user'];?>">
          <label for="password" class="form__label">
            <h4 class="password__heading">Choose secure password<span class="invalid"><?php echo $errPassword?></span></h4>
            <p class="password__text">Must be at least 8 characters</p>
          </label>
          <input type="password" class="form__input-box form__password" id="password" name="password" minlength="8" placeholder="enter your password">
          <input type="checkbox" id="checkbox" name="remember">
          <label for="checkbox" class="form__label form--checkbox-custom">Remember me</label>
          <button type="submit" class="submit button" name="signUp" id="signUp">Sign Up</button>
        </div>
      </form>
      <form class="form <?php echo $_SESSION['second_form']?> " action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="secondForm" method="post">
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
        <form class="<?php echo $_SESSION['result']?>" action="<?php echo ($_SERVER["PHP_SELF"]);?>" method="post">
           <button type="submit" name="back" class="submit button">back</button>
        </form>
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
