<?php
include('service.php');
include('secure/customjs.php');
if(isset($_SESSION['sessionid'])){
$obj = new service_class();
$sessid = $_SESSION['sessionid'];
if(isset($sessid)){
	$s = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='".$sessid."'");
	$userid = $s['userid'];
}
if(isset($userid))
{
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
	$total_likes_rows = count($responsedata);
	if(!empty($responsedata))
	{
		if(isset($_SESSION['likes_pagedata'])){
			@$PageLimit = $_SESSION['likes_pagedata'];
		}else{
			@$PageLimit = 6;
		}
		
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- materialize bootstrap -->
<link rel="stylesheet" href="css/bootstrap-material-design.css">
<link rel="stylesheet" href="css/ripples.min.css">
<!-- materialize bootstrap complete-->
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
    <div class="row" id="content_likes">
    	<div class="row" id="search_button">
        
         <div class="col-lg-8">
        <div class="form-group  label-floating" id="home_search_css">
          <label for="i5" class="control-label">Search</label>
          <input type="text" class="form-control input-lg" id="serachdata" onKeyUp="likes_searcheddata()" style="border:none;border-bottom:1px solid #00AA9A;" />
        </div>
      </div>
            <!--<div class="col-lg-2">
                  <button type="button" class="btn-raised" id="btsearch">SEARCH</button>
              </div>-->
             
    	</div>
    	<!--<div class="row">
        	<div class="col-md-5"></div>
            <div class="col-md-2">
            	<h3 align="center" style="font-size:30px;">Liked Post</h3>
            </div>
            <div class="col-md-5"></div>
        </div>
        <br><br>-->
        <div class="search_likes_post"></div>
        <div class="row content123_likes">
        <?php
			if(isset($fetch_post)):
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
													 $qry_cat = $obj->qry_fetchRows("SELECT category FROM `tbl_category` WHERE `catidu` IN (".$catid.") AND status='1' order by catid desc");
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
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
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
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
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
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
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
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
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
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
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
													 foreach($qry_cat as $qry_cat){
														 echo $qry_cat['category'];
													 }
												}			
										?>
                                     </div>
                                     <?php
									if(strlen($fetch_post[$i]['description']) > 400){ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
										</div>
										<div id="seemore<?php echo $fetch_post[$i]['postid'] ?>" style="text-decoration:none; text-align:left; padding-left:0px; padding-right:0px;"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" style="display:none; padding-left:0px; padding-right:0px; text-align:left; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_dec" id="desc<?php echo $fetch_post['postid'] ?>" style="text-align:left; padding-left:0px; padding-right:0px; cursor:pointer;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
										<?php 
										 echo $fetch_post[$i]['description']; ?>
											 </div>
									<?php }
									?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                                <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                    <?php
                                    if(isset($_SESSION['sessionid'])){
                                        if($fetch_post[$i]['isliked'] == 1){ ?>
                                            <a onClick="unlike_post_likes(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="like_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $fetch_post[$i]['postid']; ?>">LIKE</a>
                                            <a onClick="unlike_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="like_post" style="display:none;" class="like_post<?php echo $fetch_post[$i]['postid']; ?>">UNLIKE</a>&nbsp;&nbsp;
                                        <?php } ?>
                                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                                        <?php
                                       
                                        if($fetch_post[$i]['isbookmarked'] == 1){ ?>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>">UNBOOKMARK</a>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
                                        <?php }else{ ?>
                                            <a onClick="bookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $fetch_post[$i]['postid']; ?>">BOOKMARK</a>
                                            <a onClick="unbookmark_post(<?php echo $fetch_post[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $fetch_post[$i]['postid']; ?>" style="display:none;">UNBOOKMARK</a>&nbsp;&nbsp;
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
			else:
			?>
            <p>No records found.</p>
            <?php
			endif;		
		?>
        <div id="likes_new_div"></div>
        
        <?php
		if(isset($_SESSION['likes_pagedata'])){
			if($_SESSION['likes_pagedata'] < $total_likes_rows){ ?>
				<div class="row" id="load_more">
			  <div class="col-sm-5"></div>
			  <div class="col-sm-2" onClick="load_like_page1(<?php if(isset($_SESSION['likes_page'])){echo ($_SESSION['likes_page']);}else{echo "undefined";} ?>,<?php echo $total_likes_rows; ?>)">
				<input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['likes_page'])){echo ($_SESSION['likes_page']+1);}else{echo '1';} ?>"/>
				<button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
				</div>
			  <div class="col-sm-5"></div>
			</div>
			<?php }
		}else if(@$total_likes_rows < 7){ ?>
			
		<?php }else{ ?>
			<div class="row" id="load_more">
			  <div class="col-sm-5"></div>
			  <div class="col-sm-2" onClick="load_like_page1(<?php if(isset($_SESSION['likes_page'])){echo ($_SESSION['likes_page']);}else{echo "undefined";} ?>,<?php echo $total_likes_rows; ?>)">
				<input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['likes_page'])){echo ($_SESSION['likes_page']+1);}else{echo '1';} ?>"/>
				<button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
				</div>
			  <div class="col-sm-5"></div>
			</div>
		<?php }
		?>
        
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
<script src="js/ripples.min.js"></script> 
</body>
</html>
<?php
}else{
	header('location:index.php');
}
?>
