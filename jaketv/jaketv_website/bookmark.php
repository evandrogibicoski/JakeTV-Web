<?php
include('service.php');
include('secure/customjs.php');
//include('secure/config.php');

if (isset($_SESSION['sessionid'])) {




    $obj = new service_class();


    $sessid = $_SESSION['sessionid'];

    if (isset($sessid)) {
        $sel = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='" . $sessid . "'");
        $userid = $sel['userid'];
    }
    if (isset($_SESSION['sessionid'])) {
        $user_main_detail = $obj->qry_fetchRow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");
    }

    if (isset($userid)) {
        $alldata = array();
        $responsedata = array();
        $qry0 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' AND publish='1' ORDER BY `cr_date` DESC");
        foreach ($qry0 as $qry0_data) {
            $checkin = explode(',', $qry0_data["isbookmarked"]);
            if (in_array($userid, $checkin)) {
                $qry_cat = $obj->qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='" . $qry0_data["catid"] . "'");
                $qry_subcat = $obj->qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='" . $qry0_data["subcatid"] . "'");

                $alldata["postid"] = $qry0_data["postid"];
                $alldata["title"] = $qry0_data["title"];
                $alldata["catuniqueid"] = $qry0_data["catid"];
                $alldata["category"] = $qry_cat["category"];
                $alldata["subcatuniqueid"] = $qry0_data["subcatid"];
                $alldata["subcategory"] = $qry_subcat["subcategory"];
                $alldata["image"] = $qry0_data["image"];
                $alldata["url"] = $qry0_data["url"];
                $alldata["kickerline"] = $qry0_data["kicker"];
                $alldata["source"] = $qry0_data["source"];
                $alldata["description"] = $qry0_data["description"];
                $alldata["totalpostlikes"] = $qry0_data["totalpostlikes"];
                $book = explode(',', $qry0_data['isbookmarked']);
                if (in_array($userid, $book)) {
                    $alldata['isbookmarked'] = '1';
                } else {
                    $alldata['isbookmarked'] = '0';
                }
                $like = explode(',', $qry0_data['isliked']);
                if (in_array($userid, $like)) {
                    $alldata['isliked'] = '1';
                } else {
                    $alldata['isliked'] = '0';
                }
                $alldata["cr_date"] = $qry0_data["cr_date"];
                $responsedata[] = $alldata;
            }
        }
        $total_bookmark_rows = count($responsedata);
        if ($responsedata != NULL) {
            if (!empty($_SESSION['bookmark_pagedata'])) {
                @$PageLimit = $_SESSION['bookmark_pagedata'];
            } else {
                @$PageLimit = "24";
                //$_SESSION['pagedata'] = $PageLimit;
            }

            @$numtotal = count(@$responsedata);
            @$totalpage = round(@$numtotal / @$PageLimit);
            if ($totalpage == 0) {
                $totalpage = 1;
            } else {
                $totalpage = $totalpage;
            }
            @$response = array();
            if (@$Page == 0) {
                @$offset = @$Page;
            } else {
                @$offset = (@$Page * @$PageLimit);
            }


            for (@$i = 0; @$i < @$PageLimit; @$i++) {
                if (@$i == 0) {
                    @$array_ind = @$i + @$offset;
                } else {
                    @$array_ind = @$i + @$offset;
                }

                if (@$responsedata[@$array_ind] != '') {
                    if (empty($response)) {
                        @$fetch_post[] = @$responsedata[@$array_ind];
                    } else if (!in_array(@$responsedata[@$array_ind], @$response)) {
                        @$fetch_post[] = @$responsedata[@$array_ind];
                    }
                }
            }
            //$response = array_unique(@$response);
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
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=utf8_unicode_ci" />
            <meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
                  Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
            <title>Jake TV • Jewish Arts Knowledge Entertainment</title>
            <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
            <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
            <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
            <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
            <!-- materialize bootstrap -->
            <link rel="stylesheet" href="css/bootstrap-material-design.css">
            <link rel="stylesheet" href="css/ripples.min.css">
            <!-- materialize bootstrap complete-->
            

        </head>
        <body>
            <div class="header">
                <?php
                include('header.php');
                ?>
            </div>

            <!--welcome-->
            <div class="content" id="content_index_main_height">
                <div class="welcome" id="cat_page_main"> 
                    <!--<div class="container">-->

                    <div class="row" id="content_likes" style="margin-left: 0px; margin-right: 0px;">
                        <div class="row" id="search_button">

                            <div class="col-lg-8">
                                <div class="form-group  label-floating" id="home_search_css">
                                    <label for="i5" class="control-label">Search</label>
                                    <input type="text" class="form-control input-lg" id="serachdata" onKeyUp="searcheddata(3)" style="border:none;border-bottom:1px solid #00AA9A;" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <span class="col-lg-6">
                                    <p id="choose_option">Choose your Option</p>
                                    <div class="dropdown login_drp" id="login_dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="drop_down_main">
                                            <?= $sel['fname'] . ' ' . $sel['lname'] ?><span class="caret" style="margin-bottom:5px;"></span>
                                        </button>
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
                                <span class="col-lg-6">
                                    <p id="choose_option">Choose your Category</p>
                                    <div class="dropdown cat_drp"  id="login_dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="drop_down_cat">Category 
                                            <span class="caret pull-right" id="drop_icon"></span></button>
                                        <ul class="dropdown-menu cat_drp_menu" role="menu">

                                            <?php
                                            if (!empty($cat_list1)) {
                                                foreach ($cat_list1 as $cat_list1) {
                                                    ?>
                                                    <li><a  role="button" id="drop_li_part" onClick="Cat_Post_List2(<?php echo $cat_list1['catidu'] ?>)" style="cursor:pointer;"><?php echo $cat_list1['category']; ?></a></li>
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
                            </div>
                            <!-- <div class="col-lg-2">
                                   <button type="button" class="btn-raised" id="btsearch">SEARCH</button>
                               </div>-->

                        </div>
                        <!--<div class="row">
                                <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <h3 align="center" style="font-size:30px;">Bookmarked Post</h3>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br><br>-->

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
                                                <div id="reg_validation" class="col-sm-12 col-md-12 col-lg-12 col-xs-12"></div>
                                                <div class="row">
                                                    <p class="change_pass">Edit Profile</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                                    <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                        <input type="text" id="reg_f_name" name="e_f_name" value="<?php echo $user_main_detail['fname']; ?>" placeholder="First Name" class="form-control input-lg" />
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                                    <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                        <input type="text" id="reg_l_name" name="e_l_name" value="<?php echo $user_main_detail['lname']; ?>" placeholder="Last Name" class="form-control input-lg" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12"></div>
                                                    <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" style="margin-left:-10px;">
                                                        <input type="email" id="reg_email" name="e_email" value="<?php echo $user_main_detail['email']; ?>" placeholder="Email" class="form-control input-lg" />
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

                        <div class="search_bookmark_post"></div>

                        <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
                        <div class="row content123_bookmark">
                            <?php
                            if (isset($fetch_post)):
                                ?>
                                <div class="row-height">
                                    <?php
                                    if (isset($fetch_post)):
                                        $count = count($fetch_post);
                                        for ($i = 0; $i < $count; $i++) {
                                            ?>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                                                <div class="inside inside-full-height">
                                                    <div class="content">
                                                        <div id="fix_column">
                                                            <img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')" style="cursor:pointer;" style="cursor:pointer;"/>
                                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                                <?php
                                                                if ($fetch_post[$i]['kickerline'] != "") {
                                                                    echo "<p id='CtaPage_cicker_span'>" . strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50)) . "</p>";
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                                <?php echo $fetch_post[$i]['title']; ?> 
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"> 
                                                                <?php
                                                                $catid = $fetch_post[$i]['catuniqueid'];
                                                                $catid1 = str_replace('"', "'", $catid);
                                                                if ($catid != "") {
                                                                    $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (" . $catid . ") AND status='1' order by catid desc");
                                                                    if ($qry_cat != "") {
                                                                        echo "<p id='CatPage_Category_span'>";
                                                                        foreach ($qry_cat as $qry_cat) {
                                                                            echo $qry_cat['category'] . ",";
                                                                        }
                                                                        echo "</p>";
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php if (strlen($fetch_post[$i]['description']) > 400) { ?>
                                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">

                                                                    <?php
                                                                    if ($fetch_post[$i]['description'] != "") {
                                                                        echo "<p id='CatPage_Desc_span'>" . substr($fetch_post[$i]['description'], 0, 330) . "</p>";
                                                                    }
                                                                    ?><?php echo "..."; ?>

                                                                </div>
                                                                <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $fetch_post[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
                                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                                                    <?php
                                                                    if ($fetch_post[$i]['description'] != "") {
                                                                        echo "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <!--<div id="back<?php //echo $fetch_post['postid']           ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>";           ?></div>-->
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

                                                                    if ($fetch_post[$i]['isliked'] == 1) {
                                                                        ?>
                                                                        <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                                                        <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                                                    <?php } else { ?>
                                                                        <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                                                        <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                                                    <?php } ?>
                                                                    <?php if ($fetch_post[$i]['isbookmarked'] == 1) { ?>
                                                                        <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                                                        <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                                                    <?php } else { ?>
                                                                        <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                                                        <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                                                    <?php }
                                                                    ?>
                                                                    <!--                                                                <a id="share_post">SHARE</a>&nbsp;&nbsp;-->
                    <!--                                                                <span class="dropdown">
                                                                        <button style="font-size:16px; margin-left: -15px; padding:0px 0px 1px 15px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php //echo $fetch_post[$i]['url'];   ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/> Facebook</a></li>
                                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php //echo $fetch_post[$i]['url'];   ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/> Twitter</a> </li>
                                                                        </ul>
                                                                    </span>-->
                                                                    <span class="dropdown dropup share_detail">
                                                                        <a style="font-size:15px;border:0px; outline: none; margin-left: -25px; text-transform: uppercase; cursor: pointer;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share </a>
                                                                        <ul class="dropdown-menu share_drp_menu">
                                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharefb"> Share To Facebook</a></li>

                                                                            <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharetwit"> Share To Twitter</a></li>
                                                                        </ul>
                                                                    </span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                                                    <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                                                    <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                                                <?php }
                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($screen_resolution < 1600) {
                                                if (($i + 1) % 3 == 0) {
                                                    ?><div class="clearfix visible-lg"></div><?php
                                                }
                                            } else {
                                                if (($i + 1) % 4 == 0) {
                                                    ?><div class="clearfix visible-lg"></div><?php
                                                }
                                            }
                                            ?>
                                            <?php
                                        }
                                    else:
                                        ?>
                                        <p>No records found.</p>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                                <?php
                            else:
                                ?>
                                <center class='notfound'><h2>No posts available.</h2></center>
                            <?php
                            endif;
                            ?>
                            <div id="bookmark_new_div"></div>
                            <?php
                            if (isset($_SESSION['bookmark_pagedata'])) {
                                if ($_SESSION['bookmark_pagedata'] < $total_bookmark_rows) {
                                    ?>
                                    <div class="row" id="load_more">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-2" onClick="load_bookmark_page1(<?php
                                        if (isset($_SESSION['bookmark_page'])) {
                                            echo ($_SESSION['bookmark_page']);
                                        }
                                        ?>)">
                                            <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php
                                            if (isset($_SESSION['bookmark_page'])) {
                                                echo ($_SESSION['bookmark_page'] + 1);
                                            } else {
                                                echo '1';
                                            }
                                            ?>"/>
                                            <button type="button" class="form-control input-lg btn  btn-primary btn-raised" id="load_more_btn">LOAD MORE</button>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                    <?php
                                }
                            } else if (@$total_bookmark_rows < 24) {
                                ?>

                            <?php } else { ?>
                                <div class="row" id="load_more">
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-2" onClick="load_bookmark_page1(<?php
                                    if (isset($_SESSION['bookmark_page'])) {
                                        echo ($_SESSION['bookmark_page']);
                                    }
                                    ?>)">
                                        <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php
                                        if (isset($_SESSION['bookmark_page'])) {
                                            echo ($_SESSION['bookmark_page'] + 1);
                                        } else {
                                            echo '1';
                                        }
                                        ?>"/>
                                        <button type="button" class="form-control input-lg btn  btn-primary btn-raised" id="load_more_btn">LOAD MORE</button>
                                    </div>
                                    <div class="col-sm-5"></div>
                                </div>
                            <?php }
                            ?>
                        </div>
                        <div id="select_category_post2">

                </div>
                    </div>
                </div>
                
            </div>


            <div class="footer-section" id="footerhr">
                <div class="footer-top">
                    <p>&copy; 2015 JAKE TV. All rights reserved</p>
                </div>
            </div>
            <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/bootstrap.js"></script>
            <script src="js/material.min.js"></script> 
    <!--            <script src="js/ripples.min.js"></script>-->
            <script>
                                    $(document).ready(function (e) {

                                        var screen = $(window).width();
                                        document.cookie = "screen_res=" + screen;
                                        if ($(window).width() > 1600)
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
            </script> 
        </body>
    </html>
    <?php
} else {
    header('location: index.php');
}
?>