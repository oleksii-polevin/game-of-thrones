<?php
include 'logic.php';
include 'variables.php';
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
        foreach($images as $item) {
          echo "<img src='sources/image/$item.jpg' alt='$item'>";
        }
        ?>
      </div>
    </section>
    <section class="right">
      <?php echo $title ?>
      <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
        id="secondForm" method="post">
        <div class="form">
          <div class="message">
            <p class="message__text">You've successfully joined the game. <br>
              Tell us more about yourself.
            </p>
          </div>
          <label for="name" class="label">
            <h2 class="label__heading">Who are you?<span class='invalid'>
              <?php echo $errName?></span></h2>
            <p class="label__text">Alpha-numeric username</p>
          </label>
          <input type="text" id="name" class="form__input-box" name="name"
          value="<?php
          if(isset($_SESSION['data']['name']))
          echo $_SESSION['data']['name'];
          ?>"
          placeholder="arya">
          <label for="houses" class="form__label">Your Great House
            <span class='invalid'><?php echo $errHouse?></span></label>
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
          <label for="textarea" class="form__label">
            Your preferences, hobbies, wishes, etc.
            <span class='invalid'><?php echo $errTextarea?></span></label>
          <textarea name="hobby" id="textarea" class="form__input-box form__input-box__textarea"
          rows="3" placeholder="I have long TOKILL list..."><?php
          if(isset($_SESSION['data']['hobby']))
          echo $_SESSION['data']['hobby']?></textarea>
          <button id="save" type="submit" class="submit button button__save"
          name="save">Save</button>
        </div>
      </form>
      <?php
      echo $script;
      ?>
    </body>
    </html>
