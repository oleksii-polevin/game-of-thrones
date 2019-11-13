<?php
include 'logic.php';
include 'variables.php';
$info = '';

//return to index and wipe out session variables
if(isset($_POST['back'])) {
  session_destroy();
  header('Location: index.php');
} else { //show info
  isset($_SESSION['user']) ? $user = $_SESSION['user'] : $user = '';
  if($user) { // preventing of showing php errors on the screen if used alt + back
    $json_object = file_get_contents('data/'.$user.'.json');
    $data = json_decode($json_object, true);
    $info .="<div>". $user."</div>";
    foreach ($data as $key => $value) {
      $info .= "<div>$key : $value</div>";
    }
  }
}
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
      <div class="form info">
        <?php
        echo  $info;
        ?>
      </div>
      <form class="form info" action="<?php echo ($_SERVER["PHP_SELF"]);?>" method="post" id="info">
        <button type="submit" name="back" class="submit button">back</button>
      </form>
    </div>
    <?php
    echo $script;
    ?>
  </body>
  </html>
