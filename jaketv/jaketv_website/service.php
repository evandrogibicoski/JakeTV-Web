<?php
include('secure/config.php');
//include('secure/customjs.php');

$obj = new service_class();

if (isset($_POST['share_url'])) {
    $postid = $_POST['postid'];
    $url_detail = $obj->qry_fetchRow("select url from tbl_post where postid='" . $postid . "'");
    echo $url = $url_detail['url'];
}


if (isset($_REQUEST['cat_post_list'])) {

    $sel = $obj->qry_fetchRow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");
    $userid = $sel['userid'];

    $catid = $_REQUEST['catid'];

    $PageLimit = 6;

    $post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE FIND_IN_SET('$catid',catid) AND status='1' AND publish='1' ORDER BY postid DESC");
    $post_list = $obj->qry_fetchrows("SELECT * FROM tbl_post WHERE FIND_IN_SET('$catid',catid) AND status='1' AND publish='1' ORDER BY postid DESC LIMIT $PageLimit");
    if (!empty($post_list)) {
        $post_list = $post_list;
    } else {
        $post_list = array();
    }
    $total_post_rows = $post_rows;

    if (!empty($post_list)) {
        ?>


        <div class="row" id="content_cat_post_list">
            <div>
                <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
                <div class="row-height">
                    <?php
                    if (isset($post_list)):
                        $count = count($post_list);
                        for ($i = 0; $i < $count; $i++) {
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                                <div class="inside inside-full-height">
                                    <div class="content">
                                        <div id="fix_column"> <img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')" />
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')">
                                                <?php
                                                if ($post_list[$i]['kicker'] != "") {
                                                    echo "<p id='CtaPage_cicker_span'>" . strtoupper(substr($post_list[$i]['kicker'], 0, 50)) . "</p>";
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')">
                                                <?php echo $post_list[$i]['title']; ?> </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')">
                                                <?php
                                                $catid = $post_list[$i]['catid'];
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
                                            <?php if (strlen($post_list[$i]['description']) > 400) { ?>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')">
                                                    <?php
                                                    if ($post_list[$i]['description'] != "") {
                                                        echo "<p id='CatPage_Desc_span'>" . substr($post_list[$i]['description'], 0, 330) . "</p>";
                                                    }
                                                    ?>
                                                    <?php echo "..."; ?> </div>
                                                <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $post_list[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')"> <?php
                                                    if ($post_list[$i]['description'] != "") {
                                                        echo "<p id='CatPage_Desc_span'>" . $post_list[$i]['description'] . "</p>";
                                                    }
                                                    ?> </div>
                                            <?php } else { ?>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>', '_blank')">
                                                    <?php
                                                    if ($post_list[$i]['description'] != "") {
                                                        echo "<p id='CatPage_Desc_span'>" . $post_list[$i]['description'] . "</p>";
                                                    }
                                                    ?>
                                                </div>
                                            <?php }
                                            ?>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                            <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                                <?php
                                                if (isset($_SESSION['sessionid'])) {
                                                    $ids = explode(',', $post_list[$i]['isliked']);
                                                    $user_id = array($userid);
                                                    $l_id = array_intersect($ids, $user_id);
                                                    if (!empty($l_id)) {
                                                        ?>
                                                        <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">LIKED</a> <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                                    <?php } else { ?>
                                                        <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a> <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                                    <?php } ?>
                                                    <?php
                                                    $b_id = explode(',', $post_list[$i]['isbookmarked']);
                                                    $b_id1 = array_intersect($b_id, $user_id);
                                                    if (!empty($b_id1)) {
                                                        ?>
                                                        <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">BOOKMARKED</a> <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                                    <?php } else { ?>
                                                        <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a> <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARKED </a>&nbsp;&nbsp;
                                                    <?php }
                                                    ?>
                    <!--                                                    <span class="dropdown">
                                                <button style="font-size:16px; margin-left: -31px; padding-top: 5px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
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
                            if (@$screen_resolution < 1600) {
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
                <div class="CatPost_New_Div"></div>
            </div>   



        </div>
        <?php
    }else {
        
    }
    echo '2';
}


if (isset($_POST['load_value_data'])) {
    $Page = $_POST['load_value_data'];

    $PageLimit = 24;
    $Offset = $Page * $PageLimit;
    $pagedata = ($Page + 1) * $PageLimit;

    $qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
    foreach ($qry02 as $qry) {
        $id = $qry['catidu'];
        $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' AND publish='1' order by sort_order asc");
        $dd[] = $qry021;
    }

    foreach ($dd as $v1) {
        if (is_array($v1)) {
            foreach ($v1 as $v2) {
                $newArray[] = $v2;
            }
        }
    }
    foreach ($newArray as $newArray) {
        $post_id[] = $newArray['postid'];
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
        if (!empty($user_catid)) {
            for ($i = 0; $i < count($user_catid); $i++) {
                $id = $user_catid[$i];
                $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' AND publish='1' order by sort_order asc");
                $user_cat_post[] = $qry021;
            }
            foreach ($user_cat_post as $v1) {
                if (is_array($v1)) {
                    foreach ($v1 as $v2) {
                        $user_post_array[] = $v2;
                    }
                }
            }
            foreach ($user_post_array as $user_post_array) {
                $user_post_id[] = $user_post_array['postid'];
            }
            $user_post_id1 = array_unique($user_post_id);
            foreach ($user_post_id1 as $k => $v) {
                $user_post_id2[] = $v;
            }
        } else {
            $user_post_id2 = array();
        }

        $all_post_id = array_merge($user_post_id2, $post_id);
        $all_post_id1 = array_unique($all_post_id);
        foreach ($all_post_id1 as $k => $val) {
            if ($val != "") {
                $all_post_id2[] = $val;
            }
        }
        $d = implode(',', $all_post_id2);
        $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (" . $d . ") order by sort_order asc LIMIT $Offset,$PageLimit");
    } else {
        $d = implode(',', $post_id);
        $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (" . $d . ") order by sort_order asc LIMIT  $Offset,$PageLimit");
    }

    if ($fetch_post != 0) {
        $_SESSION['pagedata'] = $pagedata;
        $_SESSION['page'] = $Page;
        ?>
        <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
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
                                        $catid = $fetch_post[$i]['catid'];
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
                                            ?>
                                            <?php echo "..."; ?> </div>
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
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a> <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a> <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED </a>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                    <!--                                            <span class="dropdown">
                                        <button style="font-size:16px; margin-left: -31px; padding-top: 5px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
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
                    if (@$screen_resolution < 1600) {
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
    }else {
        echo '2';
    }
}

if (isset($_POST['likes_load_value_data'])) {
    $Page = $_POST['likes_load_value_data'];

    @$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='" . $_SESSION['sessionid'] . "'");
    $userid = $user_data['userid'];

    $alldata = array();
    $responsedata = array();
    $qry0 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' AND publish='1' ORDER BY `cr_date` DESC");
    foreach ($qry0 as $qry0_data) {
        $checkin = explode(',', $qry0_data["isliked"]);
        $index = array_search($userid, $checkin);
        if ($index !== false) {
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

    if ($responsedata != NULL) {
        /* if(!empty($_SESSION['likes_pagedata'])){
          $PageLimit =  $_SESSION['likes_pagedata'];
          }else{
          @$PageLimit = "6";
          //$_SESSION['pagedata'] = $PageLimit;
          } */

        @$PageLimit = 24;
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
            //$likes_pagedata = ($Page+1)*$PageLimit;
            //$_SESSION['likes_pagedata'] = $likes_pagedata;
            //$_SESSION['likes_page'] = $Page;	
        }

        for (@$i = 0; @$i < @$PageLimit; @$i++) {
            if (@$i == 0) {
                @$array_ind = @$i + @$offset;
            } else {
                @$array_ind = @$i + @$offset;
            }

            //echo $array_ind;


            if (@$responsedata[@$array_ind] != '') {
                if (empty($response)) {
                    @$fetch_post[] = @$responsedata[@$array_ind];
                } else if (!in_array(@$responsedata[@$array_ind], @$response)) {
                    @$fetch_post[] = @$responsedata[@$array_ind];
                }
            }
        }
    }

    if (!empty($fetch_post)) {

        $PageLimit_temporary = 24;
        $likes_pagedata = ($Page + 1) * $PageLimit_temporary;
        $_SESSION['likes_pagedata'] = $likes_pagedata;
        $_SESSION['likes_page'] = $Page;
        ?>
        <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
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
                                                <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                            <?php } ?>
                                            <?php if ($fetch_post[$i]['isbookmarked'] == 1) { ?>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                                <?php
                                            }
                                            ?>
                    <!--                                            <span class="dropdown">
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
                    if (@$screen_resolution < 1600) {
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
    }
    else {
        echo '2';
    }
}

if (isset($_POST['bookmark_load_value_data'])) {
    $Page = $_POST['bookmark_load_value_data'];

    @$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='" . $_SESSION['sessionid'] . "'");
    $userid = $user_data['userid'];

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
    if ($responsedata != NULL) {
        @$PageLimit = 24;
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

    if (!empty($fetch_post)) {
        $PageLimit_temporary = 24;
        $likes_pagedata = ($Page + 1) * $PageLimit_temporary;
        $_SESSION['bookmark_pagedata'] = $likes_pagedata;
        $_SESSION['bookmark_page'] = $Page;
        ?>
        <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
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
                                        <!--<div id="back<?php //echo $fetch_post['postid']                   ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>";                   ?></div>-->
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
                                                <?php
                                            }
                                            ?>
                    <!--                                            <span class="dropdown">
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
                    if (@$screen_resolution < 1600) {
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
    }else {
        echo '2';
    }
}


if (isset($_POST['sel_categroy'])) {
    if ($_POST['flag'] == 1) {
        $query = "UPDATE `tbl_category` SET `selected`=0 WHERE `catidu`=" . $_POST['catid'];
    } else {
        $query = "UPDATE `tbl_category` SET `selected`=1 WHERE `catidu`=" . $_POST['catid'];
    }
    $runqry = $obj->qry_runQuery($query);
    echo "1";
}

if (isset($_POST['register'])) {
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $c_pass = $_POST['c_password'];

    $password = hash('sha512', $pass);
    $sessionid = hash('sha512', strtotime(date('Y-m-d H:i:s')) + rand(0, 500) + rand(500, 1000));

    $cr_date = date('Y-m-d H:i:s');
    $modify_data = date('Y-m-d H:i:s');

    $select = $obj->qry_fetchRows("SELECT * FROM `tbl_user` WHERE `email`='" . $email . "'");


    if ($select == "0") {
        $ins = "insert into tbl_user(`fname`,`lname`,`email`,`password`,`status`,`cr_date`,`modify_date`,`sessid`) values('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','1','" . $cr_date . "','" . $modify_data . "','" . $sessionid . "')";
        $result = $obj->qry_insertedId($ins);
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    } else {
        echo '2';
    }
}

if (isset($_POST['update_register'])) {
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];

    $update = $obj->qry_runQuery("update tbl_user set fname='$fname', lname='$lname', email='$email' where sessid='" . $_SESSION['sessionid'] . "'");
    if ($update) {
        echo '1';
    } else {
        echo '2';
    }
}

if (isset($_POST['update_change_password'])) {
    $oldpass = hash('sha512', $_POST['password']);
    $newpass = hash('sha512', $_POST['newpass']);

    $sel_pass = $obj->qry_fetchRow("select userid from tbl_user where password='$oldpass' and sessid='" . $_SESSION['sessionid'] . "'");
    if (!empty($sel_pass)) {
        $update_pass = $obj->qry_runQuery("update tbl_user set password='$newpass' where password='$oldpass' and sessid='" . $_SESSION['sessionid'] . "'");
        if ($update_pass) {
            echo '1';
        } else {
            echo '0';
        }
    } else {
        echo '2';
    }
}


if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $pass = hash('sha512', $password);
    $sessionid = hash('sha512', strtotime(date('Y-m-d H:i:s')) + rand(0, 500) + rand(500, 1000));

    $select = $obj->qry_fetchRows("select * from tbl_user where email='" . $email . "' and password='" . $pass . "'");

    if ($select != 0) {

        $update = $obj->qry_runQuery("update tbl_user set sessid='" . $sessionid . "' where email='" . $email . "' and password='" . $pass . "'");
        if ($update) {
            $_SESSION['sessionid'] = $sessionid;
            echo '1';
        } else {
            echo '2';
        }
    } else {
        echo '0';
    }
}


if (isset($_POST['like_post'])) {
    $postid = $_POST['postid'];

    $sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");

    $userid = $sel['userid'];

    if (isset($userid)) {
        $qry0 = $obj->qry_fetchRow("SELECT * FROM tbl_post WHERE postid='" . $postid . "'");
        if ($qry0["isliked"] != "") {
            $isliked = $qry0["isliked"] . ',' . $userid;
            $update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='" . $isliked . "' WHERE `postid`='" . $postid . "'");
            $exp_isliked = explode(',', $isliked);
            $totallikes = count($exp_isliked);
            $update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='" . $totallikes . "' WHERE `postid`='" . $postid . "'");
            if ($update_totallikes) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $isliked = $userid;
            $update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='" . $isliked . "' WHERE `postid`='" . $postid . "'");
            $exp_isliked = explode(',', $isliked);
            $totallikes = count($exp_isliked);
            $update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='" . $totallikes . "' WHERE `postid`='" . $postid . "'");
            if ($update_totallikes) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}

if (isset($_POST['unlike_post'])) {
    $postid = $_POST['postid'];

    $sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");

    $userid = $sel['userid'];

    if (isset($userid)) {
        $qry0 = $obj->qry_fetchRow("SELECT * FROM tbl_post WHERE postid='" . $postid . "'");
        if ($qry0["isliked"] != "") {
            $checkin = explode(',', $qry0["isliked"]);
            $index = array_search($userid, $checkin);
            if ($index !== false) {
                unset($checkin[$index]);
            }
            $totallikes = count($checkin);
            $isliked = implode(',', $checkin);
            $update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='" . $isliked . "' WHERE `postid`='" . $postid . "'");
            $update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='" . $totallikes . "' WHERE `postid`='" . $postid . "'");
            if ($update_totallikes) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}


if (isset($_POST['bookmark_post'])) {
    $postid = $_POST['postid'];

    $sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");

    $userid = $sel['userid'];

    if (isset($userid)) {
        $qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='" . $postid . "'");
        if ($qry0["isbookmarked"] != "") {
            $isbookmarked = $qry0["isbookmarked"] . ',' . $userid;
            $update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='" . $isbookmarked . "' WHERE `postid`='" . $postid . "'");
            if ($update_isbookmarked) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $isbookmarked = $userid;
            $update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='" . $isbookmarked . "' WHERE `postid`='" . $postid . "'");
            if ($update_isbookmarked) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}


if (isset($_POST['unbookmark_post'])) {
    $postid = $_POST['postid'];

    $sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");

    $userid = $sel['userid'];

    if (isset($userid)) {
        $qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='" . $postid . "'");
        if ($qry0["isbookmarked"] != "") {
            $checkin = explode(',', $qry0["isbookmarked"]);
            $index = array_search($userid, $checkin);
            if ($index !== false) {
                unset($checkin[$index]);
            }
            $isbookmarked = implode(',', $checkin);
            $update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='" . $isbookmarked . "' WHERE `postid`='" . $postid . "'");
            if ($update_isbookmarked) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'search') {
    $method = $_GET['method'];

    if ($method == "index_searcheddata") {

        @$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='" . $_SESSION['sessionid'] . "'");
        $userid = $user_data['userid'];
        $search_data = $_GET['data'];
        $fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE title LIKE '%" . $_GET['data'] . "%'");
        if ($fetch_post != 0) {
            ?>
            <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
            <div class="row-height">
                <?php
                $count = count($fetch_post);
                for ($i = 0; $i < $count; $i++) {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                        <div class="inside inside-full-height">
                            <div class="content">
                                <div id="fix_column">
                                    <img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php
                                        if ($fetch_post[$i]['kicker'] != "") {
                                            echo "<p id='CtaPage_cicker_span'>" . strtoupper(substr($fetch_post[$i]['kicker'], 0, 50)) . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $fetch_post[$i]['title']); ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"> 
                                        <?php
                                        $catid = $fetch_post[$i]['catid'];
                                        $catid1 = str_replace('"', "'", $catid);
                                        if ($catid != "") {
                                            $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (" . $catid . ") AND status='1' order by catid desc");
                                            if ($qry_cat != "") {
                                                echo "<p id='CatPage_Category_span'>";
                                                foreach ($qry_cat as $qry_cat) {
                                                    echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $qry_cat['category'] . ",");
                                                }
                                                echo "</p>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php if (strlen($fetch_post[$i]['description']) > 400) { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')" style="cursor:pointer;">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . substr($fetch_post[$i]['description'], 0, 330) . "</p>");
                                            }
                                            ?><?php echo "..."; ?>

                                        </div>
                                        <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $fetch_post[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                        <!--<div id="back<?php //echo $fetch_post['postid']              ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>";              ?></div>-->
                                    <?php } else { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid']; ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if (isset($_SESSION['sessionid'])) {
                                            $ids = explode(',', $fetch_post[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids, $user_id);
                                            if (!empty($l_id)) {
                                                ?>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?>



                                            <?php
                                            $b_id = explode(',', $fetch_post[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id, $user_id);
                                            if (!empty($b_id1)) {
                                                ?>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                    <!--                                         <span class="dropdown">
                    <button style="font-size:16px; margin-left: -15px; padding:0px 0px 1px 15px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php //echo $fetch_post[$i]['url'];               ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/> Facebook</a></li>
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php //echo $fetch_post[$i]['url'];                ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/> Twitter</a> </li>
                    </ul>
                    </span>-->
                                            <span class="dropdown dropup share_detail">
                                                <a style="font-size:15px;border:0px; outline: none; margin-left: -25px; text-transform: uppercase; cursor: pointer;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share </a>
                                                <ul class="dropdown-menu share_drp_menu">
                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharefb"> Share To Facebook</a></li>

                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharetwit"> Share To Twitter</a></li>
                                                </ul>
                                            </span>
                                        <?php } else {
                                            ?>
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (@$screen_resolution < 1600 && $screen_resolution > 1200) {
                        if (($i + 1) % 3 == 0) {
                            ?><div class="clearfix visible-lg"></div><?php
                        }
                    } else if (@$screen_resolution < 1200) {
                        if (($i + 1) % 2 == 0) {
                            ?>
                            <div class="clearfix visible-md visible-sm visible-xs"></div>
                            <?php
                        }
                    } else {
                        if (($i + 1) % 4 == 0) {
                            ?><div class="clearfix visible-lg"></div><?php
                        }
                    }
                    ?>
                <?php } ?>
            </div>
            <?php
        } else {
            echo '2';
        }
    } else if ($method == "likes_searcheddata") {
        $user_detail = $obj->qry_fetchrow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");
        $userid = $user_detail['userid'];
        $search_data = $_GET['data'];
        $fetch_post = $obj->qry_fetchrows("select * from tbl_post where find_in_set($userid,isliked) AND (title LIKE '%" . $search_data . "%' or kicker LIKE '%" . $search_data . "%' or source LIKE '%" . $search_data . "%' or description LIKE '%" . $search_data . "%') order by sort_order asc");
        //echo "<pre>";
        //print_r($fetch_post);exit;
        if ($fetch_post != 0) {
            $count = count($fetch_post);
            ?>
            <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
            <div class="row-height">
                <?php
                $count = count($fetch_post);
                for ($i = 0; $i < $count; $i++) {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                        <div class="inside inside-full-height">
                            <div class="content">
                                <div id="fix_column">
                                    <img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php
                                        if ($fetch_post[$i]['kicker'] != "") {
                                            echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CtaPage_cicker_span'>" . strtoupper(substr($fetch_post[$i]['kicker'], 0, 50)) . "</p>");
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $fetch_post[$i]['title']); ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"> 
                                        <?php
                                        $catid = $fetch_post[$i]['catid'];
                                        $catid1 = str_replace('"', "'", $catid);
                                        if ($catid != "") {
                                            $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (" . $catid . ") AND status='1' order by catid desc");
                                            if ($qry_cat != "") {
                                                echo "<p id='CatPage_Category_span'>";
                                                foreach ($qry_cat as $qry_cat) {
                                                    echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $qry_cat['category'] . ",");
                                                }
                                                echo "</p>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php if (strlen($fetch_post[$i]['description']) > 400) { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')" style="cursor:pointer;">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . substr($fetch_post[$i]['description'], 0, 330) . "</p>");
                                            }
                                            ?><?php echo "..."; ?>

                                        </div>
                                        <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $fetch_post[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                        <!--<div id="back<?php //echo $fetch_post['postid']              ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>";              ?></div>-->
                                    <?php } else { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid']; ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if (isset($_SESSION['sessionid'])) {
                                            $ids = explode(',', $fetch_post[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids, $user_id);
                                            if (!empty($l_id)) {
                                                ?>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?>



                                            <?php
                                            $b_id = explode(',', $fetch_post[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id, $user_id);
                                            if (!empty($b_id1)) {
                                                ?>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                    <!--                                            <span class="dropdown">
                    <button style="font-size:16px; margin-left: -15px; padding:0px 0px 1px 15px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php //echo $fetch_post[$i]['url'];             ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/> Facebook</a></li>
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php //echo $fetch_post[$i]['url'];             ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/> Twitter</a> </li>
                    </ul>
                    </span>-->
                                            <span class="dropdown dropup share_detail">
                                                <a style="font-size:15px;border:0px; outline: none; margin-left: -25px; text-transform: uppercase; cursor: pointer;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share </a>
                                                <ul class="dropdown-menu share_drp_menu">
                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharefb"> Share To Facebook</a></li>

                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharetwit"> Share To Twitter</a></li>
                                                </ul>
                                            </span>
                                        <?php } else {
                                            ?>
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
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
                <?php } ?>
            </div>
            <?php
        } else {
            echo '2';
        }
    } else {
        $user_detail = $obj->qry_fetchrow("select * from tbl_user where sessid='" . $_SESSION['sessionid'] . "'");
        $userid = $user_detail['userid'];
        $search_data = $_GET['data'];
        $fetch_post = $obj->qry_fetchrows("select * from tbl_post where find_in_set($userid,isbookmarked) AND (title LIKE '%" . $search_data . "%' or kicker LIKE '%" . $search_data . "%' or source LIKE '%" . $search_data . "%' or description LIKE '%" . $search_data . "%') order by sort_order asc");
        //echo "<pre>";
        //print_r($fetch_post);exit;
        if ($fetch_post != 0) {
            $count = count($fetch_post);
            ?>
            <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
            <div class="row-height">
                <?php
                $count = count($fetch_post);
                for ($i = 0; $i < $count; $i++) {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
                        <div class="inside inside-full-height">
                            <div class="content">
                                <div id="fix_column">
                                    <img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php
                                        if ($fetch_post[$i]['kicker'] != "") {
                                            echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CtaPage_cicker_span'>" . strtoupper(substr($fetch_post[$i]['kicker'], 0, 50)) . "</p>");
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                        <?php echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $fetch_post[$i]['title']); ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')"> 
                                        <?php
                                        $catid = $fetch_post[$i]['catid'];
                                        $catid1 = str_replace('"', "'", $catid);
                                        if ($catid != "") {
                                            $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (" . $catid . ") AND status='1' order by catid desc");
                                            if ($qry_cat != "") {
                                                echo "<p id='CatPage_Category_span'>";
                                                foreach ($qry_cat as $qry_cat) {
                                                    echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', $qry_cat['category'] . ",");
                                                }
                                                echo "</p>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php if (strlen($fetch_post[$i]['description']) > 400) { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')" style="cursor:pointer;">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . substr($fetch_post[$i]['description'], 0, 330) . "</p>");
                                            }
                                            ?><?php echo "..."; ?>

                                        </div>
                                        <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(" . $fetch_post[$i]['postid'] . ")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">
                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                        <!--<div id="back<?php //echo $fetch_post['postid']               ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>";               ?></div>-->
                                    <?php } else { ?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>', '_blank')">

                                            <?php
                                            if ($fetch_post[$i]['description'] != "") {
                                                echo str_ireplace($search_data, '<span id="mark_color">' . $search_data . '</span>', "<p id='CatPage_Desc_span'>" . $fetch_post[$i]['description'] . "</p>");
                                            }
                                            ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if (isset($_SESSION['sessionid'])) {
                                            $ids = explode(',', $fetch_post[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids, $user_id);
                                            if (!empty($l_id)) {
                                                ?>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?>



                                            <?php
                                            $b_id = explode(',', $fetch_post[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id, $user_id);
                                            if (!empty($b_id1)) {
                                                ?>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                    <!--                                            <span class="dropdown">
                    <button style="font-size:16px; margin-left: -15px; padding:0px 0px 1px 15px;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share <span class="caret"></span> </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php //echo $fetch_post[$i]['url'];             ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/> Facebook</a></li>
                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php //echo $fetch_post[$i]['url'];             ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/> Twitter</a> </li>
                    </ul>
                    </span>-->
                                            <span class="dropdown dropup share_detail">
                                                <a style="font-size:15px;border:0px; outline: none; margin-left: -25px; text-transform: uppercase; cursor: pointer;" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Share </a>
                                                <ul class="dropdown-menu share_drp_menu">
                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharefb"> Share To Facebook</a></li>

                                                    <li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $fetch_post[$i]['url']; ?>&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0" target="_blank" class="sharetwit"> Share To Twitter</a></li>
                                                </ul>
                                            </span>
                                        <?php } else {
                                            ?>
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                            <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (@$screen_resolution < 1600) {
                        if (($i + 1) % 3 == 0) {
                            ?><div class="clearfix visible-lg"></div><?php
                        }
                    } else {
                        if (($i + 1) % 4 == 0) {
                            ?><div class="clearfix visible-lg"></div><?php
                            }
                        }
                        ?>
                    <?php } ?>
            </div>
            <?php
        } else {
            echo '2';
        }
    }
}


/* -------Category-------- */

if (isset($_POST['UserSelectCategory'])) {

    $catid = $_POST['cat_id'];

    $qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='" . $_SESSION['sessionid'] . "'");
    $userid = $qry0['userid'];

    if (!empty($userid)) {
        if ($qry0["catid"] != "") {
            $catidxyz = $qry0["catid"] . ',' . $catid;
            $update_catidxyz = $obj->qry_runQuery("UPDATE `tbl_user` SET `catid`='" . $catidxyz . "' WHERE `userid`='" . $userid . "'");
            if ($update_catidxyz) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $catidxyz = $catid;
            $update_catidxyz = $obj->qry_runQuery("UPDATE `tbl_user` SET `catid`='" . $catidxyz . "' WHERE `userid`='" . $userid . "'");
            if ($update_catidxyz) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}

if (isset($_POST['UnsetUserSelectCategory'])) {

    $catid = $_POST['cat_id'];

    $qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='" . $_SESSION['sessionid'] . "'");
    $userid = $qry0['userid'];
    if (!empty($userid)) {
        if ($qry0["catid"] != "") {
            $checkin = explode(',', $qry0["catid"]);
            $index = array_search($catid, $checkin);
            if ($index !== false) {
                unset($checkin[$index]);
            }
            $catidxyz = implode(',', $checkin);
            $update_catidxyz = $obj->qry_runQuery("UPDATE `tbl_user` SET `catid`='" . $catidxyz . "' WHERE `userid`='" . $userid . "'");
            if ($update_catidxyz) {
                echo '1';
            } else {
                echo '0';
            }
        }
    } else {
        echo '2';
    }
}

/* -------Like Page Search------- */
/* if(isset($_GET['action']) && $_GET['action']=='likes_search'){
  $user_detail = $obj->qry_fetchrow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
  $userid = $user_detail['userid'];
  $search_data = $_GET['data'];
  $fetch_post = $obj->qry_fetchrows("select * from tbl_post where find_in_set($userid,isliked) AND (title LIKE '%".$search_data."%' or kicker LIKE '%".$search_data."%' or source LIKE '%".$search_data."%' or description LIKE '%".$search_data."%') order by postid desc");
  //echo "<pre>";
  //print_r($fetch_post);exit;
  if($fetch_post != 0){
  $count = count($fetch_post); ?>
  <?php @$screen_resolution = $_COOKIE['screen_res']; ?>
  <div class="row-height">
  <?php
  $count = count($fetch_post);
  for ($i = 0; $i < $count; $i++) {
  ?>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-height" id="content_height">
  <div class="inside inside-full-height">
  <div class="content">
  <div id="fix_column">
  <img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php if($fetch_post[$i]['kicker'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CtaPage_cicker_span'>".strtoupper(substr($fetch_post[$i]['kicker'], 0, 50))."</p>"); } ?>
  </div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', $fetch_post[$i]['title']); ?>
  </div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php

  $catid = $fetch_post[$i]['catid'];
  $catid1 = str_replace('"',"'",$catid);
  if($catid != ""){
  $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
  if($qry_cat != ""){echo "<p id='CatPage_Category_span'>";
  foreach($qry_cat as $qry_cat){
  echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', $qry_cat['category'].",");
  }
  echo "</p>";
  }
  }

  ?>
  </div>
  <?php
  if(strlen($fetch_post[$i]['description']) > 400){ ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">

  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".substr($fetch_post[$i]['description'],0,330)."</p>"); } ?><?php echo "..."; ?>

  </div>
  <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".$fetch_post[$i]['description']."</p>"); } ?>
  </div>
  <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
  <?php }else{ ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid']; ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">

  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".$fetch_post[$i]['description']."</p>"); } ?>
  </div>
  <?php }
  ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
  <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12">
  <?php
  if(isset($_SESSION['sessionid'])){
  $ids = explode(',',$fetch_post[$i]['isliked']);
  $user_id = array($userid);
  $l_id = array_intersect($ids,$user_id);
  if(!empty($l_id)){ ?>
  <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
  <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
  <?php }else{ ?>
  <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
  <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
  <?php } ?>



  <?php
  $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
  $b_id1 = array_intersect($b_id,$user_id);
  if(!empty($b_id1)){ ?>
  <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
  <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
  <?php }else{ ?>
  <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
  <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
  <?php }
  ?>
  <a id="share_post">SHARE</a>&nbsp;&nbsp;
  <?php
  }else{ ?>
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
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
  <?php } ?>
  </div>
  <?php
  }else{
  echo '2';
  }
  } */

/* -------Bookmark Page Search------- */
/* if(isset($_GET['action']) && $_GET['action']=='bookmark_search'){
  $user_detail = $obj->qry_fetchrow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
  $userid = $user_detail['userid'];
  $search_data = $_GET['data'];
  $fetch_post = $obj->qry_fetchrows("select * from tbl_post where find_in_set($userid,isbookmarked) AND (title LIKE '%".$search_data."%' or kicker LIKE '%".$search_data."%' or source LIKE '%".$search_data."%' or description LIKE '%".$search_data."%') order by postid desc");
  //echo "<pre>";
  //print_r($fetch_post);exit;
  if($fetch_post != 0){
  $count = count($fetch_post);
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
  <img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php if($fetch_post[$i]['kicker'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CtaPage_cicker_span'>".strtoupper(substr($fetch_post[$i]['kicker'], 0, 50))."</p>"); } ?>
  </div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', $fetch_post[$i]['title']); ?>
  </div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php

  $catid = $fetch_post[$i]['catid'];
  $catid1 = str_replace('"',"'",$catid);
  if($catid != ""){
  $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
  if($qry_cat != ""){echo "<p id='CatPage_Category_span'>";
  foreach($qry_cat as $qry_cat){
  echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', $qry_cat['category'].",");
  }
  echo "</p>";
  }
  }

  ?>
  </div>
  <?php
  if(strlen($fetch_post[$i]['description']) > 400){ ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">

  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".substr($fetch_post[$i]['description'],0,330)."</p>"); } ?><?php echo "..."; ?>

  </div>
  <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".$fetch_post[$i]['description']."</p>"); } ?>
  </div>
  <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
  <?php }else{ ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">

  <?php if($fetch_post[$i]['description'] != ""){ echo str_ireplace($search_data, '<span id="mark_color">'.$search_data.'</span>', "<p id='CatPage_Desc_span'>".$fetch_post[$i]['description']."</p>"); } ?>
  </div>
  <?php }
  ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
  <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12">
  <?php
  if(isset($_SESSION['sessionid'])){
  $ids = explode(',',$fetch_post[$i]['isliked']);
  $user_id = array($userid);
  $l_id = array_intersect($ids,$user_id);
  if(!empty($l_id)){ ?>
  <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
  <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
  <?php }else{ ?>
  <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
  <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
  <?php } ?>



  <?php
  $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
  $b_id1 = array_intersect($b_id,$user_id);
  if(!empty($b_id1)){ ?>
  <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
  <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
  <?php }else{ ?>
  <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
  <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
  <?php }
  ?>
  <a id="share_post">SHARE</a>&nbsp;&nbsp;
  <?php
  }else{ ?>
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
  <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
  <?php }
  ?>
  </div>

  </div>
  </div>
  </div>
  </div>
  <?php
  if (@$screen_resolution < 1600) {
  if (($i + 1) % 3 == 0) {
  ?><div class="clearfix visible-lg"></div><?php
  }
  } else {
  if (($i + 1) % 4 == 0) {
  ?><div class="clearfix visible-lg"></div><?php
  }
  }
  ?>
  <?php } ?>
  </div>
  <?php
  }else{
  echo '2';
  }
  } */
?>