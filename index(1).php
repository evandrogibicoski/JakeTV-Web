<?php
include('service.php');
include('secure/customjs.php');
$obj = new service_class();
/*if(isset($_SESSION['sessionid'])){
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
	$total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc");*/
	
	
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
	//$_SESSION['pagedata'] = $PageLimit;
}

$qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");

if(!empty($qry02)){
	foreach($qry02 as $qry){
		$id = $qry['catidu'];
		$qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
		$dd[] = $qry021;
	}
	
	foreach($dd as $v1){
		if(is_array($v1)){
			foreach($v1 as $v2){
				@$newArray[] = $v2;
			}
		}
	}
	if(!empty($newArray)){	
		foreach($newArray as $newArray){
			$post_id[] = $newArray['postid'];
		}
	}else{
		$post_id[] = "";	
	}
}else{
	$post_id[] = "";
}

if(isset($_SESSION['sessionid'])){
	$sel = $obj->qry_fetchRow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	$first_rname = $sel['fname'];
	$last_name = $sel['lname'];
	$user_catid = explode(',',$sel['catid']);
	if($sel['catid'] != ""){
		for($i=0;$i<count($user_catid);$i++){
		$id = $user_catid[$i];
		$qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
		$user_cat_post[] = $qry021;
		}
		foreach($user_cat_post as $v1){
			if(is_array($v1)){
				foreach($v1 as $v2){
					@$user_post_array[] = $v2;
				}
			}
		}
		if(!empty($user_post_array)){
			foreach($user_post_array as $user_post_array){
				$user_post_id[] = $user_post_array['postid'];
			}
			$user_post_id1 = array_unique($user_post_id);
			foreach($user_post_id1 as $k => $v){
				$user_post_id2[] = $v;
			}
		}else{
			$user_post_id2[] = "";
		}
	}else{
			$user_post_id2[] = "";
	}
	
	
	
	$all_post_id = array_merge($user_post_id2, $post_id);
	
	$all_post_id2 = array_unique($all_post_id);
	
	foreach($all_post_id2 as $k=>$val){
		if($val != ""){
			$all_post_id1[] = $val;
		}
	}
	if(!empty($all_post_id1)){
		$d = implode(',',$all_post_id1);
		$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");
		$total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc");
	}else{
		@$fetch_post == array();
		$total_post_rows = 0;
	}
	
}else{
	foreach($post_id as $k=>$val){
		if($val != ""){
			$post_id1[] = $val;
		}
	}
	if(!empty($post_id1)){
		$d = implode(',',$post_id);
		$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");
		
		$total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc");
	}
	else{
		@$fetch_post == "";	
		$total_post_rows = 0;
	}
}
	
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/JAKEtv_flav.png">
<title>Jake TV • Jewish Arts Knowledge Entertainment</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />

</head>
<body>
<div class="header">
  <?php
include('header.php'); 
?>
</div>
<!--welcome-->
<div class="content">
  <div class="welcome"> 
    <!--<div class="container">-->
    <div class="row" id="search_button">
      <div class="form-group col-lg-8">
        <div class="input-group" id="home_search_css">
          <input type="text" class="form-control input-lg" id="serachdata" onKeyUp="searcheddata()" placeholder="Search" />
          <span class="input-group-btn">
          <button class="btn btn-info btn-lg" type="button"> <i class="glyphicon glyphicon-search"></i> </button>
          </span> </div>
      </div>
      <div class="col-lg-4">
		  <?php 
		  if(@$userid==''){ ?>
          <div class="row" id="login_button_responsiveness">
			  <button type="button" class="btn btn-default form-control input-lg" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">LOGIN / SIGNUP</button>
		  </div>
		  <?php }else{ ?>
          		<span id="login_user">
			  		<a class="btn btn-default btn-lg" href="#" role="button"><?=$sel['fname'].' '.$sel['lname']?></a> 
                </span>
                <span id="logout_user">
              		<a class="btn btn-default btn-lg" href="logout.php" role="button" id="">Logout</a>
              	</span>
		  <?php } ?>
      </div>
    </div>
    <div class="row" id="content123">
     <?php
	 if(@$fetch_post != ""){
			$count = count($fetch_post);
			for ($i = 0; $i < $count; $i++) {
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;">
							<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?> 
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
										<?php 
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
							<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
											 </div>
                                             <div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
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
							<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">									
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;"   onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">									
										<?php 
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
								<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>                                         
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_decs" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">									
										<?php 
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
								<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
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
								<div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 330){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">									
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
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
	 else{ ?>
		 <center><h1>Post not available</h1></center>
	 <?php }
		?>
        <div id="new_div"></div>
        
    </div>
    
    
    <?php
	if(isset($_SESSION['pagedata'])){
		if($_SESSION['pagedata'] < $total_post_rows){ ?>
			<div class="row" id="load_more">
              <div class="col-sm-5"></div>
              <div class="col-sm-2" onClick="load_script_data(<?php if(isset($_SESSION['Page'])){echo ($_SESSION['Page']);} ?>)">
                <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['page'])){echo ($_SESSION['page']+1);}else{echo '1';} ?>"/>
                <button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
                </div>
              <div class="col-sm-5"></div>
            </div>
		<?php }
	}else if($total_post_rows < 7){ ?>
		
	<?php }else{ ?>
		<div class="row" id="load_more">
          <div class="col-sm-5"></div>
          <div class="col-sm-2" onClick="load_script_data(<?php if(isset($_SESSION['Page'])){echo ($_SESSION['Page']);} ?>)">
            <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['page'])){echo ($_SESSION['page']+1);}else{echo '1';} ?>"/>
            <button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
            </div>
          <div class="col-sm-5"></div>
        </div>
	<?php }
	?>
    
    
    
    
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       
      </div>
        
      <div class="modal-body">
      			<div id="exTab2" class="container">
         	<ul class="nav nav-tabs" style="margin-top:-20px;">
                <li class="active">
                <a  href="#1" data-toggle="tab">Login</a>
                </li>
                <li><a href="#2" data-toggle="tab">Registration</a>
                </li>
                <li><a href="#3" data-toggle="tab">Forgot Password</a>
                </li>
            </ul>
            <div class="tab-content">
            	<div class="tab-pane active" id="1">
     <div class="row" id="login_page">
            <form name="login_form" method="post" style="margin-top:-55px;">
            <div id="login_validation" class="col-sm-12 col-md-12 col-lg-12 col-xs-12"></div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="margin-left:25px;">
                    <input type="text" id="login_email" name="email" value="" placeholder="Email" class="form-control input-lg " />
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="margin-left:25px;">
                <input type="password" id="login_pass" name="password" value="" placeholder="Password" class="form-control input-lg" /></div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="min-height:20px;">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-12">
                <button type="button" onClick="login_user()" name="login" id="login_button" class="form-control input-lg btn btn-default" style="background:#fff;border:1px solid #71C3B6;margin-left:25px;color:#71C3B6;font-size:14px;">
                Sign in with Jake TV</button>
                </div>
                <div class="col-sm-12 col-lg-6 col-md-6 col-xs-12" >
                <button type="button" id="login_google_button" class="form-control input-lg btn btn-default" style="background:#fff;border:1px solid #FF7676;color:#FF7676;font-size:14px;">
                Sign In with g+</button></div>
                <div class="col-sm-12 col-lg-1 col-md-1 col-xs-12"></div>
            </div>
            <br>
            <div class="row">
            </div>
            <br> 
            </form>
        </div>
 </div>
                 <div class="tab-pane" id="2">

<div class="row" id="register_page">
         <form name="register_form" method="post" style="margin-top:-75px;">
            <div id="reg_validation"></div>
            <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;"><input type="text" id="reg_f_name" name="f_name" value="" placeholder="First Name" class="form-control input-lg" /></div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;">
                <input type="text" id="reg_l_name" name="l_name" value="" placeholder="Last Name" class="form-control input-lg" /></div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;">
                <input type="email" id="reg_email" name="email" value="" placeholder="Email" class="form-control input-lg" /></div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;">
                <input type="password" id="reg_password" name="password" value="" placeholder="Password" class="form-control input-lg" /></div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;">
                <input type="password" id="reg_c_password" name="c_password" value="" placeholder="Confirm Password" class="form-control input-lg" /></div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:35px;">&nbsp;</div>
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
                <button type="button"  class="form-control input-lg btn btn-danger" onClick="login.php" data-dismiss="modal" id="reg_cancel" style="font-size:14px;background:#fff;border:1px solid red;color:red;margin-left:25px;">
                Cancel</button></div>
                <div class="col-md-2 col-sm-12 col-xs-12 col-lg-2"></div>
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4" id="reg_join" onClick="register_join()"> 
                <button type="button"  id="joinbtn" class="form-control input-lg btn btn-primary" 
                style="background:#fff;border:1px solid #71C3B8;color:#71C3B8;margin-left:75px;font-size:14px;">
                Join</button></div>
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
                <div id="errormsg"></div>
            </div>
            </div>
            <div class="row" style="margin-top:20px;">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left:25px;">
                <input type="email" id="fr_email" name="fr_email" value="" placeholder="Email" class="form-control input-lg" /></div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:35px;">&nbsp;</div>
            <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
                <button type="button"  class="form-control input-lg btn btn-danger" onClick="login.php" id="fr_cancel" style="font-size:14px;background:#fff;border:1px solid red;color:red;padding-left:0px;padding-right:0px;margin-left:20px;">
                Cancel</button></div>
                <div class="col-md-2 col-sm-12 col-xs-12 col-lg-2"></div>
                <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4" id="reg_join" onClick="register_join()" style="margin-left:15px;"> 
                <button type="button"  id="frbtn" class="form-control input-lg btn btn-primary" 
                style="background:#fff;border:1px solid #71C3B8;color:#71C3B8;font-size:14px;margin-left:73px;" onclick="forgot_password()">
                Submit</button></div>
                <div class="col-md-1 col-sm-12 col-xs-12 col-lg-1"></div>
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

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
function description_length()
{
var yourString = $("#desc").text();
var stripped = yourString .substr(0, 10);
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
})

$(document).ready(function(e) {	
	$("#login_detail").click(function(e) {
  $("#register_page").hide();
  $("#login_page").show();
  $("#login_detail").css("color","#185BAE");
  $("#register").css("color","#333");
    });
 
    $("#register").click(function(e) {
  $("#register_page").show();
  $("#login_page").hide();
  $("#login_detail").css("color","#333");
  $("#register").css("color","#185BAE");
    });
 $("#viewmore").click(function(e) {
        $("#moredesc").show();
  $("#viewless").show();
  $('.post_desc').css('heigth','900px');
    });
 $("#viewless").click(function(e) {
  $("#moredesc").hide();
  $("#desc").show();
  $("#viewless").hide(); 
    });
});
</script>
<script>
function searcheddata()
{
	var $data = $("#serachdata").val();	
	$.get('service.php',{data:$data,action:'search'}).done(function( data ) {
    	$("#content123").html(data);
  	});
}

function forgot_password()
{
 var email = $("#fr_email").val();
   if($("#fr_email").val()=="")
   {
    $("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>");
    setTimeout(function() { 
    document.getElementById("errormsg").innerHTML = '';
    document.getElementById('email').focus(); 
    }, 5000);
   }
   else
   {
    $.ajax({
     url : 'service.php',
     type : 'post',
     data: 'forgotpassword=1&fr_email='+email,    
     success : function(data) 
     {
      if(data == '1'){
       document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Check Your mail to reset pasword.</div>";
      }else{
      document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Invalid Email id.</div>";
      }
     }
    });
   }
}

</script>
</body>
</html>
