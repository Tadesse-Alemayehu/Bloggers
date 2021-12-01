<?php

use function PHPSTORM_META\sql_injection_subst;

session_start();
$_SESSION['conInfo'] = ["localhost", "root", "", "blog"];
$con = mysqli_connect("localhost", "root", "", "blog") or die("cant connect to the database");
$_SESSION['con'] = $con; // only beeing used on login page
include "./includes/functions.php";
if (isset($_POST['login'])) {
    login(mysqli_real_escape_string($con, $_POST['email']), mysqli_real_escape_string($con, $_POST['password']));
} else if (isset($_POST['LogOut'])) {
    logout();
}
?>
<!DOCTYPE html>
<html lang="en">
<script lang="javascript" src="./javascript/functions.js">
</script>

<head>
    <link rel="icon" href="./files/3D tube WM.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@100;500&family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We-Blog</title>
    <link rel="stylesheet" href="./style/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/prism.css">
    <link rel="stylesheet" href="./style/index.css">
</head>

<body>
    <div class="normalFlow">
        <header>
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <a href="./">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 115 56">
                                <defs>
                                    <pattern id="pattern" preserveAspectRatio="none" width="100%" height="100%" viewBox="0 0 601 292">
                                        <image width="601" height="292" xlink:href="data:image/png;base64,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" />
                                    </pattern>
                                </defs>
                                <rect id="Asset_3-8" data-name="Asset 3-8" width="115" height="56" fill="url(#pattern)" />
                            </svg>

                        </div>
                    </a>
                    <div class="menu">
                        <a href="AddBlog.php">+Blog</a>
                        <a href="#" aria-disabled="true">subscribe</a>
                        <a href="#">contact</a>
                    </div>
                </div><?php
                        if (isset($_SESSION['userId'])) :
                        ?>
                    <span class="row floatLeft">
                        <span class="smallTitle">
                            <?php echo $_SESSION['userFname'] . " " . $_SESSION['userLname'] ?>
                        </span>
                    </span>
                <?php endif; ?>
                <div class="row justify-content-end">
                    <div class="category">
                        <label for="category">Category</label>
                        <select id="category">
                            <option value="">General</option>
                            <option value="">tech talk</option>
                            <option value="">news</option>
                        </select>
                    </div>
                </div>
            </div>
        </header>