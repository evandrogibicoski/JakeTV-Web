<?php
include('service.php');
include('secure/customjs.php');
$obj = new service_class();

/* if(isset($_SESSION['sessionid'])){
  $sel = $obj->qry_fetchRow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
  $userid = $sel['userid'];
  }
  $PageLimit = "6";
  if(isset($_POST['load_value'])){
  echo $Page1 = $_POST['load_value'];
  $PageLimit = $Page1*$PageLimit;
  $_SESSION['pagedata'] = $PageLimit;
  }
  if(!empty($_SESSION['pagedata'])){
  $PageLimit =  $_SESSION['pagedata'];
  }else{
  $PageLimit = "6";
  }
  $qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
  foreach($qry02 as $qry){
  $id = $qry['catidu'];
  $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
  $dd[] = $qry021;
  }
  foreach($dd as $v1){
  if(is_array($v1)){
  foreach($v1 as $v2){$newArray[] = $v2;}
  }
  }
  foreach($newArray as $newArray){
  $post_id[] = $newArray['postid'];
  }
  $d = implode(',',$post_id);
  $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");
  $total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc"); */

if (isset($_SESSION['sessionid'])) {
    @$user_main_detail = $obj->qry_fetchRow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");
}


$PageLimit = "24";
if (isset($_POST['load_value'])) {
    echo $Page1 = $_POST['load_value'];
    $PageLimit = $Page1 * $PageLimit;
    $_SESSION['pagedata'] = $PageLimit;
}

if (!empty($_SESSION['pagedata'])) {
    $PageLimit = $_SESSION['pagedata'];
} else {
    $PageLimit = "24";
    //$_SESSION['pagedata'] = $PageLimit;
}

$qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");

if (!empty($qry02)) {
    foreach ($qry02 as $qry) {
        $id = $qry['catidu'];
        $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' AND publish='1' order by sort_order asc");
        $dd[] = $qry021;
    }

    foreach ($dd as $v1) {
        if (is_array($v1)) {
            foreach ($v1 as $v2) {
                @$newArray[] = $v2;
            }
        }
    }
    if (!empty($newArray)) {
        foreach ($newArray as $newArray) {
            $post_id[] = $newArray['postid'];
        }
    } else {
        $post_id[] = "";
    }
} else {
    $post_id[] = "";
}

if (isset($_SESSION['sessionid'])) {
    $sel = $obj->qry_fetchRow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");

    $userid = $sel['userid'];
    $first_rname = $sel['fname'];
    $last_name = $sel['lname'];
    $user_catid = explode(',', $sel['catid']);
    foreach ($user_catid as $k => $v) {
        if ($v == "") {
            $user_catid = array();
        } else {
            $user_catid[] = $v;
        }
    }
    if (!empty($sel['catid'])) {
        for ($i = 0; $i < count($user_catid); $i++) {
            $id = $user_catid[$i];
            $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' AND publish='1' order by sort_order asc");
            $user_cat_post[] = $qry021;
        }
        foreach ($user_cat_post as $v1) {
            if (is_array($v1)) {
                foreach ($v1 as $v2) {
                    @$user_post_array[] = $v2;
                }
            }
        }
        if (!empty($user_post_array)) {
            foreach ($user_post_array as $user_post_array) {
                $user_post_id[] = $user_post_array['postid'];
            }
            $user_post_id1 = array_unique($user_post_id);
            foreach ($user_post_id1 as $k => $v) {
                $user_post_id2[] = $v;
            }
        } else {
            $user_post_id2[] = "";
        }
    } else {
        $user_post_id2[] = "";
    }



    $all_post_id = array_merge($user_post_id2, $post_id);

    $all_post_id2 = array_unique($all_post_id);

    foreach ($all_post_id2 as $k => $val) {
        if ($val != "") {
            $all_post_id1[] = $val;
        }
    }
    if (!empty($all_post_id1)) {
        $d = implode(',', $all_post_id1);
        $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (" . $d . ") AND status = '1' AND publish='1' order by sort_order asc LIMIT $PageLimit");
        $total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (" . $d . ") AND status = '1' AND publish='1' order by sort_order asc");
    } else {
        @$fetch_post == array();
        $total_post_rows = 0;
    }
} else {
    foreach ($post_id as $k => $val) {
        if ($val != "") {
            $post_id1[] = $val;
        }
    }
    if (!empty($post_id1)) {
        $d = implode(',', $post_id);
        $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (" . $d . " ) AND status = '1' AND publish='1' order by sort_order asc LIMIT $PageLimit");

        $total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (" . $d . ") AND status = '1' AND publish='1' order by sort_order asc");
    } else {
        @$fetch_post == "";
        $total_post_rows = 0;
    }
}
/* -------Category List------ */
if (isset($_SESSION['sessionid'])) {
    $cat_list = $obj->qry_fetchRow("select catid from tbl_user where sessid='" . $_SESSION['sessionid'] . "' and userid='" . $userid . "'");
    if (!empty($cat_list)) {
        foreach ($cat_list as $k => $v) {
            if (!empty($v)) {
                $cat_list['catid'] = $v;
            } else {
                $cat_list = array();
            }
        }
        if (!empty($cat_list)) {
            $cat_list1 = $obj->qry_fetchRows("SELECT category,catidu FROM tbl_category WHERE catidu IN (" . $cat_list['catid'] . ") AND status='1'");
            if (!empty($cat_list1)) {
                $cat_list1 = $cat_list1;
            } else {
                $cat_list1 = array();
            }
        } else {
            $cat_list1 = array();
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="shortcut icon" href="images/JAKEtv_flav.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8_unicode_ci" />
        <meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
        <title>Jake TV • Jewish Arts Knowledge Entertainment</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!--        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">-->
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<!--        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">-->
        <!-- materialize bootstrap -->
        <link rel="stylesheet" href="css/bootstrap-material-design.css">
        <link rel="stylesheet" href="css/ripples.min.css">
        <!-- materialize bootstrap complete-->
        
        <script src="js/jquery-1.11.1.min.js"></script> 
        
    </head>
    <body style="background:#fff;">
        <div class="header">
            <?php
            include('header.php');
            ?>
        </div>
        <!--welcome-->
        <div class="content" id="content_index_main_height">
            <div class="welcome" id="cat_page_main">
                <div class="row" id="search_button">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="form-group  label-floating" id="home_search_css">
                            <label for="i5" class="control-label">Search</label>
                            <input type="text" class="form-control input-lg" id="serachdata" onKeyUp="searcheddata(1)" style="border:none;border-bottom:1px solid #00AA9A;" />
                        </div>
                    </div>
                    <!--<div class="col-lg-2">
                      <button type="button" class="btn-raised" id="btsearch">SEARCH</button>
                    </div>-->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?php if (@$userid == '') { ?>
                            <div class="row" id="login_button_responsiveness">
                                <button type="button" id="btnblue" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" class="btn-raised">LOGIN / SIGNUP</button>
                            </div>
                        <?php } else { ?>
                            <span class="col-lg-6">
                                <p id="choose_option">Choose your Option</p>
                                <div class="dropdown login_drp" id="login_dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="drop_down_main">
                                        <?= $sel['fname'] . ' ' . $sel['lname'] ?>
<!--                                        <span class="caret" style="margin-bottom:5px;"></span>-->
                                    </button>
                                    <span class="caret" style="margin-top:10px; margin-left: 0px;"></span>
                                    <ul class="dropdown-menu login_drp_menu col-lg-12 col-md-12">
                                        <li> 
                                            <a  href="#" role="button" id="drop_li_part" data-toggle="modal" data-target="#profileModal" data-whatever="@mdo">
                                                Edit Profile
                                            </a> 
                                        </li>
                                        <li> 
                                            <a  href="#" role="button" id="drop_li_part" data-toggle="modal" data-target="#myModal" data-whatever="@fat">Change Password</a> </li>
                                        <li> <a    href="logout.php" role="button" id="drop_li_part">Logout</a> </li>
                                    </ul>
                                </div>
                            </span> 
    <!--                        <span class="col-lg-6">
                                <p id="choose_option">Choose your Category</p>
                                <div class="dropdown"  id="login_dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="drop_down_cat">Category 
                                        <span class="caret pull-right" id="drop_icon"></span></button>
                                    <ul class="dropdown-menu col-lg-12 col-md-12">

                            <?php
//                                        if (!empty($cat_list1)) {
//                                            foreach ($cat_list1 as $cat_list1) {
//                                                
                            ?>
                                                <li><a  role="button" id="drop_li_part" onClick="Cat_Post_List//<?php //echo $cat_list1['catidu']  ?>)" style="cursor:pointer;"><?php //echo $cat_list1['category'];  ?></a></li>
                                                //<?php
//                                            }
//                                        } else {
                            ?>
                                            <li id="drop_li_part">Category Not Available.</li>
                            <?php //}
                            ?>
                                    </ul>
                                </div>
                            </span> -->
                            <span class="col-lg-6">
                                <p id="choose_option">Choose your Category</p>
                                <div class="dropdown cat_drp"  id="login_dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="drop_down_cat">Category 
<!--                                        <span class="caret pull-right" id="drop_icon"></span>-->
                                    </button>
                                    <span class="caret" style="margin-top:10px;margin-left:-5px;"></span>
                                    <ul class="dropdown-menu cat_drp_menu" role="menu">

                                        <?php
                                        if (!empty($cat_list1)) {
                                            foreach ($cat_list1 as $cat_list1) {
                                                ?>
                                                <li><a  role="button" id="drop_li_part" onClick="Cat_Post_List(<?php echo $cat_list1['catidu'] ?>)" style="cursor:pointer;"><?php echo $cat_list1['category']; ?></a></li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li id="drop_li_part">Category Not Available.</li>
                                        <?php }
                                        ?>
                                    </ul>
                                </div>
                            </span>

        <!--<span id="login_user">
       <a class="btn btn-primary btn-raised btn-lg" href="#" role="button"><?= $sel['fname'] . ' ' . $sel['lname'] ?></a> 
                </span>
                <span id="logout_user">
                <a class="btn btn-primary btn-raised  btn-lg" href="logout.php" role="button" id="">Logout</a>
               </span>-->
<?php } ?>
                    </div>
                </div>

                <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row edit_profile_data" id="register_page1">
                                    <form name="register_form" method="post">
                                        <div id="reg_validation1" class="col-sm-12 col-md-12 col-lg-12 col-xs-12"></div>
                                        <div class="row">
                                            <p class="change_pass">Edit Profile</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                            <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                <input type="text" id="reg_f_name1" name="e_f_name1" value="<?php echo @$user_main_detail['fname']; ?>" placeholder="First Name" class="form-control input-lg" />
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                            <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                <input type="text" id="reg_l_name1" name="e_l_name1" value="<?php echo @$user_main_detail['lname']; ?>" placeholder="Last Name" class="form-control input-lg" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                            <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                <input type="email" id="reg_email1" name="e_email1" value="<?php echo @$user_main_detail['email']; ?>" placeholder="Email" class="form-control input-lg" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 pull-left">
                                                <button type="button"  class="form-control input-lg btn btn-danger btn-raised" onClick="login.php" data-dismiss="modal" id="reg_cancel" style="margin-left:14px;border-radius:3px;"> Cancel</button>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 pull-right" id="reg_join" onClick="edit_register_join()">
                                                <button type="button"  id="joinbtn" class="form-control input-lg btn btn-primary btn-raised" style="margin-left:-10px;border-radius:3px;">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form name-"changepassword" method="post">
                                          <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                            <div class="row">
                                                <p class="change_pass">Change password</p>
                                            </div>
                                            <div class="row" style="margin-top:25px;">
                                                <div id="errormsg"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                                    <input type="password" id="password" name="password" value="" placeholder="Old Password" class="form-control input-lg " 
                                                           style="border:none;border-bottom:1px solid #009688;" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 col-lg-12 col-md-12col-xs-12">
                                                    <input type="password" id="new_pass" name="new_pass" value="" placeholder="New Password" class="form-control input-lg " 
                                                           style="border:none;border-bottom:1px solid #009688;" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                                                    <input type="password" id="cnfrm_pass" name="cnfrm_pass" value="" placeholder="Conform Paasword" class="form-control input-lg " 
                                                           style="border:none;border-bottom:1px solid #009688;" />
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:40px;">
                                                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-12">
                                                    <button type="button"  class="form-control input-lg btn btn-danger btn-raised" onClick="login.php" data-dismiss="modal" id="reg_cancel" style="color:#fff;border-radius:3px;"> Cancel</button>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-12">
                                                    <button type="button" onClick="change_password1()" name="change_pass" id="change_pass" class="form-control input-lg btn btn-primary btn-raised" style="color:#fff;border-radius:3px;"> Change Password</button>
                                                </div>
                                            </div> 
                                        </div>      
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="search_index_post"></div>

                    <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
                <div class="row" id="content123">
                    <?php
                    if (isset($fetch_post)):
                        ?>
                        <div class="row-height">
                            <?php
                            $count = count($fetch_post);
                            for ($i = 0; $i < $count; $i++) {
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                                    <div class="inside inside-full-height">
                                        <div class="content">
                                            <div id="fix_column"> 
                                                <img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')" />
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                    <?php
                                                    if ($fetch_post[$i]['kicker'] != "") {
                                                        echo "<p id='CtaPage_cicker_span'>" . strtoupper(substr($fetch_post[$i]['kicker'], 0, 50)) . "</p>";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                    <?php echo $fetch_post[$i]['title']; ?> </div>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                    <?php
//                                                    $catid = $fetch_post[$i]['catid'];
//                                                    $catid1 = str_replace('"', "'", $catid);
//                                                    if ($catid != "") {
//                                                        $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (" . $catid . ") AND status='1' order by catid desc");
//                                                        if ($qry_cat != "") {
//                                                            echo "<p id='CatPage_Category_span'>";
//                                                            foreach ($qry_cat as $qry_cat) {
//                                                                echo $qry_cat['category'] . ",";
//                                                            }
//                                                            echo "</p>";
//                                                        }
//                                                    }
                                                    ?>
                                                </div>
                                                    <?php if (strlen($fetch_post[$i]['description']) > 400) { ?>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                        <?php
                                                        if ($fetch_post[$i]['description'] != "") {
                                                            echo "<p id='CatPage_Desc_span'>" . substr($fetch_post[$i]['description'], 0, 330) . "</p>" . "...";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $fetch_post[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"> <?php
                                                        if ($fetch_post[$i]['description'] != "") {
                                                            echo "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>";
                                                        }
                                                        ?> </div>
                                                    <?php } else { ?>
                                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                        <?php
                                                        if ($fetch_post[$i]['description'] != "") {
                                                            echo "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                <?php }
                                                ?>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <?php
                                                    if (isset($_SESSION['sessionid'])) {
                                                        $share_postid = $fetch_post[$i]['postid'];
                                                        $ids = explode(',', $fetch_post[$i]['isliked']);
                                                        $user_id = array($userid);
                                                        $l_id = array_intersect($ids, $user_id);
                                                        if (!empty($l_id)) {
                                                            ?>
                                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a> <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                                        <?php } else { ?>
                                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a> <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                        <?php
                                                        $b_id = explode(',', $fetch_post[$i]['isbookmarked']);
                                                        $b_id1 = array_intersect($b_id, $user_id);
                                                        if (!empty($b_id1)) {
                                                            ?>
                                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a> <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>
                                                        <?php } else { ?>
                                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a> <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED </a>
                                                        <?php }
                                                        ?>
            <!--                                                        <a id="share_post" data-toggle="modal" data-target="#share12" onclick="share_link(<?php //echo $share_postid;     ?>)">SHARE</a>&nbsp;&nbsp;-->
            <!--                                                    <span class="dropdown">
                                                        <button style="font-size:16px; margin-left: -15px; padding-top: 5px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php //echo $fetch_post[$i]['url'];  ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/> Facebook</a></li>
                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php //echo $fetch_post[$i]['url'];  ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/> Twitter</a> </li>
                                                        </ul>
                                                    </span>-->
                                                        <span class="dropdown dropup share_detail">
                                                            <a style="font-size:15px;border:0px; outline: none; margin-left: -6px; text-transform: uppercase; cursor: pointer;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share </a>
                                                            <ul class="dropdown-menu share_drp_menu">
                                                                <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharefb"> Share To Facebook</a></li>

                                                                <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharetwit"> Share To Twitter</a></li>
                                                            </ul>
                                                        </span>
                                                    <?php } else {
                                                        ?>
                                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp; <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp; <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                                    <?php }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (($i + 1) % 3 == 0) {
                                    ?><div class="clearfix_2"></div><?php
                                }
                                if (($i + 1) % 2 == 0) {
                                    ?>
                                    <div class="clearfix_1"></div>
                                    <?php
                                }
                                if (($i + 1) % 4 == 0) {
                                    ?>
                                    <div class="clearfix_3"></div>
                                    <?php
                                }
                                ?>
                            <?php } ?>
                        </div>
                        <?php
                    else:
                        ?>
                        <center class='notfound'><h2>No posts vailable.</h2></center>
                    <?php
                    endif;
                    ?>
                    <div id="new_div"></div>
                    <?php
                    if (isset($_SESSION['pagedata'])) {
                        if ($_SESSION['pagedata'] < $total_post_rows) {
                            ?>
                            <div class="row" id="load_more">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2" onClick="load_script_data(<?php
                                if (isset($_SESSION['Page'])) {
                                    echo ($_SESSION['Page']);
                                } else {
                                    echo "undefined";
                                }
                                ?>,<?php echo $total_post_rows; ?>)">
                                    <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php
                                    if (isset($_SESSION['page'])) {
                                        echo ($_SESSION['page'] + 1);
                                    } else {
                                        echo '1';
                                    }
                                    ?>"/>
                                    <button type="button" class="form-control input-lg btn btn-primary btn-raised" id="load_more_btn">LOAD MORE</button>
                                </div>
                                <div class="col-sm-5"></div>
                            </div>
                            <?php
                        }
                    } else if ($total_post_rows < 24) {
                        ?>
                    <?php } else { ?>
                        <div class="row" id="load_more">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-2" onClick="load_script_data(<?php
                            if (isset($_SESSION['Page'])) {
                                echo ($_SESSION['Page']);
                            } else {
                                echo "undefined";
                            }
                            ?>),<?php echo $total_post_rows; ?>">
                                <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php
                                if (isset($_SESSION['page'])) {
                                    echo ($_SESSION['page'] + 1);
                                } else {
                                    echo '1';
                                }
                                ?>"/>
                                <button type="button" class="form-control input-lg btn btn-primary btn-raised" id="load_more_btn">LOAD MORE</button>
                            </div>
                            <div class="col-sm-5"></div>
                        </div>
                    <?php }
                    ?>
                </div>  
                <div id="select_category_post">

                </div>
            </div>




        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="exTab2">
                            <ul class="nav nav-tabs" style="margin-top:-20px;">
                                <li class="active"> <a  href="#1" data-toggle="tab">Login</a> </li>
                                <li><a href="#2" data-toggle="tab">Registration</a> </li>
                                <li><a href="#3" data-toggle="tab">Forgot Password</a> </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="1">
                                    <div class="row" id="login_page">
                                        <form name="login_form" method="post" style="margin-top:-55px;">
                                            <div id="login_validation" class="col-sm-12 col-md-12 col-lg-12 col-xs-12"></div>
                                            <div class="row">
                                                <div class="col-sm-11 col-lg-11 col-md-11 col-xs-11" style="margin-left:25px;">
                                                    <input type="text" id="login_email" name="email" value="" placeholder="Email" class="form-control input-lg " />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 col-lg-11 col-md-11 col-xs-11" style="margin-left:25px;">
                                                    <input type="password" id="login_pass" name="password" value="" placeholder="Password" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 col-lg-11 col-md-11 col-xs-11" style="min-height:20px;">&nbsp;</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-11">
                                                    <input type="hidden" id="login_page_value" value=""/>
                                                    <button type="button" onClick="login_user()" name="login" id="login_button" class="form-control input-lg btn btn-primary btn-raised"> Sign in with Jake TV</button>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-11" >
                                                    <button type="button" id="login_google_button" class="form-control input-lg btn btn-danger btn-raised" value="Open Window" onclick="return popitup('http://jaketv.tv/jaketv/jaketv_website/gpluslogin/')" style=""> Sign In with g+</button>
                                                </div>
                                                <div class="col-sm-12 col-lg-1 col-md-1 col-xs-11"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="2">
                                    <div class="row" id="register_page">
                                        <form name="register_form" method="post" style="margin-top:-75px;">
                                            <div id="reg_validation" class="col-sm-12 col-md-12 col-lg-12 col-xs-12"></div>
                                            <div class="row">
                                                <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:25px;">
                                                    <input type="text" id="reg_f_name" name="f_name" value="" placeholder="First Name" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:25px;">
                                                    <input type="text" id="reg_l_name" name="l_name" value="" placeholder="Last Name" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:25px;">
                                                    <input type="email" id="reg_email" name="email" value="" placeholder="Email" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 col-lg-11 col-sm-11 col-xs-12" style="margin-left:25px;">
                                                    <input type="password" id="reg_password" name="password" value="" placeholder="Password" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:25px;">
                                                    <input type="password" id="reg_c_password" name="c_password" value="" placeholder="Confirm Password" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="min-height:35px;">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                                    <button type="button"  class="form-control input-lg btn btn-danger btn-raised" onClick="login.php" data-dismiss="modal" id="reg_cancel"> Cancel</button>
                                                </div>
                                                <!--<div class="col-md-2 col-sm-12 col-xs-12 col-lg-2"></div>-->
                                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6" id="reg_join" onClick="register_join()">
                                                    <button type="button"  id="joinbtn" class="form-control input-lg btn btn-primary btn-raised"> Join</button>
                                                </div>
                                                <div class="col-md-1 col-sm-12 col-xs-12 col-lg-1"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="3">
                                    <div class="row" id="forgotpassword">
                                        <form name="formfrpass" method="post">
                                            <div class="form-group">
                                                <div class="col-sm-12 col-lg-12">
                                                    <div id="errormsg1"></div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:20px;">
                                                <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:25px;">
                                                    <input type="email" id="fr_email" name="fr_email" value="" placeholder="Email" class="form-control input-lg" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-11 col-sm-12 col-xs-12" style="min-height:35px;">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                                    <button type="button"  class="form-control input-lg btn btn-danger btn-raised" onClick="login.php" id="fr_cancel" style="margin-left:10px;border-radius:3px;font-size:14px; color:#fff; outline:none;" data-dismiss="modal"> Cancel</button>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6" id="reg_join" onClick="register_join()">
                                                    <button type="button"  id="frbtn" class="form-control input-lg btn btn-primary btn-raised btnmargn"  onclick="forgot_password()" style="margin-left:-12px;border-radius:3px;font-size:14px; color:#fff; outline:none;"> Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-section" id="footerhr">
            <div class="footer-top">
                <p>&copy; 2015 JAKE TV. All rights reserved</p>
            </div>
        </div>
<!--        <div class="modal fade" id="share12" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-567638a77cf41b9c" async></script>
                        <div id="share_link"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>-->
        
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> 
        
        <script src="js/bootstrap.js"></script> 
         
<!--        <script src="js/ripples.min.js"></script>-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script> 
        <script src="js/material.min.js"></script>
        <script type="text/javascript">
                                                        function popitup(url) {
                                                            newwindow = window.open(url, 'name', 'height=300,width=300, location=0');
                                                            if (window.focus) {
                                                                newwindow.focus()
                                                            }
                                                            return false;
                                                        }
        </script>
        <script>
            function description_length()
            {
                var yourString = $("#desc").text();
                var stripped = yourString.substr(0, 10);
                var abc = stripped.length;
            }
        </script> 
        <script>


            $('#login').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                var modal = $(this)
                modal.find('.modal-title').text('New message to ' + recipient)
                modal.find('.modal-body input').val(recipient)
            });

            $(document).ready(function (e) {
                $("#login_detail").click(function (e) {
                    $("#register_page").hide();
                    $("#login_page").show();
                    $("#login_detail").css("color", "#185BAE");
                    $("#register").css("color", "#333");
                });

                $("#register").click(function (e) {
                    $("#register_page").show();
                    $("#login_page").hide();
                    $("#login_detail").css("color", "#333");
                    $("#register").css("color", "#185BAE");
                });
                $("#viewmore").click(function (e) {
                    $("#moredesc").show();
                    $("#viewless").show();
                    $('.post_desc').css('heigth', '900px');
                });
                $("#viewless").click(function (e) {
                    $("#moredesc").hide();
                    $("#desc").show();
                    $("#viewless").hide();
                });


                /*$("#like").click(function(){
                 $(this).addClass("activclass");
                 $("#bookmark").removeClass("activclass");
                 $("#home").removeClass("activclass");
                 $("#catgry").removeClass("activclass");
                 });
                 
                 $("#bookmark").click(function(){
                 $(this).addClass("activclass");
                 $("#like").removeClass("activclass");
                 $("#home").removeClass("activclass");
                 $("#catgry").removeClass("activclass");
                 });
                 $("#catgry").click(function(){
                 $(this).addClass("activclass");
                 $("#like").removeClass("activclass");
                 $("#home").removeClass("activclass");
                 $("#bookmark").removeClass("activclass");
                 });*/

            });
        </script> 
        <script>
            $(document).ready(function (e) {

                var screen = $(window).width();
                document.cookie = "screen_res=" + screen;
                if ($(window).width() > 1400)
                {
                    $('.col-lg-4').each(function () {
                        $(this).removeClass('col-lg-4').addClass('col-lg-3');
                    });
                }

                if ($(window).width() > 1600 && $(window).width() < 1700)
                {
                    $("#con").css('width', '85%');
                } else if ($(window).width() > 1700 && $(window).width() < 1800) {
                    $("#con").css('width', '90%');
                } else if ($(window).width() > 1800 && $(window).width() < 1900) {
                    $("#con").css('width', '90%');
                } else if ($(window).width() > 1900) {
                    $("#con").css('width', '90%');
                } else {
                    $("#con").css('width', '90%');
                }
            });

            $(document).ready(function (e) {

                var screen = $(window).width();
                document.cookie = "screen_res=" + screen;
                if ($(window).width() > 1400)
                {
                    $('.col-lg-4').each(function () {
                        $(this).removeClass('col-lg-4').addClass('col-lg-3');
                    });
                }

                if ($(window).width() > 1600 && $(window).width() < 1700)
                {
                    $("#con").css('width', '85%');
                } else if ($(window).width() > 1700 && $(window).width() < 1800) {
                    $("#con").css('width', '90%');
                } else if ($(window).width() > 1800 && $(window).width() < 1900) {
                    $("#con").css('width', '90%');
                } else if ($(window).width() > 1900) {
                    $("#con").css('width', '90%');
                } else {
                    $("#con").css('width', '90%');
                }
            });



            function forgot_password()
            {
                var email = $("#fr_email").val();
                if ($("#fr_email").val() == "")
                {
                    $("#errormsg1").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>");
                    setTimeout(function () {
                        document.getElementById("errormsg1").innerHTML = '';
                        document.getElementById('email').focus();
                    }, 5000);
                }
                else
                {
                    $.ajax({
                        url: 'service.php',
                        type: 'post',
                        data: 'forgotpassword=1&fr_email=' + email,
                        success: function (data)
                        {
                            if (data == '1') {
                                document.getElementById('errormsg1').innerHTML = "<div class='alert alert-success' role='alert' style='font-size:16px;letter-spacing:1px;'>Check Your mail to reset pasword.</div>";
                            } else {
                                document.getElementById('errormsg1').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Invalid Email id.</div>";
                            }
                        }
                    });
                }
            }

        </script> 
        <script>
            $(document).ready(function(e){
                $(function () {
                $.material.init();
                $(".shor").noUiSlider({
                    start: 40,
                    connect: "lower",
                    range: {
                        min: 0,
                        max: 100
                    }
                });

                $(".svert").noUiSlider({
                    orientation: "vertical",
                    start: 40,
                    connect: "lower",
                    range: {
                        min: 0,
                        max: 100
                    }
                });
            });
            });
            
        </script>
    </body>
</html>
