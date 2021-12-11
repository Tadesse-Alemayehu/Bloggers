<?php include "header.php";
include "./includes/validateRegistration.php";
// echo print_r(gd_info());
// $image = imagecreatefrompng("./files/3D tube WM.png");
// $rotateImage = imagerotate($image, 45, false);
// imagepng($rotateImage, "./files/createdImage.png", 9);
?>
<div class="heading">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="textContent">
                    <ol>
                        <li class="title">
                            <p>you can be a bloger ?</p>
                        </li>
                        <li>
                            <p>sign in / register</p>
                        </li>
                        <li>
                            <p>compile your blog</p>
                        </li>
                        <li>
                            <p>publish / share</p>
                        </li>
                        <li>
                            <!-- <p>or contact us for any guidance. </p> -->
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="profileContainer row">
                    <div class="col-sm-6">
                        <div id="profileImage">
                            <!-- <img src="./files/icons/anonymous_user.svg" alt="winmac Text"> -->
                            <?php
                            $data_target = "";
                            if (isset($_SESSION['userId']) || isset($_POST['updateProfilePicture'])) :
                                $uid = $_SESSION['userId'];
                                $data_target = "data-userId='$uid'";
                                $profilePic =  mysqli_fetch_assoc(getQueryResult("select profilePic from author where id='$uid'"))['profilePic'];
                                if (!$profilePic == "") {
                            ?>
                                    <script lang="javascript" type="text/javascript">
                                        const profilePicture = document.getElementById("profileImage");
                                        // console.log(profilePicture);
                                        updateAbackgroundPicture(`<?php echo  $profilePic ?>`,
                                            profilePicture);
                                    </script>
                            <?php
                                }
                            endif;
                            ?>
                            <label for="userProfileImage" <?php echo $data_target ?>></label>
                            <input type="file" accept="image/*" name="addProfilePicture" id="userProfileImage" hidden></input>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <span>Not Signed In</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="userAction">
        <form action="" method="POST">
            <?php
            if (!isset($_SESSION['userId'])) :
            ?>
                <button class="button" type="submit" name="Register">Register</button>
                <button id="login" class="button" type="button" name="showLoginModal" data-toggle="modal" data-target="#LoginModal">Login</button>
            <?php else : ?>
                <button class="button" type="submit" name="addBlog">Add Blog</button>
                <button class="button" type="submit" name="LogOut">Logout</button>
            <?php endif; ?>
        </form>
    </div>
    <?php if (isset($_POST['Register']) || isset($_POST['RegisterNewUser'])) :
        include "./includes/registerationForm.php";
    endif; ?>
</div>
<?php include "./includes/modals.php" ?>

<div class="container-fluid Home">
    <div class="row ">
        <div class="col-xs-12 menu">
            <a href="#" class="blog-selection">most recent</a>|
            <a href="#" class="blog-selection">most ranked</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="blogTitle">this is paragraph</div>
            <p> this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph </p>
        </div>
        <div class="col-sm-4 BlogSideImage">
            <img src="./files/react@2x.png" alt="angular">
        </div>
    </div>
    <div class="row align-items-center BlogList">
        <?php
        $getAllBlogs = mysqli_fetch_all(getQueryResult("select b.id, b.timeOf, b.author, b.title, b.type, b.cover from blog as b;"), 1);
        // echo print_r(mysqli_num_rows($getAllBlogs));
        $blogDetail = [[[], [], []]];

        for ($i = 0; $i < count($getAllBlogs); $i++) {
            // echo $i . "<br/>";
            // echo print_r($getAllBlogs[$i]) . "<br/>";
            $blog = $getAllBlogs[$i];
            // echo print_r($blog['timeOf']) . "<br/>";
            $bId = $blog['id'];
            $bAId = $blog['author'];
            $blogInfo = ["id" => $bId, "time" => $blog['timeOf'], "author" => $bAId, "title" => $blog['title'], "type" => [$blog['type']], "cover" => $blog['cover']];
            $blogDetail[$i][0] = [];
            array_push($blogDetail[$i][0], $blogInfo);
            $res = getQueryResult("select a.fname, a.lname, a.title, a.experties, a.email, a.profilePic from author as a where a.id=$bAId;");
            // echo print_r($res) . "<br/>";
            if ($res) {
                $author = mysqli_fetch_assoc($res);
                $auuthorInfo = ["id" => $bAId, "fname" => $author['fname'], "lname" => $author['lname'], "title" => $author['title'], "experties" => $author['email'], "email" => $author['experties'], "profilePic" => $author['profilePic']];
                $blogDetail[$i][1] = [];
                array_push($blogDetail[$i][1], $auuthorInfo);
            }
            $content = getQueryResult("select c.orderOf, c.contentType, c.content, c.remark from content as c where c.bid=$bId;");
            $blogDetail[$i][2] = [];
            array_push($blogDetail[$i][2], $content);
            // echo $key . "<br/>";
            // echo print_r($blog) . "<br/>";
            $i++;
        }
        // echo print_r($blogDetail) . "<br/>";
        foreach ($blogDetail as $key => $blog) :
            // echo print_r($blog);
        ?>
            <div class="col-md-6">
                <div class="row halfSide">
                    <div class="col-md-8">
                        <div class="blogTitle">this is paragraph</div>
                        <p> this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is </p>
                    </div>
                    <div class="col-md-4 BlogSideImage">
                        <img src="./files/Angular@1x.png" alt="angular">
                    </div>
                </div>
            </div>
        <?php
        endforeach;
        ?>
        <!--
        <div class="col-md-6 halfSide">
            <div class="row">
                <div class="col-md-8">
                    <div class="blogTitle">this is paragraph</div>
                    <p> this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is paragraph this is </p>
                </div>
                <div class="col-md-4 BlogSideImage">
                    <img src="./files/vue@2x.png" alt="angular">
                </div>
            </div>
        </div> -->
    </div>
</div>
<?php include "footer.php"; ?>