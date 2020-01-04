<?php session_start();
// array with images for slider
define('IMAGES', ['arryn','baratheon','greyjoy',
'lannister','martell','stark','tully']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset='utf-8' content='width=device-width, initial-scale=1'>
    <title>Game of Thrones</title>
    <link rel='stylesheet' href='../public/owlcarousel/owl.carousel.min.css'>
    <link rel='stylesheet' href='../public/owlcarousel/owl.theme.default.min.css'>
    <link rel='stylesheet' type='text/css' href='../public/styles/style.css'>
    <link rel='stylesheet' href='../public/styles/nice-select.css'>
</head>
<body>
    <div class="landing-page">
        <section class="left">
            <div class="owl-carousel owl">
                <?php
                foreach(IMAGES as $item) {
                    echo "<img src='../public/sources/image/$item.jpg' alt='$item'>";
                }?>
            </div>
        </section>
        <section class="right">
            <div class='heading'>
                <h1 class='heading__title'>Game of thrones</h1>
            </div>
            <div class="wrapper">
                <?php
                if(!isset($_SESSION['user'])) {
                    require_once '../app/views/first_form.php';
                } else {
                    require_once '../app/views/second_form.php';
                }
                ?>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='../public/src/jquery.nice-select.js'></script>
        <script src='../public/owlcarousel/owl.carousel.min.js'></script>
        <script type='text/javascript' src='../public/src/main.js'></script>
    </body>
    </html>
