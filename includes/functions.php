<?php
function logout()
{
    clearBlogTempData();
    session_destroy();
    echo "<script>window.location='./';</script>";
}
function setNull(&...$args)
{
    foreach ($args as &$arg) {
        $arg = null;
    }
}
function login($email, $Password)
{
    $res = mysqli_query($_SESSION['con'], "select * from author where email='$email' and Password='$Password'");
    $namedResult = mysqli_fetch_assoc($res);
    // echo sizeof($namedResult);
    // if (sizeof($namedResult) > 0) {
    if ($namedResult) {
        $_SESSION['userId'] = $namedResult['id'];
        $_SESSION['userFname'] = $namedResult['Fname'];
        $_SESSION['userLname'] = $namedResult['Lname'];
        $_SESSION['userEmail'] = $namedResult['email'];
        $_SESSION['userTitle'] = $namedResult['Title'];
        $_SESSION['userExperties'] = $namedResult['Experties'];
        $_SESSION['userPassword'] = $namedResult['Password'];
        unset($_POST['RegisterNewUser']);
        echo "<script>window.location='http://localhost/winmac-blog/';</script>";
    } else {
        echo "<script>window.location='http://localhost/winmac-blog/?cantSignIn=1';</script>";
    }
    // echo "use is loged in";
}


// not used for the time beeing
function processMyimage($source, $destination, $w, $h, $ext)
{
    list($w_original, $h_original) = getimagesize($source);
    $scale_ratio = $w_original / $h_original;
    // $oldRatio = $w / $h;
    // echo $oldRatio;
    // $newRatio = $width / $height;
    // echo $newRatio;
    // echo print_r($source);
    // echo $ext;
    if (($w / $h) > $scale_ratio) {
        $w = $h * $scale_ratio;
    } else {
        $h = $w / $scale_ratio;
    }
    // echo "<br/>" . $ext;
    // exif_read_data($source);
    $img = "";
    if (strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0) :
        $img = imagecreatefromjpeg($source);
    elseif (strcasecmp($ext, "webp") == 0) :
        $img = imagecreatefromwebp($source);
    elseif (strcasecmp($ext, "bmp") == 0) :
        $img = imagecreatefrombmp($source);
    elseif (strcasecmp($ext, "gif") == 0) :
        $img = imagecreatefromgif($source);
    elseif (strcasecmp($ext, "png") == 0) :
        $img = imagecreatefrompng($source);
    elseif (strcasecmp($ext, "wbmp") == 0) :
    elseif (strcasecmp($ext, "string") == 0) :
        $img = imagecreatefromstring($source);
    endif;
    $newImg = imagecreatetruecolor($w, $h);
    // echo $w, " ", $h;
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $w, $h, $w_original, $h_original);
    imagejpeg($newImg, $destination);
}

function createTumnbnail($source, $destination, $TumbWidth)
{
    $im = imagescale($source, $TumbWidth);
    imagejpeg($im, $destination);
}
function clearBlogTempData()
{
    // echo "<script lang='javascript'>localStorage.clear();alert('cleared')</script>";
    if (isset($_SESSION['images'])) {
        $keys = array_keys($_SESSION['images']);
        foreach ($keys as $key) :
            if (unlink("./files/blogsData/tempoUpload/$key.png")) :
                unset($_SESSION['order']["$key"]);
                unset($_SESSION['images']["$key"]);
            endif;
        endforeach;
    }
    setNull($_SESSION['order'], $_SESSION['preserve'], $_SESSION['type'], $_SESSION['title'], $_SESSION['textArea'], $_SESSION['images'], $_FILES['AddPicture'], $_SESSION['content']);
}

function saveDataToDatabase()
{
    foreach ($_SESSION["textArea"] as $textArea) :
        echo $textArea;
    endforeach;
    foreach ($_SESSION["order"] as $contents) :
        echo print_r($contents);
    endforeach;
}
