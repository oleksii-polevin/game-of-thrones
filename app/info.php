<?php
include 'logic.php';
$info = '';

//return to index and wipe out session variables
if(isset($_POST['back'])) {
  session_destroy();
  header('Location: ../index.php');
} else { //show info
  $user = $_SESSION['user'] ?? $user = '';
  if($user) { // preventing of showing php errors on the screen if used alt + back
    $json_object = file_get_contents(DIR.$user.'.json');
    $data = json_decode($json_object, true);
    $info .="<div>". $user."</div>";
    foreach ($data as $key => $value) {
      $info .= "<div>$key : $value</div>";
    }
  }
}
?>
<div class="form info">
  <?php
  echo  $info;
  ?>
</div>
<form class="form info" action="<?php echo ($_SERVER["PHP_SELF"]);?>" method="post" id="info">
  <button type="submit" name="back" class="submit button">home</button>
</form>
</div>
