<?php
include './app/logic.php';
include './app/variables.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <?php
  echo $head;
  ?>
</head>
<body>
  <div class="landing-page">
    <section class="left">
      <div class="owl-carousel owl">
        <?php
        createSlides();
        ?>
      </div>
    </section>
    <section class="right">
      <?php echo $title ?>
      <form class="form" method="post"
      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="firstForm">
        <div class="form">
          <label for="mail" class="form__label">Enter your email
            <span class="invalid"><?php echo $errEmail?></span></label>
          <input type="email" class="form__input-box" id="mail"
          name="email" placeholder="example@gmail.com"
          value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user'];?>">
          <label for="password" class="form__label">
            <h4 class="password__heading">Choose secure password
              <span class="invalid"><?php echo $errPassword?></span></h4>
            <p class="password__text">Must be at least 8 characters</p>
          </label>
          <input type="password" class="form__input-box form__password"
          id="password" name="password" minlength="4"
          placeholder="enter your password">
          <input type="checkbox" id="checkbox" name="remember">
          <label for="checkbox" class="form__label form--checkbox-custom">
            Remember me
          </label>
          <button type="submit" class="submit button" name="signUp"
          id="signUp">Sign Up</button>
        </div>
      </form>
  </div>
  <?php
  echo $script;
  ?>
</body>
</html>
