<?php
include('service.php');
//include('secure/customjs.php');
$obj = new service_class();

if(isset($_SESSION['sessionid'])){
	$sel = $obj->qry_fetchRow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
	$userid = $sel['userid'];
}

if(isset($_REQUEST['cat_post_list'])){
	$catid = $_REQUEST['catid'];
	
	$PageLimit = 6;
	
	$post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE FIND_IN_SET('$catid',catid) AND status='1' ORDER BY postid DESC");
	$post_list = $obj->qry_fetchrows("SELECT * FROM tbl_post WHERE FIND_IN_SET('$catid',catid) AND status='1' ORDER BY postid DESC LIMIT $PageLimit");
	if(!empty($post_list)){
		$post_list = $post_list;
	}else{
		$post_list = array();
	}
	$total_post_rows = $post_rows;
	
if(!empty($post_list)){
	
?>

    
    <div class="row" id="content_cat_post_list">
    <div>
   		<?php
	 if(!empty($post_list)){
			for ($i = 0; $i < count($post_list); $i++) {
				if ($i < 3) {
					if ($i < 1) { ?>
						 <div class="row" id="CatPage_Main_Row">
                         	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
					<?php }else if($i<2){ ?>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
					<?php }else{ ?>
                    		<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
					<?php }
				}else if($i % 3 == 0){ ?>
						<div class="row">	
                        	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
				<?php }else{ 
					if(($i-1)%3 == 0){ ?>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
					<?php }else{ ?>
                    		<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            	<div id="fix_column">
                                	<img src="<?php echo $post_list[$i]['image']; ?>" id="CatPage_img" width="350" height="200" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" />
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $str = strtoupper(substr($post_list[$i]['kicker'], 0, 50)); ?>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="CatPage_Title" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                    	<?php echo $post_list[$i]['title']; ?> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                    	<?php
												$catid = $post_list[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if(!empty($qry_cat)){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			
										?>
                                    </div>
                                    <?php
									if(strlen($post_list[$i]['description']) > 400){ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo substr($post_list[$i]['description'],0,330); ?><?php echo "..."; ?>
                                        </div>
                                        <div class="CatPage_Seemore" id="seemore<?php echo $post_list[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$post_list[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')">
												<?php echo $post_list[$i]['description']; ?>
											 </div>
                                    <?php }else{ ?>
                                    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $post_list[$i]['postid'] ?>" onClick="window.open('<?php echo $post_list[$i]['url']; ?>','_blank')" style="cursor:pointer;">
                                        	<?php echo $post_list[$i]['description']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <?php
                                        if(isset($_SESSION['sessionid'])){
                                            $ids = explode(',',$post_list[$i]['isliked']);
                                            $user_id = array($userid);
                                            $l_id = array_intersect($ids,$user_id);
                                            if(!empty($l_id)){ ?>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="like_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $post_list[$i]['postid']; ?>">LIKE</a>
                                                <a onClick="unlike_post(<?php echo $post_list[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $post_list[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                            <?php } ?> 
                                            <?php
                                            $b_id = explode(',',$post_list[$i]['isbookmarked']);
                                            $b_id1 = array_intersect($b_id,$user_id);
                                            if(!empty($b_id1)){ ?>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>">UNBOOKMARK</a>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                            <?php }else{ ?>
                                                <a onClick="bookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $post_list[$i]['postid']; ?>">BOOKMARK</a>
                                                <a onClick="unbookmark_post(<?php echo $post_list[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $post_list[$i]['postid']; ?>" style="display:none;">UNBOOKMARK	</a>&nbsp;&nbsp;
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
					<?php }
				} 
			}
	 }
	 else{ ?>
		 <center><h1>Post not available</h1></center>
	 <?php }
		?>
        <div class="CatPost_New_Div"></div>
    </div>   
    
    
    
    </div>
<?php }else{
	echo '2';
}
    
} 
?>
 