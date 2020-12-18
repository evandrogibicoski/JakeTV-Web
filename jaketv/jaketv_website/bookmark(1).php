<?php
include('service.php');
include('secure/customjs.php');
//include('secure/config.php');

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
	$total_bookmark_rows = count($responsedata);
	if($responsedata!=NULL)
	{
		if(!empty($_SESSION['bookmark_pagedata'])){
			@$PageLimit =  $_SESSION['bookmark_pagedata'];
		}else{
			@$PageLimit = "24";
			//$_SESSION['pagedata'] = $PageLimit;
		}
		
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
    	<!--<div class="row">
        	<div class="col-md-4"></div>
            <div class="col-md-4">
            	<h3 align="center" style="font-size:30px;">Bookmarked Post</h3>
            </div>
            <div class="col-md-4"></div>
        </div>
        <br><br>-->
    <div class="row content123_bookmark">
    <?php
			if(isset($fetch_post)):
			$count = count($fetch_post);
			for ($i = 0; $i < $count; $i++) {
				
				
				if ($i < 3) {
					if ($i < 1) {
						?>
						<div class="row" style="margin-bottom:50px; position:relative;">
							<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
								<div id="fix_column">
                                	<img src="<?php echo $fetch_post[$i]['image']; ?>" id="CatPage_img" width="350px;" height="200px;" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"/>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CtaPage_cicker" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')" style="cursor:pointer;">
									<?php
                                     	echo $str = strtoupper(substr($fetch_post[$i]['kickerline'], 0, 50));
                                     ?>
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Title"  onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									 	<?php echo $fetch_post[$i]['title']; ?> 
                                     </div>
                                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="CatPage_Category" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')"> 
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
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
										<?php 
										  //$desc =$fetch_post['description'];
										  //$strdesc = substr($desc, 0, 40);
										//echo $strdesc;
										 echo substr($fetch_post[$i]['description'],0,330); ?><?php echo "..."; ?>
                                         
										</div>
										<div class="CatPage_Seemore" id="seemore<?php echo $fetch_post[$i]['postid'] ?>"><?php echo "<span onClick='see_more(".$fetch_post[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>	 
											 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc1" id="desc1<?php echo $fetch_post[$i]['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
												<?php echo $fetch_post[$i]['description']; ?>
											 </div>
											 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
									<?php }else{ ?>
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 CatPage_Desc" id="desc<?php echo $fetch_post['postid'] ?>" onClick="window.open('<?php echo $fetch_post[$i]['url']; ?>','_blank')">
									
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
			else:
			?>
            <p>No records found.</p>
            <?php
			endif;		
		?>
        <div id="bookmark_new_div"></div>
    </div>
    		
    </div>
    
    <?php
	if(isset($_SESSION['bookmark_pagedata'])){
		if($_SESSION['bookmark_pagedata'] < $total_bookmark_rows){ ?>
			<div class="row" id="load_more">
          <div class="col-sm-5"></div>
          <div class="col-sm-2" onClick="load_bookmark_page1(<?php if(isset($_SESSION['bookmark_page'])){echo ($_SESSION['bookmark_page']);}else{echo "undefined";} ?>,<?php echo $total_bookmark_rows; ?>)">
            <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['bookmark_page'])){echo ($_SESSION['bookmark_page']+1);}else{echo '1';} ?>"/>
            <button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
            </div>
          <div class="col-sm-5"></div>
        </div>
		<?php }
	}else if(@$total_bookmark_rows < 7){ ?>
		
	<?php }else{ ?>
		<div class="row" id="load_more">
          <div class="col-sm-5"></div>
          <div class="col-sm-2" onClick="load_bookmark_page1(<?php if(isset($_SESSION['bookmark_page'])){echo ($_SESSION['bookmark_page']);}else{echo "undefined";} ?>,<?php echo $total_bookmark_rows; ?>)">
            <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="<?php if(isset($_SESSION['bookmark_page'])){echo ($_SESSION['bookmark_page']+1);}else{echo '1';} ?>"/>
            <button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
            </div>
          <div class="col-sm-5"></div>
        </div>
	<?php }
	?>
        
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
</body>
</html>
<?php
}else{
	header('location: index.php');	
}
?>