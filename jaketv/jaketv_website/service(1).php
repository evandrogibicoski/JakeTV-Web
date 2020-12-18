<?php

include('secure/config.php');

$obj = new service_class();

if(isset($_POST['load_value_data'])){
	$Page = $_POST['load_value_data'];
	
	$PageLimit = 24;
	$Offset = $Page*$PageLimit;
    $pagedata = ($Page+1)*$PageLimit;
	
	@$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='".$_SESSION['sessionid']."'");
	$userid = $user_data['userid'];
	
	$qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
	foreach($qry02 as $qry){
		$id = $qry['catidu'];
		$qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
		$dd[] = $qry021;
	}
	
	foreach($dd as $v1){
		if(is_array($v1)){
			foreach($v1 as $v2){
				$newArray[] = $v2;
			}
		}
	}
	foreach($newArray as $newArray){
		$post_id[] = $newArray['postid'];
	}
	$d = implode(',',$post_id);
	$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT  $Offset,$PageLimit");
	
	if($fetch_post != 0){
			$_SESSION['pagedata'] = $pagedata;
        	$_SESSION['page'] = $Page;
			$count = count($fetch_post);
	
			for ($i = 0; $i < $count; $i++) {
				
				if($i<1){
					$div_id = '1';
				}else if($i%3 == 0){
					$div_id1 = ($i/3)+1;
				}
				@$last_div = $div_id1;
				
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;" id="div<?php echo $div_id; ?>">
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>

                                </div>
                            </div>
					<?php 
					} else if($i<2){ 
					?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">

                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
											 </div>
                                             <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
					  
						<?php
					}else{ ?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
				} else if ($i % 3 == 0) { ?>
							<div class="row" style="margin-bottom:50px; position:relative;" id="div<?php echo $div_id1; ?>">
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
				<?php } else { 
					if(($i-1)%3 == 0){ ?>
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_dec" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
	}else{
		echo '2';	

	}
}

if(isset($_POST['likes_load_value_data'])){
	$Page = $_POST['likes_load_value_data'];
	
	@$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='".$_SESSION['sessionid']."'");
	$userid = $user_data['userid'];
	
	$alldata = array();
	$responsedata = array();
	$qry0 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `cr_date` DESC");
	foreach($qry0 as $qry0_data)
	{
		$checkin = explode(',',$qry0_data["isliked"]);
		$index = array_search($userid,$checkin);
		if($index !== false)
		{
			$qry_cat = $obj->qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='".$qry0_data["catid"]."'");
			$qry_subcat = $obj->qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='".$qry0_data["subcatid"]."'");
			
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
			$book = explode(',',$qry0_data['isbookmarked']);
			if(in_array($userid,$book))
			{
				$alldata['isbookmarked']='1';
			}
			else
			{
				$alldata['isbookmarked']='0';
			}
			$like = explode(',',$qry0_data['isliked']);
			if(in_array($userid,$like))
			{
				$alldata['isliked']='1';
			}
			else
			{
				$alldata['isliked']='0';
			}
			$alldata["cr_date"] = $qry0_data["cr_date"];
			$responsedata[] = $alldata;
		}
		
		
	}
	
	if($responsedata!=NULL)
	{
		/*if(!empty($_SESSION['likes_pagedata'])){
			$PageLimit =  $_SESSION['likes_pagedata'];
		}else{
			@$PageLimit = "6";
			//$_SESSION['pagedata'] = $PageLimit;
		}*/
		
		@$PageLimit = 24;
		@$numtotal = count(@$responsedata);
		@$totalpage=round(@$numtotal/@$PageLimit);
		if($totalpage==0)
		{
			$totalpage=1;
		}
		else
		{
			$totalpage=$totalpage;	
		}

		@$response = array();
		
		
		
		if(@$Page==0)
		{
			@$offset = @$Page;
		}
		else
		{
			@$offset = (@$Page*@$PageLimit);
			//$likes_pagedata = ($Page+1)*$PageLimit;
			//$_SESSION['likes_pagedata'] = $likes_pagedata;
        	//$_SESSION['likes_page'] = $Page;	
		}

		for(@$i=0;@$i<@$PageLimit;@$i++)
		{
			if(@$i==0)
			{
				@$array_ind = @$i+@$offset; 
			}
			else
			{
				@$array_ind = @$i+@$offset; 
			}
			
			//echo $array_ind;
			
			
			if(@$responsedata[@$array_ind]!='')
			{
				if(empty($response))
				{
					@$fetch_post[] = @$responsedata[@$array_ind];	
				}
				else if( !in_array(@$responsedata[@$array_ind], @$response) ) 
				{
					@$fetch_post[] = @$responsedata[@$array_ind];
				}
			}
		}
		
	}
	
	if(!empty($fetch_post)){
			
		$PageLimit_temporary = 24;
		$likes_pagedata = ($Page+1)*$PageLimit_temporary;
		$_SESSION['likes_pagedata'] = $likes_pagedata;
		$_SESSION['likes_page'] = $Page;
			
			$count = count($fetch_post);
			for ($i = 0; $i < $count; $i++) {
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;">
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>

                                </div>
                            </div>
					<?php 
					} else if($i<2){ 
					?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">

                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
											 </div>
                                             <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
					  
						<?php
					}else{ ?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                       
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
				} else if ($i % 3 == 0) { ?>
							<div class="row" style="margin-bottom:50px;">
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
				<?php } else { 
					if(($i-1)%3 == 0){ ?>
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; font-size:1.1rem; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_dec" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                       
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
	else{
		echo '2';
	}
}

if(isset($_POST['bookmark_load_value_data'])){
	$Page = $_POST['bookmark_load_value_data'];
	
	@$user_data = $obj->qry_fetchRow("SELECT userid FROM tbl_user WHERE sessid='".$_SESSION['sessionid']."'");
	$userid = $user_data['userid'];
	
	$alldata = array();
	$responsedata = array();
	$qry0 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `cr_date` DESC");
	foreach($qry0 as $qry0_data)
	{
		$checkin = explode(',',$qry0_data["isbookmarked"]);
		if(in_array($userid,$checkin))
		{
			$qry_cat = $obj->qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='".$qry0_data["catid"]."'");
			$qry_subcat = $obj->qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='".$qry0_data["subcatid"]."'");
			
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
			$book = explode(',',$qry0_data['isbookmarked']);
			if(in_array($userid,$book))
			{
				$alldata['isbookmarked']='1';
			}
			else
			{
				$alldata['isbookmarked']='0';
			}
			$like = explode(',',$qry0_data['isliked']);
			if(in_array($userid,$like))
			{
				$alldata['isliked']='1';
			}
			else
			{
				$alldata['isliked']='0';
			}
			$alldata["cr_date"] = $qry0_data["cr_date"];
			$responsedata[] = $alldata;
		}
	}
	if($responsedata!=NULL)
	{
		@$PageLimit = 24;
		@$numtotal = count(@$responsedata);
		@$totalpage=round(@$numtotal/@$PageLimit);
		if($totalpage==0)
		{
			$totalpage = 1;	
		}
		else
		{
			$totalpage = $totalpage;	
		}
		@$response = array();
		if(@$Page==0)
		{
			@$offset = @$Page;
		}
		else
		{
			@$offset = (@$Page*@$PageLimit);	
		}
		
		for(@$i=0;@$i<@$PageLimit;@$i++)
		{
			if(@$i==0)
			{
				@$array_ind = @$i+@$offset; 
			}
			else
			{
				@$array_ind = @$i+@$offset; 
			}
			
			if(@$responsedata[@$array_ind]!='')
			{
				if(empty($response))
				{
					@$fetch_post[] = @$responsedata[@$array_ind];	
				}
				else if( !in_array(@$responsedata[@$array_ind], @$response) ) 
				{
					@$fetch_post[] = @$responsedata[@$array_ind];
				}
			}
		}
		//$response = array_unique(@$response);
	}
	
	if(!empty($fetch_post)){
		$PageLimit_temporary = 24;
		$likes_pagedata = ($Page+1)*$PageLimit_temporary;
		$_SESSION['bookmark_pagedata'] = $likes_pagedata;
		$_SESSION['bookmark_page'] = $Page;
		
		$count = count($fetch_post);
			for ($i = 0; $i < $count; $i++) {
				
				
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;">
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 if($qry_cat != 0){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>

                                </div>
                            </div>
					<?php 
					} else if($i<2){ 
					?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">

                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
											 </div>
                                             <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
					  
						<?php
					}else{ ?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                       
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
				} else if ($i % 3 == 0) { ?>
							<div class="row" style="margin-bottom:50px;">
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
				<?php } else { 
					if(($i-1)%3 == 0){ ?>
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>

                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catuniqueid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_dec" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">LIKED</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                       
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post_bookmark(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARKED</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
                                        <?php }
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
	}else{
		echo '2';	
	}
}


if(isset($_POST['sel_categroy']))
{
	if($_POST['flag']==1)
	{
		$query = "UPDATE `tbl_category` SET `selected`=0 WHERE `catidu`=" .$_POST['catid'];
	}
	else
	{
		$query = "UPDATE `tbl_category` SET `selected`=1 WHERE `catidu`=" .$_POST['catid'];
	}
	$runqry = $obj->qry_runQuery($query);
	echo "1";
}

if(isset($_POST['register'])){
	$fname = $_POST['f_name'];
	$lname = $_POST['l_name'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$c_pass = $_POST['c_password'];
	
	$password = hash('sha512',$pass);
	$sessionid = hash('sha512', strtotime(date('Y-m-d H:i:s'))+rand(0,500)+rand(500,1000));
	
	$cr_date = date('Y-m-d H:i:s');
	$modify_data = date('Y-m-d H:i:s');
	
	$select = $obj->qry_fetchRows("SELECT * FROM `tbl_user` WHERE `email`='".$email."'");
	
	
	if($select == "0"){
		$ins = "insert into tbl_user(`fname`,`lname`,`email`,`password`,`status`,`cr_date`,`modify_date`,`sessid`) values('".$fname."','".$lname."','".$email."','".$password."','1','".$cr_date."','".$modify_data."','".$sessionid."')";
		$result = $obj->qry_insertedId($ins);
		if($result){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		echo '2';	
	}
}


if(isset($_POST['login'])){
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$pass = hash('sha512',$password);
	$sessionid = hash('sha512', strtotime(date('Y-m-d H:i:s'))+rand(0,500)+rand(500,1000));
	
	$select = $obj->qry_fetchRows("select * from tbl_user where email='".$email."' and password='".$pass."'");
	
	if($select != 0){
		
		$update = $obj->qry_runQuery("update tbl_user set sessid='".$sessionid."' where email='".$email."' and password='".$pass."'");
		if($update){
			$_SESSION['sessionid'] = $sessionid;
			echo '1';
		}else{
			echo '2';
		}
		
		
	}else{
		echo '0';
	}
}


if(isset($_POST['like_post'])){
	$postid = $_POST['postid'];

	$sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	
		if(isset($userid))
		{
			$qry0 = $obj->qry_fetchRow("SELECT * FROM tbl_post WHERE postid='".$postid."'");
			if($qry0["isliked"]!="")
			{
				$isliked = $qry0["isliked"].','.$userid;
				$update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$exp_isliked = explode(',',$isliked);
				$totallikes = count($exp_isliked);
				$update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
				if($update_totallikes){
					echo '1';	
				}else{
					echo '0';
				}
			}
			else
			{
				$isliked = $userid;
				$update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$exp_isliked = explode(',',$isliked);
				$totallikes = count($exp_isliked);
				$update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
				if($update_totallikes){
					echo '1';
				}else{
					echo '0';	
				}
			}
			
		}else{
			echo '2';
		}
		
}

if(isset($_POST['unlike_post'])){
	$postid = $_POST['postid'];

	$sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	
		if(isset($userid))
		{
			$qry0 = $obj->qry_fetchRow("SELECT * FROM tbl_post WHERE postid='".$postid."'");
			if($qry0["isliked"]!="")
			{
				$checkin = explode(',',$qry0["isliked"]);
				$index = array_search($userid,$checkin);
				if($index !== false)
				{
					unset($checkin[$index]);
				}
				$totallikes = count($checkin);
				$isliked=implode(',',$checkin);
				$update_isliked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$update_totallikes = $obj->qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
				if($update_totallikes){
					echo '1';
				}else{
					echo '0';
				}
			}
		}else{
			echo '2';
		}
		
}


if(isset($_POST['bookmark_post'])){
	$postid = $_POST['postid'];

	$sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	
	if(isset($userid))
		{
			$qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isbookmarked"]!="")
			{
				$isbookmarked = $qry0["isbookmarked"].','.$userid;
				$update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
				if($update_isbookmarked){
					echo '1';
				}else{
					echo '0';	
				}
			}
			else
			{
				$isbookmarked = $userid;
				$update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
				if($update_isbookmarked){
					echo '1';
				}else{
					echo '0';	
				}
			}
		}
		else{
			echo '2';
		}
}


if(isset($_POST['unbookmark_post'])){
	$postid = $_POST['postid'];

	$sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	
	if(isset($userid))
		{
			$qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isbookmarked"]!="")
			{
				$checkin = explode(',',$qry0["isbookmarked"]);
				$index = array_search($userid,$checkin);
				if($index !== false)
				{
					unset($checkin[$index]);
				}
				$isbookmarked=implode(',',$checkin);
				$update_isbookmarked = $obj->qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
				if($update_isbookmarked){
					echo '1';
				}else{
					echo '0';	
				}
			}
		}else{
			echo '2';
		}
}
if(isset($_GET['action']) && $_GET['action']=='search')
{
	
	$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE title LIKE '%".$_GET['data']."%'");	
	if($fetch_post!=0)
	{
	$count = count($fetch_post);
	for ($i = 0; $i < $count; $i++) {
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;">
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
					<?php 
					} else if($i<2){ 
					?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">

                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
											 </div>
                                             <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
                                        <?php }
										?>
                                         <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
					  
						<?php
					}else{ ?>
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARKE</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARKE</a>&nbsp;&nbsp;
                                        <?php }
										?>
                                         <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            
                            </div>
						
						</div>
					<?php }
				} else if ($i % 3 == 0) { ?>
							<div class="row" style="margin-bottom:50px;">
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_decs" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARKE</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARKE</a>&nbsp;&nbsp;
                                        <?php }
										?>
                                         <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                    <?php }
                                    ?>
                                </div>
                                </div>
                            </div>
				<?php } else { 
					if(($i-1)%3 == 0){ ?>
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
								<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div style="margin-left:auto; margin-right:auto; width:350px; height:200px;">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="text-align:left; padding-left:0px; padding-right:0px; color: #646464; font-weight:700; margin-top:10px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kicker'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
                                        <?php

												$catid = $fetch_post[$i]['catid'];
												$catid1 = str_replace('"',"'",$catid);
												if($catid != ""){
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 if($qry_cat != 0){
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
													 }
												}			

										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>

										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo $fetch_post[$i]['description']; ?>
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
                                        
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
                                        <?php
                                        $b_id = explode(',',$fetch_post[$i]['isbookmarked']);
                                        $b_id1 = array_intersect($b_id,$user_id);
                                        if(!empty($b_id1)){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
                                        <?php }
										
                                    }else{ ?>
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="like_post1">LIKE</a>&nbsp;&nbsp;
                                        
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="bookmark_post1">BOOKMARK</a>&nbsp;&nbsp;
                                        <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="share_post">SHARE</a>&nbsp;&nbsp;
                                        
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
	else
	{
		?>
        <p>No records found</p>
        <?php
	}
}
?>